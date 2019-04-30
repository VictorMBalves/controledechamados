function drawCliente(tipo) {
    if(tipo == 'Quantidade')
        getDataChamadosClienteQtd(tipo);
    else getDataChamadosClienteTempo(tipo);
}

function getDataChamadosClienteQtd(tipo) {
    var dados = carregaDados();
    dados.push({name: 'tipo_order', value: tipo})

    $.ajax({
        url: "../charts/loadRankingCliente.php",
        data: dados,
        dataType: "json",
        async: true
    }).done(function(response){
        data = response;

        var dataArray = new google.visualization.DataTable();
        dataArray.addColumn('string', 'Empresa');
        dataArray.addColumn('number', 'Quantidade');  
        dataArray.addColumn('string', 'Empresa'); 

        var totalOutros = 0;
        for (var i = 0; i < data.length; i++) {
            if(data[i] != null){
                if(i > 4){
                    totalOutros += parseInt(data[i].qtd);
                }else{
                    dataArray.addRow([(data[i].empresa.toUpperCase() + '(' + data[i].qtd + ')'), parseInt(data[i].qtd), data[i].empresa]);
                }
            }
        }
        dataArray.addRow([("OUTROS" + '(' + totalOutros + ')'), totalOutros, null]);
    
        var chart = new google.visualization.PieChart(document.getElementById('chart_chamados_cliente_top_5'));

        // The select handler. Call the chart's getSelection() method
        function selectHandler() {        
            var selectedItem = chart.getSelection()[0];
            if (selectedItem) {
                if(dataArray.getValue(selectedItem.row, 2) != null)
                    preencherTabelaRanking(null, dataArray.getValue(selectedItem.row, 0),  null, false, null, dataArray.getValue(selectedItem.row, 2));
            }else{
                $('#rowTableChamados').hide();
            }
        }

        google.visualization.events.addListener(chart, 'select', selectHandler);

        chart.draw(dataArray, getOptionsChamadosCliente());
    });  
}

function getOptionsChamadosCliente() {
    var options = {
        'chartArea': {'width': '100%', 'height': '80%'},
        pieStartAngle: 50
    };

    return options;
}

function getDataChamadosClienteTempo(tipo) {
    var dados = carregaDados();
    dados.push({name: 'tipo_order', value: tipo});

    $.ajax({
        url: "../charts/loadRankingCliente.php",
        data: dados,
        dataType: "json",
        async: true
    }).done(function(response){
        jsonData = response;

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Empresa');
        data.addColumn('number', 'Quantidade');  
        data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});
        data.addColumn('string', 'Empresa');
    
        var totalOutros = 0;
        for (var i = 0; i < jsonData.length; i++) {
            if(jsonData[i] != null){
                if(i > 4){
                    totalOutros += parseInt(jsonData[i].tempo);
                }else{
                    data.addRow([jsonData[i].empresa.toUpperCase(), parseInt(jsonData[i].tempo), getTootipClienteChart(jsonData[i].empresa.toUpperCase(), parseInt(jsonData[i].tempo)), jsonData[i].empresa]);
                }
            }
        }
        data.addRow([("OUTROS"), parseInt(totalOutros), getTootipClienteChart("OUTROS", totalOutros), null]);
    
        var chart = new google.visualization.PieChart(document.getElementById('chart_chamados_cliente_top_5'));

        // The select handler. Call the chart's getSelection() method
        function selectHandler() {        
            var selectedItem = chart.getSelection()[0];
            if (selectedItem) {
                if(data.getValue(selectedItem.row, 3) != null)
                    preencherTabelaRanking(null, data.getValue(selectedItem.row, 0),  null, false, null, data.getValue(selectedItem.row, 3));
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