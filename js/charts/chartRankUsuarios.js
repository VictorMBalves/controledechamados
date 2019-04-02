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
            left: 60,
            top: 10,
            width: '90%',
            height: '90%'
        },
        vAxis: {
            title: 'Nº Chamados',
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