function drawRankingCategoriaQtd() {
    var dados = getDataRankingChamadosQtd();
    if (isEmpty(dados)) {
        $("#chart_chamados_categoria_qtd").html("Nenhum dado no período");
        return;
    }
    var table = new google.visualization.Table(document.getElementById('chart_chamados_categoria_qtd'));

    function selectHandler() {
        var selectedItem = table.getSelection()[0];
        if (selectedItem) {
            preencherTabelaRanking(dados.getValue(selectedItem.row, 3), dados.getValue(selectedItem.row, 1) + ' (' + dados.getValue(selectedItem.row, 2) + ')')
        }else{
            $('#rowTableChamados').hide();
        }
    }

    google.visualization.events.addListener(table, 'select', selectHandler);

    table.draw(dados, {allowHtml: true, width: '100%', height: '100%', sort: 'disable'});

    view = new google.visualization.DataView(dados);
    view.hideColumns([3]);
    table.draw(view,  {allowHtml: true, width: '100%', height: '100%', sort: 'disable'});
}

function getDataRankingChamadosQtd() {
    var datatable = new google.visualization.DataTable();
    datatable.addColumn('string', '');
    datatable.addColumn('string', 'Descrição');
    datatable.addColumn('number', 'Quant.');
    datatable.addColumn('string', 'ID');

    var dados = $('#formFiltros').serialize();

    var jsonData = $.ajax({
        url: "../charts/loadRankingCategoriaQtd.php",
        data: dados,
        dataType: "json",
        async: false
    }).responseText;

    data = $.parseJSON(jsonData);

    for (var i = 0; i < data.length; i++) {
        var row;
        i == 0 ? row = ['<img src="../imagem/gold.png" width="16" height="16">', data[i].descricao.toUpperCase(), parseInt(data[i].qtd), data[i].id] :
            i == 1 ? row = ['<img src="../imagem/silver.png" width="16" height="16">', data[i].descricao.toUpperCase(), parseInt(data[i].qtd), data[i].id] :
                i == 2 ? row = ['<img src="../imagem/bronze.png" width="16" height="16">', data[i].descricao.toUpperCase(), parseInt(data[i].qtd), data[i].id] :
                    row = ['', data[i].descricao.toUpperCase(), parseInt(data[i].qtd), data[i].id]

        datatable.addRow(row);
    }

    return datatable;
}
