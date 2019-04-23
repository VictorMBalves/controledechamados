function drawAtendenteCategoria(tipo, usuario) {
    var data;
    if(tipo == 'Quantidade')
        data = getDataAtendenteChamadosQtd(usuario);
    else data = getDataAtendenteChamadosTempo(usuario);

    if (isEmpty(data)) {
        $("#chart_atendentes_categoria").html("Nenhum dado no período");
        return;
    }

    var chart = new google.visualization.PieChart(document.getElementById('chart_atendentes_categoria'));

    if(tipo == 'Quantidade')
        chart.draw(data, getOptionsAtendenteChamadosCategoria());
    else chart.draw(data, getOptionsAtendenteChamadosCategoriaTempo());    
}

function getDataAtendenteChamadosQtd(usuario) {
    var dados = $('#formFiltros').serializeArray();
    dados[2].value = usuario;

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

function getOptionsAtendenteChamadosCategoria() {
    var options = {
        'chartArea': {'width': '100%', 'height': '80%'},
        pieStartAngle: 50,
        title: 'Top 5'
    };

    return options;
}
function getDataAtendenteChamadosTempo(usuario) {
    var dados = $('#formFiltros').serializeArray();
    dados[2].value = usuario;
    
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

function getOptionsAtendenteChamadosCategoriaTempo() {
    var options = {
        'chartArea': {'width': '100%', 'height': '80%'},
        pieStartAngle: 50,
        title: 'Top 5',
        tooltip: {isHtml: true}
    };

    return options;
}
