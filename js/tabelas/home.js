$(document).ready(function () {
    loadAvisos();
    $("#loading").html('<img src="../imagem/loading.gif">');
    $("#liHome").addClass('active')
});

$(window).on("load", function () {

});

function erro() {
    alert('Acesso negado! Redirecinando a pagina principal.');
    window.location.assign("../pages/chamadoespera.php");
}

function chamadospendentes() {
    var url = "../pages/chamadospendentes.php";
    jQuery("#pendentes").load(url, function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
}

function chamadosatrasados() {
    var url = "../pages/chamadosatrasados.php";
    jQuery("#atrasados").load(url, function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
}

function chamadoagendados() {
    var url = "../pages/chamadosagendados.php";
    jQuery("#agendados").load(url, function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
}

function chamadoandamento() {
    var url = "../pages/chamadosandamento.php";
    jQuery("#andamento").load(url, function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
}


$(() => {
    chamadoandamento();
    chamadosatrasados();
    chamadospendentes();
    chamadoagendados();
    loadDataAvulsos();
});

// setInterval(function () {
//     if (isEmpty($("#keyword").val())) {
//         chamadoandamento();
//         chamadosatrasados();
//         chamadospendentes();
//         chamadoagendados();
//         loadDataAvulsos();
//     }
// }, 30000);//

function loadAvisos() {
    $.ajax({
        type: "POST",
        url: "../pages/avisos.php",
        success: function (data) {
            $("#avisos").html(data);
        }
    });
    if (!$.cookie('showAvisos')) {
        $.cookie('showAvisos', 'true', { expires: 1, path: '/' });
        $("#showAvisos").click();
    }
}

function abrirVisualizacao(id) {
    $("#modalConsulta").load("../modals/modalConsultaEspera.php?id_chamadoespera=" + id, function () {
        $('#avulsoBtn').popover('hide')
        $("#modalCon").modal('show');
    });
}

function abrirVisualizacaoChamado(id) {
    $("#modalConsulta").load("../modals/modalConsultaChamado.php?id_chamado=" + id, function () {
        $('#avulsoBtn').popover('hide')
        $("#modalCon").modal('show');
    });
}

function abrirAgendamento(id) {
    $("#modalAgendamento").load("../modals/modalAgendamento.php?id_chamadoespera=" + id, function () {
        $('#avulsoBtn').popover('hide')
        $("#modalAgenda").modal('show');
    });
}

function colorNotification(showBlue) {
    if (showBlue)
        $("#labelNotification").addClass(' text-info ');
    else
        $("#labelNotification").removeClass(' text-info ');
}

$("#showAtendente").click(function () {
    $("#sidebar").toggleClass("collapsedLeft");
    $("#content").toggleClass("col-md-12 col-md-8");
    $("#flecha").toggleClass("glyphicon-arrow-left glyphicon-arrow-right");
})
//Busca na pagina home
$(function () {
    $(document).ready(function () {
        $("#keyword").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#chamados .for-search").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
});

$("#avulsos").hover(
    function () {
        $('#collapseCardExample').collapse('show');
    }, function () {
        $('#collapseCardExample').collapse('hide');
    }
);

function loadDataAvulsos(){
    if($(".popover").hasClass( "show" ))
        return;
    $("#avulsoBtn").popover('dispose');
    $.ajax({
        type: 'POST',
        url: '../pages/chamadosAvulsos.php',
        dataType: "json",
        success: function (data) {
            if (data) {
                createPopover(data);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
}
function createPopover(data) {
    temp = '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body" style="overflow:auto;max-height:400px;"></div></div>'
    body = '<script>$("#keywordAvulso").on("keyup", function () {var value = $(this).val().toLowerCase();$(".popover-body .for-search").filter(function () {$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)});});</script><form class="m-2"><div class="input-group"><input type="text" name="keywordAvulso" id="keywordAvulso" class="form-control bg-light border-0 small" placeholder="Buscar por..." aria-label="Search" aria-describedby="basic-addon2"></div></form>';
    var len = data.length;
    if (len > 0) {
        for (var i = 0; i < len; i++) {
            body += data[i];
        }
    }
    var options = {
        placement: "bottom",
        html: true,
        content: body,
        template: temp,
        trigger: 'click'
    }
    $("#avulsoBtn").popover(options);
    $("#numAvulsos").html("(" + len + ")");
}
