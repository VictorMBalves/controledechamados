var importers = [
    "../js/charts/chartTimeLine.js",
    "../js/charts/chartRankUsuarios.js",
    "../js/charts/chartCategorias.js",
    "../js/charts/chartUsuariosSemanal.js",
    "../js/charts/chartChamadosPorHora.js"
]

$(document).ready(()=> {
    progressEvent("Executando", "Gerando gráficos")
    $("#liDashboard").addClass('active')
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
    google.charts.load('current', { callback: drawCharts, 'packages': ['corechart', 'line', 'timeline'], 'language': 'pt-br' });
};

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

function drawCharts() {
    drawChamadosPorCategoria()
    drawChamadosPorAtendente()
    drawRankAtendentes()
    drawChamadosPorHora()
    drawChartTempoMedioAtendimento()
    notificationSuccess("Sucesso", "Gráficos gerados com sucesso")
}

$("#btnChamadoAtendente").on("click", ()=> {
    drawChamadosPorAtendente()
    return false;
})

$("#btnChamadoCategoria").on("click", ()=> {
    drawChamadosPorCategoria()
    return false;
})

$("#btnRankAtendentes").on("click", ()=> {
    drawRankAtendentes()
    return false;
})

$("#btnChamadosPorHora").on("click", ()=> {
    drawChamadosPorHora()
    return false;
})

$("#btnTempoMedioAtendimento").on("click", ()=> {
    drawChartTempoMedioAtendimento();
    return false;
})