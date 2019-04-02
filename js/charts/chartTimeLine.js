var dataTempoMedioAtendimento;

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