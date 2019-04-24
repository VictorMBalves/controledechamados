var importers = [
    "../js/charts/chartRankingCategoria.js",
    "../js/charts/chartCategoria.js",
    "../js/charts/chartQtdChamadosPorHora.js",
    "../js/charts/chartRankingAtendente.js",
    "../js/charts/chartAtendenteCategoria.js",
]

$(document).ready(()=> {
    loadImport();
    $('.table-ranking').DataTable({
        pageLength: 10,
        responsive: true,
        "autoWidth": false,
        "ordering": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
        }
    });
    $('.table-ranking-atendente').DataTable({
        pageLength: 10,
        responsive: true,
        "autoWidth": false,
        "ordering": false,
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

    notificationSuccess("Sucesso", "Gráficos gerados com sucesso")
}

function drawChatRanking(){
    drawRankingCategoria($('#filtroTipoRanking').val());
    drawCategoria($('#filtroTipoRanking').val());
    $('#rowTableChamados').hide();
}

function drawChatRankingAtendente(){
    drawRankingAtendente($('#filtroTipoRankingAtendente').val());
    drawAtendenteCategoria($('#filtroTipoRankingAtendente').val());
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
}, 30000);//

function getTotaisChamado() {
    var dados = carregaDados();
console.log(dados)
    var jsonData = $.ajax({
        url: "../charts/loadQtdChamadosFinalizados.php",
        data: dados,
        dataType: "json",
        async: false
    }).responseText;

    data = $.parseJSON(jsonData);

    var qtdDias = new Number(data[0]['qtd_dias']);

    var qtd = new Number(data[0]['qtd']);
    var media = qtd/qtdDias;
    $('#mediaConcluidoForaPrazo').text('Média/dia ' + media.toFixed(2));
    $('#qtdConcluidoForaPrazo').text(qtd);
    qtd = new Number(data[1]['qtd']);
    media = qtd/qtdDias;
    $('#mediaConcluido').text('Média/dia ' + media.toFixed(2));
    $('#qtdConcluido').text(qtd)
}

function preencherTabelaRanking(id, descricao, usuario, textTabela, tabela, row){
    var dados = carregaDados();
    if(usuario != null)
        dados[2].value = usuario;

    dados[5].value = id;

    var jsonData = $.ajax({
        url: "../charts/loadTabelaChamados.php",
        data: dados,
        dataType: "json",
        async: false
    }).responseText;
    
    data = $.parseJSON(jsonData);

    textTabela.text(descricao)

    row.show();
    var table = tabela.DataTable();
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
    alert('teste')
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
            $(".chosen-select").append($('<option>', {
                html : icon+" ["+dado.categoria+"] "+dado.descricao,
                value: dado.id,
                // text : ''
            }));
        }
        $('.chosen-select').trigger("chosen:updated");
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
    return data;
}