var dataTempoMedioAtendimento;
$(document).ready(()=> {
    progressEvent("Executando", "Gerando gráficos")
    $("#liDashboard").addClass('active')
});

window.onload = ()=>{
    google.charts.load('current', { callback: drawCharts, 'packages': ['corechart', 'line', 'timeline'], 'language': 'pt-br' });
};

function chamadospendentes() {
    var url = "../pages/chamadospendentes.php?continue=true";
    jQuery("#pendentes").load(url);
}

function chamadosatrasados() {
    var url = "../pages/chamadosatrasados.php?continue=true";
    jQuery("#atrasados").load(url);
}

function chamadoagendados() {
    var url = "../pages/chamadosagendados.php?continue=true";
    jQuery("#agendados").load(url);
}

function chamadoandamento() {
    var url = "../pages/chamadosandamento.php?continue=true";
    jQuery("#andamento").load(url);
}


$(()=>{
    chamadoandamento();
    chamadosatrasados();
    chamadospendentes();
    chamadoagendados();
});

setInterval(()=>{
    chamadoandamento();
    chamadosatrasados();
    chamadospendentes();
    chamadoagendados();
}, 30000);//

function drawCharts() {
    drawChamadosPorCategoria()
    drawChamadosPorAtendente()
    drawRankAtendentes()
    drawChamadosPorHora()
    drawChartTempoMedioAtendimento()
    notificationSuccess("Sucesso", "Gráficos gerados com sucesso")
    
}

$("#btnChamadoAtendente").on("click", ()=> {
    drawChamadosPorAtendente()
    return false;
})

$("#btnChamadoCategoria").on("click", ()=> {
    drawChamadosPorCategoria()
    return false;
})

$("#btnRankAtendentes").on("click", ()=> {
    drawRankAtendentes()
    return false;
})

$("#btnChamadosPorHora").on("click", ()=> {
    drawChamadosPorHora()
    return false;
})

$("#btnTempoMedioAtendimento").on("click", ()=> {
    drawChartTempoMedioAtendimento();
    return false;
})


function drawChamadosPorCategoria() {
    var dados = getDataChamadosPorCategoria();
    if (isEmpty(dados)) {
        $("#chart_div2").html("Nenhum dado no período");
        return;
    }
    chartCategoria = new google.visualization.PieChart(document.getElementById('chart_div2'));
    chartCategoria.draw(dados, getOptionsChamadosPorCategoria());
}

function getDataChamadosPorCategoria() {
    $('#dataChamadosCategoria').html(Date.parse($("#dtInicial2").val()).toString('dd/MM/yyyy'))
    $('#dataFinalChamadosCategoria').html(Date.parse($("#dtFinal2").val()).toString('dd/MM/yyyy'))
    var dados = $('#form2').serialize();
    var dataJson = $.ajax({
        url: "../charts/loadPeriodoCategoriaChart.php",
        dataType: "json",
        data: dados,
        async: false
    }).responseText;

    dataJson = $.parseJSON(dataJson);
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Categoria');
    data.addColumn('number', 'Quantidade');  
    data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});
    var total = 0;
    for (let i = 0; i < dataJson.length; i++) {
          total += Number(dataJson[i].quantidade);
    }
    console.log();
    for (let i = 0; i < dataJson.length; i++) {
        data.addRow([dataJson[i].descricao, Number(dataJson[i].quantidade), getTootip(dataJson[i] ,total)]);
    }
   
    return data;
}

function getTootip(data, total){

    var pPos = parseInt(total);
    var pEarned = parseInt(data.quantidade);  
    var perc="";
    if(isNaN(pPos) || isNaN(pEarned)){
        perc=" ";
    }else{
       perc = ((pEarned/pPos) * 100).toFixed(1);
    }

    icon = '<i class="fas fa-cubes m-1"></i>';
    if(data.categoria == "ERROS"){
        icon = '<i class="fas fa-bug m-1"></i>';
    }else if(data.categoria == "DÚVIDAS"){
        icon = '<i class="fas fa-question m-1"></i>';
    }
    return '<div class="col m-1 text-uppercase">'
                +icon+
                '<strong>'+data.descricao+
                '<div class="text-success">QTD: '+data.quantidade +" <br/>"+perc+'%</p></strong></div>';
}

function getOptionsChamadosPorCategoria() {
    var options = {
        chartArea: {
            // left: 100,
            // top: 10,
            width: '90%',
            height: '100%'
        },
        tooltip: {isHtml: true}
      };
    return options;
}

function drawChamadosPorAtendente() {
    var dados = getDataChamadosPorAtendente();
    if (isEmpty(dados)) {
        $("#chart_div").html("Nenhum dado no período");
        return;
    }
    chartUsuario = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chartUsuario.draw(dados, getOptionsChamadosPorAtendente());
}

function getDataChamadosPorAtendente() {
    $('#datainicioPorAtendente').html(Date.parse($("#dtInicial1").val()).toString('dd/MM/yyyy'))
    $('#dataFinalPorAtendente').html(Date.parse($("#dtFinal1").val()).toString('dd/MM/yyyy'))
    var dados = $('#form1').serialize();
    var jsonData = $.ajax({
        url: "../charts/loadPeriodoAtendenteChart.php",
        dataType: "json",
        data: dados,
        async: false
    }).responseText;

    if (isEmpty(jsonData)) {
        return null;
    }

    return google.visualization.arrayToDataTable($.parseJSON(jsonData));
}

function getOptionsChamadosPorAtendente() {
    var options = {
        chartArea: {
            left: 80,
            top: 10,
            width: '80%',
            height: '70%'
        },
        bar: { groupWidth: "100%" },
        lineWidth: 1,
        hAxis: {
            title: 'Nº de chamados atendidos',
            minValue: 0,
            textStyle: {
                bold: true,
                fontSize: 12,
                color: '#4d4d4d'
            },
            titleTextStyle: {
                bold: true,
                fontSize: 18,
                color: '#4d4d4d'
            }
        },
        vAxis: {
            title: 'Dia',
            textStyle: {
                fontSize: 14,
                bold: true,
                color: '#848484'
            },
            titleTextStyle: {
                fontSize: 14,
                bold: true,
                color: '#848484'
            }
        },
        animation: {
            startup: true,
            duration: 1000,
            easing: 'out'
        },
        legend: { position: "bottom", maxLines: 4 }
    };
    return options;
}

function drawRankAtendentes() {
    var dados = getDataRankAtendentes();
    if (isEmpty(dados)) {
        $("#chart_div3").html("Nenhum dado no período");
        return;
    }
    chartRank = new google.visualization.ColumnChart(document.getElementById("chart_div3"));
    chartRank.draw(dados, getOptionsRankAtendentes());
}

function getDataRankAtendentes() {
    $('#dataRank').html(Date.parse($("#dtInicialRank").val()).toString('dd/MM/yyyy'))
    var dados = $('#formRankAtendentes').serialize();
    var jsonData = $.ajax({
        url: "../charts/loadRankAtendentes.php",
        data: dados,
        dataType: "json",
        async: false
    }).responseText;
    if (isEmpty(jsonData)) {
        return null;
    }
    return google.visualization.arrayToDataTable($.parseJSON(jsonData));
}

function getOptionsRankAtendentes() {
    var options = {
        chartArea: {
            left: 40,
            top: 10,
            width: '90%',
            height: '80%'
        },
        legend: { position: "none", maxLines: 3 },
        animation: {
            startup: true,
            duration: 1000,
            easing: 'out'
        },
        lineWidth: 1,
        intervals: { style: 'bars' },
        isStacked: true
    };
    return options;
}

function drawChamadosPorHora() {
    var dados = getDataChamadosPorHora();
    if (isEmpty(dados)) {
        $("#chart_div4").html("Nenhum dado no período");
        return;
    }
    chartPorHora = new google.visualization.LineChart(document.getElementById('chart_div4'));
    chartPorHora.draw(dados, getOptionsChamadosPorHora());
}

function getDataChamadosPorHora() {
    $('#dataChamadosPorHora').html(Date.parse($("#dtInicialPorHora").val()).toString('dd/MM/yyyy'))
    var dados = $('#formChamadosPorHora').serialize();
    var jsonData = $.ajax({
        url: "../charts/loadChamadosPorHora.php",
        dataType: "json",
        data: dados,
        async: false
    }).responseText;

    if (isEmpty(jsonData)) {
        return null;
    }
    return google.visualization.arrayToDataTable($.parseJSON(jsonData));
}

function getOptionsChamadosPorHora() {
    var options = {
        backgroundColor: 'transparent',
        colors: ['cornflowerblue', 'tomato'],
        fontName: 'Open Sans',
        focusTarget: 'category',
        chartArea: {
            left: 50,
            top: 10,
            width: '100%',
            height: '70%'
        },
        hAxis: {
            viewWindow: {
                min: new Date(2014, 11, 31, 18),
                max: new Date(2015, 0, 3, 1)
            },
            gridlines: {
                count: -1,
                units: {
                    days: { format: ['MMM dd'] },
                    hours: { format: ['HH:mm', 'ha'] },
                }
            },
            minorGridlines: {
                units: {
                    hours: { format: ['hh:mm:ss a', 'ha'] },
                    minutes: { format: ['HH:mm a Z', ':mm'] }
                }
            }
        },
        vAxis: {
            baselineColor: '#DDD',
            gridlines: {
                color: '#DDD',
                count: 4
            },
            textStyle: {
                fontSize: 11
            }
        },
        legend: {
            position: 'bottom',
            textStyle: {
                fontSize: 12
            }
        },
        animation: {
            startup: true,
            duration: 1000,
            easing: 'out'
        }
    };
    return options;
}

function drawChartTempoMedioAtendimento() {
    var dataJson = getDataChamadosTempoMedioAtendimento();

    tempoMedio()

    if (isEmpty(dataJson)) {
        $("#chart_div5").html("Nenhum dado no período");
        return;
    }

    if ($("#tipoTempoMedioAtendimento").val() == "2") {
        dataTempoMedioAtendimento = getEstruturaTempoMedioUsuario(dataJson);
    } else {
        dataTempoMedioAtendimento = getEstruturaTempoMedioEmpresa(dataJson);
    }


    var options = {
        timeline: { showRowLabels: true },
        hAxis: {
            format: 'dd/MM HH:mm:ss',
            gridlines: { count: 15 }
        },
        vAxis: {
            gridlines: { color: 'none' },
            minValue: 0
        },
        animation: {
            startup: true,
            duration: 1000,
            easing: 'out'
        },
    };

    chartTempoMedioAtendimento = new google.visualization.Timeline(document.getElementById('chart_div5'));
    google.visualization.events.addListener(chartTempoMedioAtendimento, 'select', ()=>{
        var selection = chartTempoMedioAtendimento.getSelection();
        if (selection.length > 0) {
            var id = dataTempoMedioAtendimento.getValue(selection[0].row, 1);
            var id = id.match(/(?<=\[)\d+(?=\])/);
            link = "timeline="+id[0];
            toastr.options = {
                "positionClass": "toast-top-right",
            }
            toastr.success("<a href='"+link+"' target='_blank'>Deseja visualizar a timeline detalhada para o chamado Nº"+id[0]+"?</a>", "Timeline");
        }
    });
    chartTempoMedioAtendimento.draw(dataTempoMedioAtendimento, options);
}

function tempoMedio() {
    tempoMedioAtendimento = getDataTempoMedioAtendimento();
    icone = $("#iconatrasados");
    icone.className = '';
    if (!isEmpty(tempoMedioAtendimento)) {
        
        $("#media").html(tempoMedioAtendimento.tempo);
        $("#atendidos").html(tempoMedioAtendimento.numeroChamados);
        $("#atrasaram").html(tempoMedioAtendimento.numeroChamadosatrasados)

        if (tempoMedioAtendimento.numeroChamadosatrasados == 0) {
            icone.addClass("far fa-smile fa-2x text-gray-600")
        } else if (tempoMedioAtendimento.numeroChamadosatrasados > 0 && tempoMedioAtendimento.numeroChamadosatrasados < 5) {
            icone.addClass("far fa-meh fa-2x text-gray-600")
        } else if (tempoMedioAtendimento.numeroChamadosatrasados > 10) {
            icone.addClass("far fa-sad-cry fa-2x text-gray-600")
        } else {
            icone.addClass("far fa-frown fa-2x text-gray-600")
        }
    }
}

function getDataChamadosTempoMedioAtendimento() {
    $('#dataTempoMedioAtendimento').html(Date.parse($("#dtInicialTempoMedioAtendimento").val()).toString('dd/MM/yyyy'))
    $('#dataFinalTempoMedioAtendimento').html(Date.parse($("#dtFinalTempoMedioAtendimento").val()).toString('dd/MM/yyyy'))
    var dados = $('#formTempoMedioAtendimento').serialize();
    var jsonData = $.ajax({
        url: "../charts/loadTempoMedioAtendimento.php",
        dataType: "json",
        data: dados,
        async: false
    }).responseText;

    if (isEmpty($.parseJSON(jsonData))) {
        return null;
    }
    return $.parseJSON(jsonData);
}
function getEstruturaTempoMedioUsuario(dataJson) {
    var rows = [];
    for (let i = 0; i < dataJson.length; i++) {
        rows.push({ c: [{ v: dataJson[i].usuario }, { v: "["+dataJson[i].id_chamado+"] "+dataJson[i].empresa }, { v: Date.parse(dataJson[i].datainicio) }, { v: Date.parse(dataJson[i].datafinal) }]});
    }
    var data = new google.visualization.DataTable({
        cols: [
            { id: 'usuario', label: 'Usuario', type: 'string' },
            { id: 'empresa', label: 'Empresa', type: 'string' },
            { id: 'inicio', label: 'Início atendimento', type: 'date' },
            { id: 'fim', label: 'Fim atendimento', type: 'date' }
        ],
        rows
    });

    return data;
}

function getEstruturaTempoMedioEmpresa(dataJson) {
    var rows = [];
    for (let i = 0; i < dataJson.length; i++) {
        rows.push({ c: [{ v: dataJson[i].empresa }, { v: "["+dataJson[i].id_chamado+"] "+dataJson[i].usuario }, { v: Date.parse(dataJson[i].datainicio) }, { v: Date.parse(dataJson[i].datafinal) }]});
    }
    var data = new google.visualization.DataTable({
        cols: [
            { id: 'empresa', label: 'Empresa', type: 'string' },
            { id: 'usuario', label: 'Usuario', type: 'string' },
            { id: 'inicio', label: 'Início atendimento', type: 'date' },
            { id: 'fim', label: 'Fim atendimento', type: 'date' }
        ],
        rows
    });

    return data;
}


function getDataTempoMedioAtendimento() {
    var dados = $('#formTempoMedioAtendimento').serialize();
    var jsonData = $.ajax({
        url: "../charts/tempomedioatendimento.php",
        dataType: "json",
        data: dados,
        async: false
    }).responseText;

    if (isEmpty($.parseJSON(jsonData))) {
        return null;
    }
    return $.parseJSON(jsonData);
}