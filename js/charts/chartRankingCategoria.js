function drawRankingCategoria(tipo) {

    var dados = getDataRankingChamados(tipo);
    if (isEmpty(dados)) {
        $("#chart_chamados_categoria_qtd").html("Nenhum dado no período");
        return;
    }
    var table = new google.visualization.Table(document.getElementById('chart_chamados_categoria_qtd'));

    function selectHandler() {
        var selectedItem = table.getSelection()[0];
        if (selectedItem) {
            preencherTabelaRanking(dados.getValue(selectedItem.row, 4), dados.getValue(selectedItem.row, 1) + ' (' + dados.getValue(selectedItem.row, 2) + ')',  null, $('#textTabela1'), $('.table-ranking'), $('#rowTableChamados'))
        }else{
            $('#rowTableChamados').hide();
        }
    }

    google.visualization.events.addListener(table, 'select', selectHandler);

    table.draw(dados, {allowHtml: true, width: '100%', height: '100%', sort: 'disable'});

    view = new google.visualization.DataView(dados);
    view.hideColumns([4]);
    table.draw(view,  {allowHtml: true, width: '100%', height: '100%', sort: 'disable'});
}

function getDataRankingChamados(tipo) {
    var datatable = new google.visualization.DataTable();
    datatable.addColumn('string', '');
    datatable.addColumn('string', 'Descrição');

    var dados = $('#formFiltros').serialize();
    var jsonData;
    if(tipo == 'Quantidade'){
        datatable.addColumn('number', 'Quant.');
        datatable.addColumn('number', 'Média');
         jsonData = $.ajax({
            url: "../charts/loadRankingCategoriaQtd.php",
            data: dados,
            dataType: "json",
            async: false
        }).responseText;
    }else{
        datatable.addColumn('string', 'Tempo');
        datatable.addColumn('string', 'Média');
        jsonData = $.ajax({
            url: "../charts/loadRankingCategoriaTempo.php",
            data: dados,
            dataType: "json",
            async: false
        }).responseText;
    }
    datatable.addColumn('string', 'ID');
    

    data = $.parseJSON(jsonData);

    for (var i = 0; i < data.length; i++) {
        var row;
        var qtd;
        var media;
        if(tipo == 'Quantidade'){
            qtd = parseInt(data[i].qtd);
            media = parseFloat((qtd/parseInt(data[i].qtd_dias)).toFixed(2));
        }else {
            qtd = formatTimeDiff(data[i].tempo);
            media = formatTimeDiff(parseInt((data[i].tempo/parseInt(data[i].qtd_dias)).toFixed(2)));
        }
        i == 0 ? row = ['<img src="../imagem/gold.png" width="16" height="16">', data[i].descricao.toUpperCase(), qtd, media, data[i].id] :
            i == 1 ? row = ['<img src="../imagem/silver.png" width="16" height="16">', data[i].descricao.toUpperCase(), qtd, media, data[i].id] :
                i == 2 ? row = ['<img src="../imagem/bronze.png" width="16" height="16">', data[i].descricao.toUpperCase(), qtd, media, data[i].id] :
                    row = ['', data[i].descricao.toUpperCase(), qtd, media, data[i].id]

        datatable.addRow(row);
    }

    return datatable;
}
