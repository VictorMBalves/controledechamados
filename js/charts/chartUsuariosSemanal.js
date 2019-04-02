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
        bar: { groupWidth: "90%" },
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