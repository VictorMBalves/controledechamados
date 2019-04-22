function drawCategoriaTempo() {
    var data = getDataChamadosTempo();
    if (isEmpty(data)) {
        $("#chart_categoria_tempo").html("Nenhum dado no período");
        return;
    }

    var chart = new google.visualization.PieChart(document.getElementById('chart_categoria_tempo'));

    // The select handler. Call the chart's getSelection() method
    function selectHandler() {        
        var selectedItem = chart.getSelection()[0];
        if (selectedItem) {
            console.log(data.getValue(selectedItem.row, 3))
            if(data.getValue(selectedItem.row, 3) != null)
                preencherTabelaRankingTempo(data.getValue(selectedItem.row, 3), data.getValue(selectedItem.row, 0)  + ' (' + formatTimeDiff(data.getValue(selectedItem.row, 1)) + ')')
        }else{
            $('#rowTableChamadosTempo').hide();
        }
    }
    google.visualization.events.addListener(chart, 'select', selectHandler);
    chart.draw(data,  getOptionsChamadosCategoriaTempo());
}

function getDataChamadosTempo() {
    var dados = $('#formFiltros').serialize();
    
    var jsonData = $.ajax({
        url: "../charts/loadRankingCategoriaTempo.php",
        data: dados,
        dataType: "json",
        async: false
    }).responseText;

    jsonData = $.parseJSON(jsonData);

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Categoria');
    data.addColumn('number', 'Quantidade');  
    data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});
    data.addColumn('string', 'ID');  

    var totalOutros = 0;
    for (var i = 0; i < jsonData.length; i++) {
        if(jsonData[i] != null){
            if(i > 4){
                totalOutros += parseInt(jsonData[i].tempo);
            }else{
                data.addRow([(jsonData[i].descricao.toUpperCase()), parseInt(jsonData[i].tempo), getTootip(jsonData[i].descricao.toUpperCase(), parseInt(jsonData[i].tempo)),  jsonData[i].id]);
            }
        }
    }
    data.addRow([("OUTROS"), parseInt(totalOutros), getTootip("OUTROS", totalOutros),  null]);

    return data;
}

function getOptionsChamadosCategoriaTempo() {
    var options = {
        'chartArea': {'width': '100%', 'height': '80%'},
        pieStartAngle: 50,
        title: 'Top 5',
        tooltip: {isHtml: true}
    };

    return options;
}

function getTootip(descricao, tempo){
    return '<div class="col m-1 text-uppercase">' +
                '<strong>'+descricao +
                '<div class="text-success">Tempo: '+ formatTimeDiff(tempo) + '</strong></div></div>';
}