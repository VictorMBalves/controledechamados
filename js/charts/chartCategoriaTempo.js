function drawCategoriaTempo() {
    var dados = getDataRankingChamadosTempo();
    if (isEmpty(dados)) {
        $("#chart_categoria_tempo").html("Nenhum dado no período");
        return;
    }

    var chart = new google.visualization.PieChart(document.getElementById('chart_categoria_tempo'));
    var data = getDataChamadosTempo();
    chart.draw(data, getOptionsChamadosCategoria());
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

    var totalOutros = 0;
    for (var i = 0; i < jsonData.length; i++) {
        if(jsonData[i] != null){
            if(i > 4){
                totalOutros += parseInt(jsonData[i].tempo);
            }else{
                data.addRow([(jsonData[i].descricao), parseInt(jsonData[i].tempo), getTootip(jsonData[i].descricao, parseInt(jsonData[i].tempo))]);
            }
        }
    }
    console.log(totalOutros)
    data.addRow([("OUTROS"), parseInt(totalOutros), getTootip("OUTROS", totalOutros)]);

    return data;
}

function getOptionsChamadosCategoria() {
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