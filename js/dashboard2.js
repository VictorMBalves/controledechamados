var importers = [
    "../js/charts/chartRankingCategoriaQtd.js",
    "../js/charts/chartCategoriaQtd.js",
    "../js/charts/chartRankingCategoriaTempo.js",
    "../js/charts/chartCategoriaTempo.js",
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
    $('.table-ranking-tempo').DataTable({
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
    drawRankingCategoriaQtd();
    drawCategoriaQtd();
    drawRankingCategoriaTempo();
    drawCategoriaTempo();
    getTotaisChamado();
    notificationSuccess("Sucesso", "Gráficos gerados com sucesso")
}

$("#btnFiltrar").on("click", ()=> {
    drawCharts();
    return false;
})

$(() => {
    $('.chosen-select').chosen({ no_results_text: "Nenhum registro encontrado", allow_single_deselect: true });
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
    drawRankingCategoriaQtd();
    drawCategoriaQtd();
    drawRankingCategoriaTempo();
    drawCategoriaTempo();
    getTotaisChamado();
}, 30000);//

function chamadospendentes() {
    var url = "../pages/chamadospendentes.php?continue=true";
    jQuery("#pendentes").load(url);
}

function chamadosatrasados() {
    var url = "../pages/chamadosatrasados.php?continue=true";
    jQuery("#atrasados").load(url);
}

function chamadoagendados() {
    var url = "../pages/chamadosagendados.php?continue=true";
    jQuery("#agendados").load(url);
}

function chamadoandamento() {
    var url = "../pages/chamadosandamento.php?continue=true";
    jQuery("#andamento").load(url);
}

function getTotaisChamado() {
    var dados = $('#formFiltros').serialize();

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

function preencherTabelaRanking(id, descricao){
    var dados = $('#formFiltros').serialize();
    dados += "&categoria=" + id

    var jsonData = $.ajax({
        url: "../charts/loadTabelaChamados.php",
        data: dados,
        dataType: "json",
        async: false
    }).responseText;

    data = $.parseJSON(jsonData);

    $('#textTabela1').text(descricao)

    $('#rowTableChamados').show();
    var table = $('.table-ranking').DataTable();
    table.clear().draw();
    $.each(data,function (i,val){
        table.row.add( [
            val['id_chamado'],
            '<span title="' + val['empresa'] + '">' + val['empresa'].substring(0, 60) + '...' + '</span>',
            '<span title="' + val['contato'] + '">' + val['contato'].substring(0, 60) + '...' + '</span>',
            val['sistema'],
            '<span title="' + val['descproblema'] + '">' + (val['descproblema'].length > 59 ? (val['descproblema'].substring(0, 60) + '...') : val['descproblema']) + '</span>',
            Date.parse(val['datainicio']).toString('dd/MM/yyyy HH:mm'),
            '<i onclick="abrirVisualizacao('+data[i].id_chamado+')" class="fa fa-search" aria-hidden="true" title="Ver registro do chamado"></i>',
        ] ).draw( false );
    });
}

function preencherTabelaRankingTempo(id, descricao){
    var dados = $('#formFiltros').serialize();
    dados += "&categoria=" + id

    var jsonData = $.ajax({
        url: "../charts/loadTabelaChamados.php",
        data: dados,
        dataType: "json",
        async: false
    }).responseText;

    data = $.parseJSON(jsonData);

    $('#textTabela2').text(descricao)
    $('#rowTableChamadosTempo').show();
    var table = $('.table-ranking-tempo').DataTable();
    table.clear().draw();
    $.each(data,function (i,val){
        table.row.add( [
            val['id_chamado'],
            '<span title="' + val['empresa'] + '">' + val['empresa'].substring(0, 60) + '...' + '</span>',
            '<span title="' + val['contato'] + '">' + val['contato'].substring(0, 60) + '...' + '</span>',
            val['sistema'],
            '<span title="' + val['descproblema'] + '">' + (val['descproblema'].length > 59 ? (val['descproblema'].substring(0, 60) + '...') : val['descproblema']) + '</span>',
            Date.parse(val['datainicio']).toString('dd/MM/yyyy HH:mm'),
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