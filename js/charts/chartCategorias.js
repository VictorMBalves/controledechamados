function drawChamadosPorCategoria() {
    var dados = getDataChamadosPorCategoria();
    if (isEmpty(dados)) {
        $("#chart_div2").html("Nenhum dado no período");
        return;
    }
    chartCategoria = new google.visualization.PieChart(document.getElementById('chart_div2'));
    chartCategoria.draw(dados, getOptionsChamadosPorCategoria());
}

function getDataChamadosPorCategoria() {
    $('#dataChamadosCategoria').html(Date.parse($("#dtInicial2").val()).toString('dd/MM/yyyy'))
    $('#dataFinalChamadosCategoria').html(Date.parse($("#dtFinal2").val()).toString('dd/MM/yyyy'))
    var dados = $('#form2').serialize();
    var dataJson = $.ajax({
        url: "../charts/loadPeriodoCategoriaChart.php",
        dataType: "json",
        data: dados,
        async: false
    }).responseText;

    dataJson = $.parseJSON(dataJson);
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Categoria');
    data.addColumn('number', 'Quantidade');  
    data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});
    var total = 0;

    for (let i = 0; i < dataJson.length; i++) {
          total += Number(dataJson[i].quantidade);
    }

    for (let i = 0; i < dataJson.length; i++) {
        data.addRow([dataJson[i].descricao, Number(dataJson[i].quantidade), getTootip(dataJson[i] ,total)]);
    }
   
    return data;
}

function getTootip(data, total){

    var pPos = parseInt(total);
    var pEarned = parseInt(data.quantidade);  
    var perc="";
    if(isNaN(pPos) || isNaN(pEarned)){
        perc=" ";
    }else{
       perc = ((pEarned/pPos) * 100).toFixed(1);
    }

    icon = '<i class="fas fa-cubes m-1"></i>';
    if(data.categoria == "ERROS"){
        icon = '<i class="fas fa-bug m-1"></i>';
    }else if(data.categoria == "DÚVIDAS"){
        icon = '<i class="fas fa-question m-1"></i>';
    }
    return '<div class="col m-1 text-uppercase">'
                +icon+
                '<strong>'+data.descricao+
                '<div class="text-success">QTD: '+data.quantidade +" <br/>"+perc+'%</p></strong></div>';
}

function getOptionsChamadosPorCategoria() {
    var options = {
        chartArea: {
            // left: 100,
            // top: 10,
            width: '90%',
            height: '100%'
        },
        tooltip: {isHtml: true}
      };
    return options;
}