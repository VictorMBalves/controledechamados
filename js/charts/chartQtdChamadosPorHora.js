function drawChamadosPorHora() {
    var data = getDataChamadosPorHora();
    if (isEmpty(data)) {
        $("#chart_qtd_chamados_hora").html("Nenhum dado no período");
        return;
    }

    var chart = new google.visualization.AreaChart(document.getElementById('chart_qtd_chamados_hora'));

    chart.draw(data, getDataChamadosPorHora());
}

function getDataChamadosPorHora() {
    var dados = $('#formFiltros').serialize();
    
    var jsonData = $.ajax({
        url: "../charts/loadQtdChamadosPorHora.php",
        data: dados,
        dataType: "json",
        async: false
    }).responseText;

    data = $.parseJSON(jsonData);

    var datatable = new google.visualization.DataTable();
    datatable.addColumn('string', 'Descrição');
    datatable.addColumn('number', 'Quant.');

    for (var i = 0; i < data.length; i++) {
        if(data[i] != null){
            datatable.addRow([(data[i].horas + 'h'), parseInt(data[i].qtd)]);
        }
    }

   return datatable;
}

function getOptionsChamadosPorHora() {
    var options = {
        title: 'Company Performance',
        hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
        vAxis: {minValue: 0}
      };
    return options;
}