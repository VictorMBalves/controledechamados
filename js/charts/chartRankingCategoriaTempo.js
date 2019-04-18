function drawRankingCategoriaTempo() {
    var dados = getDataRankingChamadosTempo();
    if (isEmpty(dados)) {
        $("#chart_chamados_categoria_tempo").html("Nenhum dado no período");
        return;
    }
    table = new google.visualization.Table(document.getElementById('chart_chamados_categoria_tempo'));

    table.draw(dados, {allowHtml: true, width: '100%', height: '100%', sort: 'disable'});
}

function getDataRankingChamadosTempo() {
    var datatable = new google.visualization.DataTable();
    datatable.addColumn('string', '');
    datatable.addColumn('string', 'Descrição');
    datatable.addColumn('string', 'Tempo');

    var dados = $('#formFiltros').serialize();

    var jsonData = $.ajax({
        url: "../charts/loadRankingCategoriaTempo.php",
        data: dados,
        dataType: "json",
        async: false
    }).responseText;

    data = $.parseJSON(jsonData);

    for (var i = 0; i < data.length; i++) {
        var row;
        i == 0 ? row = ['<img src="../imagem/gold.png" width="16" height="16">', data[i].descricao, formatTimeDiff(data[i].tempo)] :
            i == 1 ? row = ['<img src="../imagem/silver.png" width="16" height="16">', data[i].descricao, formatTimeDiff(data[i].tempo)] :
                i == 2 ? row = ['<img src="../imagem/bronze.png" width="16" height="16">', data[i].descricao, formatTimeDiff(data[i].tempo)] :
                    row = ['', data[i].descricao, formatTimeDiff(data[i].tempo)]

        datatable.addRow(row);
    }

    return datatable;
}

