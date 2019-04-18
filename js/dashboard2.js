var importers = [
    "../js/charts/chartRankingCategoriaQtd.js",
    "../js/charts/chartCategoriaQtd.js",
    "../js/charts/chartRankingCategoriaTempo.js",
    "../js/charts/chartCategoriaTempo.js",
]

$(document).ready(()=> {
    loadImport();
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

$(()=>{
    chamadoandamento();
    chamadosatrasados();
    chamadospendentes();
    chamadoagendados();
});

setInterval(()=>{
    chamadoandamento();
    chamadosatrasados();
    chamadospendentes();
    chamadoagendados();
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