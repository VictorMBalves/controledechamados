    $( document ).ready(function() {
        loadAvisos();
        $("#loading").html('<img src="../imagem/loading.gif">');
    });

    $( window ).on( "load", function() {
        
    });

    function erro(){
        alert('Acesso negado! Redirecinando a pagina principal.');
         window.location.assign("../pages/chamadoespera.php");
    }

    function chamadospendentes() {
        var url="../pages/chamadospendentes.php";
        jQuery("#pendentes").load(url, function(){
            $('[data-toggle="tooltip"]').tooltip()
        });
    }

    function chamadosatrasados() {
        var url="../pages/chamadosatrasados.php";
        jQuery("#atrasados").load(url, function(){
            $('[data-toggle="tooltip"]').tooltip()
        });
    }

    function chamadoagendados() {
        var url="../pages/chamadosagendados.php";
        jQuery("#agendados").load(url, function(){
            $('[data-toggle="tooltip"]').tooltip()
        });
    }

    function chamadoandamento() {
        var url="../pages/chamadosandamento.php";
        jQuery("#andamento").load(url, function(){
            $('[data-toggle="tooltip"]').tooltip()
        });
    }


    $(function() {
        chamadoandamento();
        chamadosatrasados();
        chamadospendentes();
        chamadoagendados();
    });

    setInterval(function(){
        if(isEmpty($("#keyword").val())){
            chamadoandamento();
            chamadosatrasados();
            chamadospendentes();
            chamadoagendados();
        }
    }, 30000);//

    function loadAvisos(){
        $.ajax({
            type: "POST",
            url: "../pages/avisos.php",
            success:function(data){
                $("#avisos").html(data);
            }
        });
        if(!$.cookie('showAvisos')){
            $.cookie('showAvisos', 'true', { expires: 1, path: '/' });
            $("#showAvisos").click();
        }
    }
   
    function abrirVisualizacao(id){
        $("#modalConsulta").load("../modals/modalConsultaEspera.php?id_chamadoespera="+id);
        setTimeout(function(){
            $("#modalCon").modal('show');
        }, 400);
    }

    function abrirVisualizacaoChamado(id){
        $("#modalConsulta").load("../modals/modalConsultaChamado.php?id_chamado="+id);
        setTimeout(function(){
            $("#modalCon").modal('show');
        }, 300);
    }

    function abrirAgendamento(id){
        $("#modalAgendamento").load("../modals/modalAgendamento.php?id_chamadoespera="+id);
        setTimeout(function(){
            $("#modalAgenda").modal('show');
        }, 400);
    }

    function colorNotification(showBlue){
        if(showBlue)
            $("#labelNotification").addClass(' text-info ');
        else
            $("#labelNotification").removeClass(' text-info ');
    }    

    $("#showAtendente").click(function(){
        $("#sidebar").toggleClass("collapsedLeft");
        $("#content").toggleClass("col-md-12 col-md-8");
        $("#flecha").toggleClass("glyphicon-arrow-left glyphicon-arrow-right");
    })
    //Busca na pagina home
    $(function() {
        $(document).ready(function(){
            $("#keyword").on("keyup", function() {
              var value = $(this).val().toLowerCase();
              $("#chamados .for-search").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
              });
            });
          });
    });