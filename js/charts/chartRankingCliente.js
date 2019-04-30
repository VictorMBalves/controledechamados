function drawRankingCliente(tipo) {

    var dados = getDataRankingCliente(tipo);
    if (isEmpty(dados)) {
        $("#chart_chamados_cliente").html("Nenhum dado no período");
        return;
    }
    var table = new google.visualization.Table(document.getElementById('chart_chamados_cliente'));

    function selectHandler() {
        var selectedItem = table.getSelection()[0];
        if (selectedItem) {
            preencherTabelaRanking(null, dados.getValue(selectedItem.row, 1),  null, false, null, dados.getValue(selectedItem.row, 1));
        }else{
            $('#rowTableChamados').hide();
        }
    }

    google.visualization.events.addListener(table, 'select', selectHandler);

    table.draw(dados, {allowHtml: true, width: '100%', height: '100%', sort: 'disable'});
}

function getDataRankingCliente(tipo) {
    var datatable = new google.visualization.DataTable();
    datatable.addColumn('string', '');
    datatable.addColumn('string', 'Empresa');
    datatable.addColumn('string', 'Sistema');

    var dados = carregaDados();
    dados.push({name: 'tipo_order', value: tipo})

    var jsonData;
    datatable.addColumn('number', 'Qtd. Total');
    datatable.addColumn('number', 'Qtd. Média');
    datatable.addColumn('string', 'Tempo Total');
    datatable.addColumn('string', 'Tempo Média');
    jsonData = $.ajax({
        url: "../charts/loadRankingCliente.php",
        data: dados,
        dataType: "json",
        async: false
    }).responseText;

    data = $.parseJSON(jsonData);

    for (var i = 0; i < data.length; i++) {
        var row;
        var qtd = parseInt(data[i].qtd);
        var mediaQtd = parseFloat((qtd/parseInt(data[i].qtd_dias)).toFixed(2));
        var tempo = formatTimeDiff(data[i].tempo);
        var mediaTempo = formatTimeDiff(parseInt((data[i].tempo/parseInt(data[i].qtd_dias)).toFixed(2)));

        i == 0 ? row = ['<img src="../imagem/gold.png" width="16" height="16">', data[i].empresa.toUpperCase(), data[i].sistema.toUpperCase(), qtd, mediaQtd, tempo, mediaTempo] :
            i == 1 ? row = ['<img src="../imagem/silver.png" width="16" height="16">', data[i].empresa.toUpperCase(), data[i].sistema.toUpperCase(), qtd, mediaQtd, tempo, mediaTempo] :
                i == 2 ? row = ['<img src="../imagem/bronze.png" width="16" height="16">', data[i].empresa.toUpperCase(), data[i].sistema.toUpperCase(), qtd, mediaQtd, tempo, mediaTempo] :
                    row = [(i+1).toString(), data[i].empresa.toUpperCase(), data[i].sistema.toUpperCase(), qtd, mediaQtd, tempo, mediaTempo]

        datatable.addRow(row);
    }

    return datatable;
}
