    $( document ).ready(function() {
        loadAvisos();
        loadResponsavelSemana();
        $("#loading").html('<img src="../imagem/loading.gif">');
        loadTable();
        $.Shortcuts.start();
        $(function () {$('[data-toggle="tooltip"]').tooltip()})
    });

    function erro(){
        alert('Acesso negado! Redirecinando a pagina principal.');
         window.location.assign("../pages/chamadoespera.php");
    }

    function refresh_usuarios() {
        var url="../utilsPHP/atendentedispo.php";
        jQuery("#usuarios").load(url);
    }

    $(function() {
        refresh_usuarios();
    });

    setInterval(function(){
        refresh_usuarios();
    }, 5000);

    function loadAvisos(){
        $.ajax({
            type: "POST",
            url: "../pages/avisos.php",
            success:function(data){
                $("#avisos").html(data);
            }
        });
    }
    
    function loadResponsavelSemana(){
        $.ajax({
            type: "POST",
            url: "../utilsPHP/responsavelsemana.php",
            success:function(data){
                $("#plantao").html(data);
            }
        });
    }

    function loadTable(){
        $.ajax({
            type: 'POST',
            url: '../consultaTabelas/tabelahome.php',
            dataType:"json",
            success: function(data){ 
                if(data){
                    buildTable(data);
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('error: ' + textStatus + ': ' + errorThrown);
            }
        });
    }

    function buildTable(data){
        var len = data.length;
        var txt = "";
        if(len > 0){ 
            for(var i=0;i<len;i++){
                txt +="<tr>";
                if(data[i].status == "Aguardando Retorno"){
                    txt +='<td><div class="circle3" data-toggle="tooltip" data-placement="left" title="Aguardando Retorno"></div></td>';
                }else{
                    txt +='<td><div class="circle4" data-toggle="tooltip" data-placement="left" title="Entrado em contato"></div></td>';
                }
                txt+='<td>'+data[i].data+'</td>';
                txt+='<td>'+data[i].usuario+'</td>';

                if(data[i].enderecado == ""){
                    txt+='<td>Ninguém</td>';
                }else{
                    txt+='<td>'+data[i].enderecado+'</td>';
                }
                txt+='<td>'+data[i].empresa+'</td>';
                txt+='<td>'+data[i].contato+'</td>';
                txt+='<td>'+data[i].telefone+'</td>';
                txt+="<td><button data-toggle='tooltip' data-placement='left' title='Visualizar' class='btn btn-info bttt' type='button' onclick='abrirVisualizacao("+data[i].id_chamadoespera+")'><i class='glyphicon glyphicon-search'></i></button>&nbsp<a href='../pages/abrechamadoespera="+data[i].id_chamadoespera+"'><button data-toggle='tooltip' data-placement='right' title='Atender' class='btn btn-success bttt' type='button'><i class='glyphicon glyphicon-share-alt'></i></button></a></td>";
                txt+="</tr>";
            }
            
            if(txt != ""){
                $("#loading").html('');
                $("#tabela").append(txt);
                $('#tabela').DataTable({
                    pageLength: 10,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
                    }
                });
            }
        }else{
            $('#loading').html('<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Nenhum chamado aguardando retorno!</div>');
        }
    }

    $.extend( true, $.fn.dataTable.defaults, {
        "ordering": false
    } );

    $.extend( true, $.fn.dataTable.defaults, {
        responsive: isCelular(),
    } );

    function abrirVisualizacao(id){
        $("#modalConsulta").load("../modals/modalConsultaEspera.php?id_chamadoespera="+id);
        setTimeout(function(){
            $("#modalCon").modal('show');
        }, 300);
    }

    $("#adcChamado").hover(function(){
        $(".rotate").toggleClass("down"); 
    });

    $("#adcChamado").click(function(){
        openModal()
    });

    $.Shortcuts.add({
        type: 'down',
        mask: 'Alt+C',
        handler: function() {
           if(!($("#modalCad").data('bs.modal') || {}).isShown)
                openModal();
        }
    });

    function openModal(){
        $("#modalCadastro").load("../modals/modalCadChamado.php");
            setTimeout(function(){
                $("#modalCad").modal('show');
            }, 300);
    }

    function colorNotification(showBlue){
        if(showBlue)
            $("#labelNotification").addClass(' brand-info ');
        else
            $("#labelNotification").removeClass(' brand-info ');
    }    

    $("#showAtendente").click(function(){
        $("#sidebar").toggleClass("collapsedLeft");
        $("#content").toggleClass("col-md-12 col-md-8");
        $("#flecha").toggleClass("glyphicon-arrow-left glyphicon-arrow-right");
    })