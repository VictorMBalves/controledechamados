var importers = [
    "../js/charts/chartRankingCategoria.js",
    "../js/charts/chartCategoria.js",
    "../js/charts/chartQtdChamadosPorHora.js",
    "../js/charts/chartRankingAtendente.js",
    "../js/charts/chartAtendenteCategoria.js",
    "../js/charts/chartRankingCliente.js",
    "../js/charts/chartCliente.js",
    "../js/charts/chartSistema.js",

]

$(document).ready(()=> {
    loadImport();
    $('.table-ranking').DataTable({
        pageLength: 10,
        responsive: true,
        "autoWidth": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
        }
    });
});

function loadImport(){
    $.each(importers, function(key, importer){
        script = document.createElement('script')
        script.src = importer
        document.body.appendChild(script);
    });
}

window.onload = ()=>{
    google.charts.load('current', {callback: drawCharts,'packages':['corechart','table'], 'language': 'pt-br' });
};

function drawCharts() {
    drawChatRanking();
    drawChamadosPorHora();
    drawChatRankingAtendente();
    getTotaisChamado();
    setDataTempoMedioAtendimento();
    drawChartRankingCliente();
}

function drawChartRankingCliente(){
    drawRankingCliente($('#filtroTipoRankingCliente').val());
    drawCliente($('#filtroTipoRankingCliente').val());
    drawSistema($('#filtroTipoRankingCliente').val());
    $('#rowTableChamados').hide();;
}

function drawChatRanking(){
    drawRankingCategoria($('#filtroTipoRanking').val());
    drawCategoria($('#filtroTipoRanking').val());
    $('#rowTableChamados').hide();
}

function drawChatRankingAtendente(){
    drawRankingAtendente($('#filtroTipoRankingAtendente').val());
    drawAtendenteCategoria($('#filtroTipoRankingAtendente').val());
    $('#rowTableChamados').hide();;
}

$("#btnFiltrar").on("click", ()=> {
    drawCharts();
    return false;
})

$(() => {
    $('.chosen-select').chosen({ no_results_text: "Nenhum registro encontrado", allow_single_deselect: true });
    $('#filtroTipoRanking').change(function(){
        drawChatRanking();
    });
    $('#filtroTipoRankingAtendente').change(function(){
        drawChatRankingAtendente();
    });
    $('#filtroTipoRankingCliente').change(function(){
        drawChartRankingCliente();
    });
    alterarCategoria();
})


function formatTimeDiff(time) {
    var sec_num = parseInt(time, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    var tempo = "";
    if (hours   > 0) {
        tempo = tempo + hours + 'h';
    }
    if (minutes > 0) {
        tempo = tempo + minutes + 'min';
    }
    if (seconds > 0) {
        tempo = tempo + seconds + 's';
    }
    return tempo;
}

setInterval(()=>{
    drawCharts();
}, 600000);//

function getTotaisChamado() {
    var dados = carregaDados();

    var jsonData = $.ajax({
        url: "../charts/loadQtdChamadosFinalizados.php",
        data: dados,
        dataType: "json",
        async: false
    }).responseText;

    data = $.parseJSON(jsonData);
    $('#mediaConcluidoForaPrazo').text('');
    $('#qtdConcluidoForaPrazo').text('');
    $('#mediaConcluido').text('');
    $('#qtdConcluido').text('');
    for (var i = 0; i < data.length; i++) {
        var qtdDias = new Number(data[i]['qtd_dias']);
        if(data[i]['tipo'] == 'TOTAL'){
            qtd = new Number(data[i]['qtd']);
            media = qtd/qtdDias;
            $('#mediaConcluido').text('Média/dia ' + media.toFixed(2));
            $('#qtdConcluido').text(qtd)
        }
        if(data[i]['tipo'] == 'ATRASADOS'){
            var qtd = new Number(data[i]['qtd']);
            var media = qtd/qtdDias;
            $('#mediaConcluidoForaPrazo').text('Média/dia ' + media.toFixed(2));
            $('#qtdConcluidoForaPrazo').text(qtd);
        }
    }
}

function preencherTabelaRanking(id, descricao, usuario, atrasados, hora, empresa, sistema){
    $('.lmask').show();
    var dados = carregaDados();
    if(usuario != null)
        dados[2].value = usuario;
    if(id != null)
        dados[5].value = id;
    if(hora != null)
        dados.push({ name: 'hora', value: hora});
    if(empresa != null)    
        dados.push({name: 'empresa', value: empresa});
    if(sistema != null)
        dados[3].value = sistema;
        
    dados.push({ name: 'atrasados', value: atrasados });
    
    $.ajax({
        url: "../charts/loadTabelaChamados.php",
        data: dados,
        dataType: "json",
        async: true
    }).done(function(response){
        console.log(response)
        data = response;
    
        $('#textTabela1').text(descricao)
    
        $('#rowTableChamados').show();
        var table = $('.table-ranking').DataTable();
        table.clear().draw();
        $.each(data,function (i,val){
            table.row.add( [
                val['id_chamado'],
                '<span title="' + val['empresa'] + '">' + (val['empresa'].length > 27 ? val['empresa'].substring(0, 27) + '...' : val['empresa']) + '</span>',
                '<span title="' + val['contato'] + '">' + (val['contato'].length > 12 ? val['contato'].substring(0, 12) + '...' : val['contato']) + '</span>',
                val['sistema'],
                val['usuario'],
                '<span title="' + val['descproblema'] + '">' + (val['descproblema'].length > 59 ? (val['descproblema'].substring(0, 60) + '...') : val['descproblema']) + '</span>',
                Date.parse(val['datainicio']).toString('dd/MM/yyyy HH:mm'),
                formatTimeDiff(val['tempo']),
                '<i onclick="abrirVisualizacao('+data[i].id_chamado+')" class="fa fa-search" aria-hidden="true" title="Ver registro do chamado"></i>',
            ] ).draw( false );
        });
    
        $('html, body').animate({
            scrollTop: $('#rowTableChamados').offset().top - 100
        }, 800);
        $('.lmask').hide();
    });
}

function abrirVisualizacao(id){
    $("#modalConsulta").load("../modals/modalConsultaChamado.php?id_chamado="+id, function(){
        $('[data-toggle="tooltip"]').tooltip()
        $("#modalCon").modal('show');
    });
}

$('#empresafiltro').flexdatalist({
    minLength: 1,
    visibleProperties: '{cnpj} - {name}',
    valueProperty: 'cnpj',
    textProperty: 'name',
    searchIn: ['name', 'cnpj'],
    url: "../utilsPHP/search.php",
    noResultsText: 'Sem resultados para "{keyword}"',
    searchByWord: true,
    searchContain: true,
}).on('select:flexdatalist', function(ev, result){

})

$('#btnDia').on('click', function () {
    $("#dataInicial").val(new Date().toString('yyyy-MM-dd'));
    $("#dataFinal").val(new Date().toString('yyyy-MM-dd'));
    drawCharts();
    return false;
});

$('#btnOntem').on('click', function () {
    $("#dataInicial").val(addDays(new Date(), -1).toString('yyyy-MM-dd'));
    $("#dataFinal").val(addDays(new Date(), -1).toString('yyyy-MM-dd'));

    drawCharts();
    return false;
});

$('#btnSemana').on('click', function () {
    $("#dataInicial").val(addDays(new Date(), -7).toString('yyyy-MM-dd'));
    $("#dataFinal").val(new Date().toString('yyyy-MM-dd'));

    drawCharts();
    return false;
});

$('#btnMes').on('click', function () {
    var date = new Date();
    $("#dataInicial").val(new Date(date.getFullYear(), date.getMonth(), 1).toString('yyyy-MM-dd'));
    $("#dataFinal").val(new Date(date.getFullYear(), date.getMonth() + 1, 0).toString('yyyy-MM-dd'));

    drawCharts();
    return false;
});

function addDays(date, days) {
    var result = new Date(date);
    result.setDate(result.getDate() + days);
    return result;
}

function setDataTempoMedioAtendimento() {
    var dados = carregaDados();

    var jsonData = $.ajax({
        url: "../charts/loadTempoMedioAtendimentoGerencial.php",
        dataType: "json",
        data: dados,
        async: false
    }).responseText;

    if (isEmpty($.parseJSON(jsonData))) {
        return null;
    }
    jsonData = $.parseJSON(jsonData);

    $('#tempoMedioAtendimento').text(formatTimeDiff(jsonData['tempo']))
}

$('#cardConcluido').on('click', function(){
    preencherTabelaRanking(null, "CONCLUÍDOS", null, false);
})

$('#cardConcluidoAtrasado').on('click', function(){
    preencherTabelaRanking(null, "CONCLUÍDOS", null, true);
})

function alterarCategoria() {
    sendRequestCategoria((response) => {
        for (i = 0; i < response.length; i++) {
            dado = response[i];
            icon = '<i class="fas fa-cubes"></i>';
            if(dado.categoria == "ERROS"){
                icon = '<i class="fas fa-bug"></i>';
            }else if(dado.categoria == "DÚVIDAS"){
                icon = '<i class="fas fa-question"></i>';
            }
            $("#categoria").append($('<option>', {
                html : icon+" ["+dado.categoria+"] "+dado.descricao,
                value: dado.id,
                // text : ''
            }));
        }
        $('#categoria').trigger("chosen:updated");
    })

}
function sendRequestCategoria(callback) {
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "../controllers/controllerCategoria.php",
        "method": "GET",
        "headers": {
            "Content-Type": "application/json",
            "cache-control": "no-cache",
            "Postman-Token": "1fbbd708-31dc-4395-8462-c333ae164ec5"
        },
        "processData": false,
        "data": ""
    }
    $.ajax(settings).done(function (response) {
        callback(JSON.parse(response));
    });
}


function carregaDados() {
    var data = [];
    data.push({ name: 'dataInicial', value: $('#dataInicial').val() });
    data.push({ name: 'dataFinal', value: $('#dataFinal').val() });
    data.push({ name: 'usuario', value: $('#usuario').val() });
    data.push({ name: 'sistema', value: $('#sistema').val() });
    data.push({ name: 'cnpj', value: $('#empresafiltro').val() });
    data.push({ name: 'categoria', value: $('#categoria').val() });
    data.push({ name: 'exceto', value: $("#exceto").is( ":checked" )});
    data.push({ name: 'considerarPlantao', value: $("#considerarPlantao").is( ":checked" )});
    data.push({ name: 'somentePlantao', value: $("#somentePlantao").is( ":checked" )});
    return data;
}