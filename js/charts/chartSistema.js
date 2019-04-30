function drawSistema(tipo) {
    if(tipo == 'Quantidade')
        getDataChamadosSistemaQtd(tipo);
    else getDataChamadosSistemaTempo(tipo);
}

function getDataChamadosSistemaQtd(tipo) {
    var dados = carregaDados();
    dados.push({name: 'tipo_order', value: tipo})

    $.ajax({
        url: "../charts/loadRankingSistema.php",
        data: dados,
        dataType: "json",
        async: true
    }).done(function(response){
        data = response;

        var dataArray = new google.visualization.DataTable();
        dataArray.addColumn('string', 'Sistema');
        dataArray.addColumn('number', 'Quantidade');  
        dataArray.addColumn('string', 'Sistema');

        for (var i = 0; i < data.length; i++) {
            if(data[i] != null){
                dataArray.addRow([(data[i].sistemaAgrupado.toUpperCase() + ' (' + parseInt(data[i].qtd) + ')'), parseInt(data[i].qtd), data[i].sistemaAgrupado.toUpperCase()]);
            }
        }
    
        var chart = new google.visualization.PieChart(document.getElementById('chart_chamados_sistema_top_5'));

        // The select handler. Call the chart's getSelection() method
        function selectHandler() {        
            var selectedItem = chart.getSelection()[0];
            if (selectedItem) {
                preencherTabelaRanking(null, dataArray.getValue(selectedItem.row, 0),  null, false, null, null, dataArray.getValue(selectedItem.row, 2));
            }else{
                $('#rowTableChamados').hide();
            }
        }

        google.visualization.events.addListener(chart, 'select', selectHandler);

        chart.draw(dataArray, getOptionsChamadosSistema());
    });  
}

function getOptionsChamadosSistema() {
    var options = {
        'chartArea': {'width': '100%', 'height': '80%'},
        pieStartAngle: 50
    };

    return options;
}

function getDataChamadosSistemaTempo(tipo) {
    var dados = carregaDados();
    dados.push({name: 'tipo_order', value: tipo})

    $.ajax({
        url: "../charts/loadRankingSistema.php",
        data: dados,
        dataType: "json",
        async: true
    }).done(function(response){
        jsonData = response;

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Sistema');
        data.addColumn('number', 'Quantidade');  
        data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});
        data.addColumn('string', 'Sistema');
    
        for (var i = 0; i < jsonData.length; i++) {
            if(jsonData[i] != null){
                data.addRow([jsonData[i].sistemaAgrupado.toUpperCase() + ' (' + formatTimeDiff(jsonData[i].tempo) + ')', parseInt(jsonData[i].tempo), getTootipClienteChart(jsonData[i].sistemaAgrupado.toUpperCase(), parseInt(jsonData[i].tempo)), jsonData[i].sistemaAgrupado.toUpperCase()]);
            }
        }
    
        var chart = new google.visualization.PieChart(document.getElementById('chart_chamados_sistema_top_5'));

        // The select handler. Call the chart's getSelection() method
        function selectHandler() {        
            var selectedItem = chart.getSelection()[0];
            if (selectedItem) {
                preencherTabelaRanking(null, data.getValue(selectedItem.row, 0),  null, false, null, null, data.getValue(selectedItem.row, 3));
            }else{
                $('#rowTableChamados').hide();
            }
        }

        google.visualization.events.addListener(chart, 'select', selectHandler);

        chart.draw(data, getOptionsChamadosClienteTempo());
    });
}

function getOptionsChamadosClienteTempo() {
    var options = {
        'chartArea': {'width': '100%', 'height': '80%'},
        pieStartAngle: 50,
        tooltip: {isHtml: true},
    };

    return options;
}

function getTootipClienteChart(descricao, tempo){
    return '<div class="col m-1 text-uppercase">' +
                '<strong>'+descricao +
                '<div class="text-success">Tempo: '+ formatTimeDiff(tempo) + '</strong></div></div>';
}