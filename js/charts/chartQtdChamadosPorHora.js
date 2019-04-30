function drawChamadosPorHora() {
    var data = getDataChamadosPorHora();
    if (isEmpty(data)) {
        $("#chart_qtd_chamados_hora").html("Nenhum dado no período");
        return;
    }
    var chart = new google.visualization.AreaChart(document.getElementById('chart_qtd_chamados_hora'));
    
    function selectHandler() {
        var selectedItem = chart.getSelection()[0];
        if (selectedItem) {
            preencherTabelaRanking(null, data.getValue(selectedItem.row, 0) + ' (' + data.getValue(selectedItem.row, 1) + ')', null, null, parseInt(data.getValue(selectedItem.row,0 )));
        }else{
            $('#rowTableChamados').hide();
        }
    }

    google.visualization.events.addListener(chart, 'select', selectHandler);

    chart.draw(data, getOptionsChamadosPorHora());
}

function getDataChamadosPorHora() {
    var dados = carregaDados();
    
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
    datatable.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});
    for (var i = 0; i < data.length; i++) {
        if(data[i] != null){            
            datatable.addRow([(data[i].horas + 'h'), parseInt(data[i].qtd), getTootipChamadoHora(data[i].descricao, parseInt(data[i].qtd))]);
        }
    }

   return datatable;
}

function getOptionsChamadosPorHora() {
    var options = {
        hAxis: {title: 'Período',  titleTextStyle: {color: '#333'}},
        vAxis: {minValue: 0},
        tooltip: {isHtml: true}
      };
    return options;
}

function getTootipChamadoHora(descricao, tempo){
    return '<div class="col m-1 text-uppercase">' +
                '<strong>'+descricao +
                '<div class="text-success">Quantidade: '+ tempo + '</strong></div></div>';
}