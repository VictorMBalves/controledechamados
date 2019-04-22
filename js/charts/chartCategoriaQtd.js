function drawCategoriaQtd() {
    var dados = getDataRankingChamadosQtd();
    if (isEmpty(dados)) {
        $("#chart_categoria_qtd").html("Nenhum dado no período");
        return;
    }

    var chart = new google.visualization.PieChart(document.getElementById('chart_categoria_qtd'));
    var data = getDataChamadosQtd();
    chart.draw(data, getOptionsChamadosCategoria());
}

function getDataChamadosQtd() {
    var dados = $('#formFiltros').serialize();
    
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
                dataArray.push([(data[i].descricao + '(' + data[i].qtd + ')'), parseInt(data[i].qtd), data[i].id]);
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