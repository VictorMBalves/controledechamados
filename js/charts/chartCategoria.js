function drawCategoria(tipo) {
    var data;
    if(tipo == 'Quantidade')
        data = getDataChamadosQtd();
    else data = getDataChamadosTempo();

    if (isEmpty(data)) {
        $("#chart_categoria_qtd").html("Nenhum dado no período");
        return;
    }

    var chart = new google.visualization.PieChart(document.getElementById('chart_categoria_qtd'));

    // The select handler. Call the chart's getSelection() method
    function selectHandler() {        
        var selectedItem = chart.getSelection()[0];
        if (selectedItem) {
            if(tipo == 'Quantidade'){
                if(data.getValue(selectedItem.row, 2) != null)
                    preencherTabelaRanking(data.getValue(selectedItem.row, 2), data.getValue(selectedItem.row, 0), null, $('#textTabela1'), $('.table-ranking'), $('#rowTableChamados'))
            } else {
                if(data.getValue(selectedItem.row, 3) != null)
                    preencherTabelaRanking(data.getValue(selectedItem.row, 3), data.getValue(selectedItem.row, 0), null, $('#textTabela1'), $('.table-ranking'), $('#rowTableChamados'))
            }
        }else{
            $('#rowTableChamados').hide();
        }
    }

    google.visualization.events.addListener(chart, 'select', selectHandler);

    if(tipo == 'Quantidade')
        chart.draw(data, getOptionsChamadosCategoria());
    else chart.draw(data, getOptionsChamadosCategoriaTempo());
    
}

function getDataChamadosQtd() {
    var dados = carregaDados();

    var jsonData = $.ajax({
        url: "../charts/loadRankingCategoriaQtd.php",
        data: dados,
        dataType: "json",
        async: false
    }).responseText;

    data = $.parseJSON(jsonData);

    var dataArray = [
        ['Categoria', 'Quantidade', 'ID'],
    ];
    var totalOutros = 0;
    for (var i = 0; i < data.length; i++) {
        if(data[i] != null){
            if(i > 4){
                totalOutros += parseInt(data[i].qtd);
            }else{
                dataArray.push([(data[i].descricao.toUpperCase() + '(' + data[i].qtd + ')'), parseInt(data[i].qtd), data[i].id]);
            }
        }
    }
    dataArray.push([("OUTROS" + '(' + totalOutros + ')'), totalOutros, null]);

    return google.visualization.arrayToDataTable(dataArray);
}

function getOptionsChamadosCategoria() {
    var options = {
        'chartArea': {'width': '100%', 'height': '80%'},
        pieStartAngle: 50,
        title: 'Top 5'
    };

    return options;
}
function getDataChamadosTempo() {
    var dados = carregaDados();
    
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