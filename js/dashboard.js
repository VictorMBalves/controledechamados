$( document ).ready(function() {
    $("#liDashboard").addClass('active')
});

google.charts.load('current', { callback: drawCharts, 'packages': ['corechart', 'line','timeline'], 'language': 'pt-br' });
var chartUsuario;
var chartCategoria;
var chartRank;
var chartPorHora;
var chartTempoMedioAtendimento;


function chamadospendentes() {
    var url = "../pages/chamadospendentes.php?continue=true";
    jQuery("#pendentes").load(url, function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
}

function chamadosatrasados() {
    var url = "../pages/chamadosatrasados.php?continue=true";
    jQuery("#atrasados").load(url, function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
}

function chamadoagendados() {
    var url = "../pages/chamadosagendados.php?continue=true";
    jQuery("#agendados").load(url, function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
}

function chamadoandamento() {
    var url = "../pages/chamadosandamento.php?continue=true";
    jQuery("#andamento").load(url, function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
}


$(function () {
    chamadoandamento();
    chamadosatrasados();
    chamadospendentes();
    chamadoagendados();
});

setInterval(function () {
    chamadoandamento();
    chamadosatrasados();
    chamadospendentes();
    chamadoagendados();
}, 30000);//

function drawCharts() {
    // console.log();
    chartUsuario = new google.visualization.BarChart(document.getElementById('chart_div'));
    chartCategoria = new google.visualization.BarChart(document.getElementById('chart_div2'));
    chartRank = new google.visualization.ColumnChart(document.getElementById("chart_div3"));
    chartPorHora = new google.visualization.LineChart(document.getElementById('chart_div4'));
    chartTempoMedioAtendimento = new google.visualization.Timeline(document.getElementById('chart_div5'));
    drawChamadosPorCategoria()
    drawChamadosPorAtendente()
    drawRankAtendentes()
    drawChamadosPorHora()
    drawChartTempoMedioAtendimento()
    notificationSuccess("Sucesso", "Gráfico gerado com sucesso")
}

$("#btnChamadoAtendente").on("click", function () {
    $(this).html('<img src="../imagem/ajax-loader.gif">');
    drawChamadosPorAtendente()
    $(this).html("Gerar");
    return false;
})

$("#btnChamadoCategoria").on("click", function () {
    $(this).html('<img src="../imagem/ajax-loader.gif">');
    drawChamadosPorCategoria()
    $(this).html("Gerar");
    return false;
})

$("#btnRankAtendentes").on("click", function () {
    $(this).html('<img src="../imagem/ajax-loader.gif">');
    drawRankAtendentes()
    $(this).html("Gerar");
    return false;
})

$("#btnChamadosPorHora").on("click", function () {
    $(this).html('<img src="../imagem/ajax-loader.gif">');
    drawChamadosPorHora()
    $(this).html("Gerar");
    return false;
})

$("#btnTempoMedioAtendimento").on("click", function(){
    $(this).html('<img src="../imagem/ajax-loader.gif">');
    drawChartTempoMedioAtendimento()
    $(this).html("Gerar");
    return false;
})


function drawChamadosPorCategoria() {
    // event.preventDefault(event);
    var dados = getDataChamadosPorCategoria();
    if (isEmpty(dados)) {
        $("#chart_div2").html("Nenhum dado no período");
        return;
    }
    chartCategoria.clearChart();
    chartCategoria.draw(dados, getOptionsChamadosPorCategoria());
    // return false;
}

function getDataChamadosPorCategoria() {
    var dados = $('#form2').serialize();
    var jsonData = $.ajax({
        url: "../charts/loadPeriodoCategoriaChart.php",
        dataType: "json",
        data: dados,
        async: false
    }).responseText;

    if (isEmpty($.parseJSON(jsonData))) {
        notificationWarningOne("Nenhum registro no período informado")
        return null;
    }
    return google.visualization.arrayToDataTable($.parseJSON(jsonData));
}

function getOptionsChamadosPorCategoria() {
    var options = {
        animation: {
            startup: true,
            duration: 1000,
            easing: 'out'
        },
        chartArea: {
            left: 100,
            top: 10,
            width: '70%',
            height: '70%'
        },
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
            },
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
        legend: { position: "bottom", maxLines: 4 },
    };

    return options;
}

function drawChamadosPorAtendente() {
    //event.preventDefault(event);
    var dados = getDataChamadosPorAtendente();
    if (isEmpty(dados)) {
        $("#chart_div").html("Nenhum dado no período");
        return;
    }
    chartUsuario.clearChart()
    chartUsuario.draw(dados, getOptionsChamadosPorAtendente());
    // return false;
}

function getDataChamadosPorAtendente() {
    var dados = $('#form1').serialize();
    var jsonData = $.ajax({
        url: "../charts/loadPeriodoAtendenteChart.php",
        dataType: "json",
        data: dados,
        async: false
    }).responseText;

    if (isEmpty($.parseJSON(jsonData))) {
        notificationWarningOne("Nenhum registro no período informado")
        return null;
    }

    return google.visualization.arrayToDataTable($.parseJSON(jsonData));
}

function getOptionsChamadosPorAtendente() {
    var options = {
        chartArea: {
            left: 100,
            top: 10,
            width: '70%',
            height: '70%'
        },
        // bar: { groupWidth: "90%" },
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
    //event.preventDefault(event);
    var dados = getDataRankAtendentes();
    if (isEmpty(dados)) {
        $("#chart_div3").html("Nenhum dado no período");
        return;
    }
    chartRank.clearChart();
    chartRank.draw(dados, getOptionsRankAtendentes());
    // return false;
}

function getDataRankAtendentes() {
    $('#dataRank').html(Date.parse($("#dtInicialRank").val()).toString('d/MM/yyyy'))
    var dados = $('#formRankAtendentes').serialize();
    var jsonData = $.ajax({
        url: "../charts/loadRankAtendentes.php",
        data: dados,
        dataType: "json",
        async: false
    }).responseText;
    if (isEmpty($.parseJSON(jsonData))) {
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
    //event.preventDefault(event);
    var dados = getDataChamadosPorHora();
    if (isEmpty(dados)) {
        $("#chart_div4").html("Nenhum dado no período");
        return;
    }
    chartPorHora.clearChart();
    chartPorHora.draw(dados, getOptionsChamadosPorHora());
    // return false;
}

function getDataChamadosPorHora() {
    $('#dataChamadosPorHora').html(Date.parse($("#dtInicialPorHora").val()).toString('d/MM/yyyy'))
    var dados = $('#formChamadosPorHora').serialize();
    var jsonData = $.ajax({
        url: "../charts/loadChamadosPorHora.php",
        dataType: "json",
        data: dados,
        async: false
    }).responseText;

    if (isEmpty($.parseJSON(jsonData))) {
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
    //event.preventDefault(event);
    var dataJson = getDataChamadosTempoMedioAtendimento();
    var data;
    if (isEmpty(dataJson)) {
        $("#chart_div5").html("Nenhum dado no período");
        return;
    }

    if($("#tipoTempoMedioAtendimento").val() == "2"){
       data = getEstruturaTempoMedioUsuario(dataJson);
    }else {
        data = getEstruturaTempoMedioEmpresa(dataJson);
    }
    

    var options = {
        timeline: { showRowLabels: true },
        hAxis: {
            format: 'dd/MM HH:mm:ss',
            gridlines: {count: 15}
          },
          vAxis: {
            gridlines: {color: 'none'},
            minValue: 0
          }
    };

    
    chartTempoMedioAtendimento.clearChart()
    chartTempoMedioAtendimento.draw(data, options);
    // return false;
  }

function getDataChamadosTempoMedioAtendimento() {
    $('#dataTempoMedioAtendimento').html(Date.parse($("#dtInicialTempoMedioAtendimento").val()).toString('d/MM/yyyy'))
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
function getEstruturaTempoMedioUsuario(dataJson){
    var rows = [];
        for (let i = 0; i < dataJson.length; i++) {
            rows.push({c: [ {v: dataJson[i].usuario}, {v: dataJson[i].empresa}, {v: Date.parse(dataJson[i].datainicio)}, {v: Date.parse(dataJson[i].datafinal)}]});
        }
    var data = new google.visualization.DataTable({
      cols: [
        {id: 'usuario', label: 'Usuario', type: 'string'},
        {id: 'empresa', label: 'Empresa', type: 'string'},
        {id: 'inicio', label: 'Início atendimento', type: 'date'},
        {id: 'fim', label: 'Fim atendimento', type: 'date'}
      ],
      rows
    });

    return data;
}

function getEstruturaTempoMedioEmpresa(dataJson){
    var rows = [];
        for (let i = 0; i < dataJson.length; i++) {
            rows.push({c: [  {v: dataJson[i].empresa}, {v: dataJson[i].usuario}, {v: Date.parse(dataJson[i].datainicio)}, {v: Date.parse(dataJson[i].datafinal)}]});
        }
    var data = new google.visualization.DataTable({
      cols: [
        {id: 'empresa', label: 'Empresa', type: 'string'},
        {id: 'usuario', label: 'Usuario', type: 'string'},
        {id: 'inicio', label: 'Início atendimento', type: 'date'},
        {id: 'fim', label: 'Fim atendimento', type: 'date'}
      ],
      rows
    });

    return data;
}