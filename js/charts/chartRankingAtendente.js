function drawRankingAtendente(tipo) {
    var dados = getDataRankingAtendente(tipo);
    if (isEmpty(dados)) {
        $("#chart_atendentes_qtd").html("Nenhum dado no período");
        return;
    }
    var table = new google.visualization.Table(document.getElementById('chart_atendentes_qtd'));

    function selectHandler() {
        var selectedItem = table.getSelection()[0];
        if (selectedItem) {
            drawAtendenteCategoria(tipo, dados.getValue(selectedItem.row, 4));
            preencherTabelaRanking(null, dados.getValue(selectedItem.row, 1) + ' (' + dados.getValue(selectedItem.row, 2) + ')', dados.getValue(selectedItem.row, 4), $('#textTabela2'), $('.table-ranking-atendente'), $('#rowTableChamadosAtendente'))
        }else{
            drawAtendenteCategoria(tipo, null);
            $('#rowTableChamadosAtendente').hide();
        }
    }

    google.visualization.events.addListener(table, 'select', selectHandler);

    table.draw(dados, {allowHtml: true, width: '100%', height: '100%', sort: 'disable'});

    view = new google.visualization.DataView(dados);
    view.hideColumns([4]);
    table.draw(view,  {allowHtml: true, width: '100%', height: '100%', sort: 'disable'});
}

function getDataRankingAtendente(tipo) {
    var datatable = new google.visualization.DataTable();
    datatable.addColumn('string', '');
    datatable.addColumn('string', 'Atendente');
    
    var dados = $('#formFiltros').serialize();

    if(tipo == 'Quantidade'){
        datatable.addColumn('number', 'Quant.');
        datatable.addColumn('number', 'Média');
        var jsonData = $.ajax({
            url: "../charts/loadRankingChamadoAtendenteQtd.php",
            data: dados,
            dataType: "json",
            async: false
        }).responseText;
    }else{
        datatable.addColumn('string', 'Tempo');
        datatable.addColumn('string', 'Média');
        var jsonData = $.ajax({
            url: "../charts/loadRankingChamadoAtendenteTempo.php",
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
        i == 0 ? row = ['<img src="../imagem/gold.png" width="16" height="16">', data[i].nome.toUpperCase(), qtd, media, data[i].id] :
            i == 1 ? row = ['<img src="../imagem/silver.png" width="16" height="16">', data[i].nome.toUpperCase(), qtd, media, data[i].id] :
                i == 2 ? row = ['<img src="../imagem/bronze.png" width="16" height="16">', data[i].nome.toUpperCase(), qtd, media, data[i].id] :
                    row = ['', data[i].nome.toUpperCase(), qtd, media, data[i].id]

        datatable.addRow(row);
    }

    return datatable;
}
