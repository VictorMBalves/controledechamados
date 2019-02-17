function erro(){
    alert('Acesso negado! Redirecinando a pagina principal.');
    window.location.assign("../pages/chamadoespera.php");
}  

$( document ).ready(function(){
    $("#loading").html('<img src="../imagem/loading.gif">');
    $("#loadingdirecionados").html('<img src="../imagem/loading.gif">');
    loadTable();
    loadTableDirecionados();
});

function loadTable(){
    $.ajax({
        type: 'POST',
        url: '../consultaTabelas/tabelameuschamados.php',
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
            txt +="<tr><td>";
            if(data[i].status !="Finalizado"){
                txt +='<span class="badge badge-warning" data-toggle="tooltip" data-placement="left" title="Status: Aberto">Aberto</span>';
            }else{
                txt +='<span class="badge badge-success" data-toggle="tooltip" data-placement="left" title="Status: Finalizado">Finalizado</span>';
            }
            txt +="</td><td>"+ data[i].data +"</td><td>"+data[i].usuario+"</td><td>"+data[i].id_chamado+"</td><td>"+data[i].empresa+"</td><td>"+data[i].contato+"</td><td>"+data[i].telefone+"</td>";
        
            if (data[i].status !="Finalizado") {
                txt +='<td class="text-center">';
                txt +='<a style="margin-top:2px; margin-right:5px;" href="../pages/editachamado='+data[i].id_chamado+'"><button data-toggle="tooltip" data-placement="left" title="Editar chamado" class="btn btn-warning" type="button"><i class="fas fa-pencil-alt"></i></button></a>';
                txt +='<a href="../pages/abrechamadofa='+data[i].id_chamado+'"><button data-toggle="tooltip" data-placement="left" title="Finalizar chamado" class="btn btn-success" type="button"><i class="far fa-check-circle"></i></button></a>';
                txt +='</td>';
            }else{
                txt +='<td><button class="btn btn-info btn-sm btn-block" type="button" onclick="abrirVisualizacao('+data[i].id_chamado+')">Consultar</button></td>';
            }  
            txt +='</tr>';
        }

        if(txt != ""){
            $("#loading").html('');
            $("#tabela").append(txt);
            $('#tabela').DataTable({
                pageLength: 10,
                responsive: isCelular(),
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
                },
                "initComplete": function(settings, json) {
                    $('[data-toggle="tooltip"]').tooltip()
                  }
            });
        }
    }else{
        $('#loading').html('<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Nenhum registro encontrado</div>');
    }
}


function loadTableDirecionados(){
    $.ajax({
        type: 'POST',
        url: '../consultaTabelas/tabeladirecionados.php',
        dataType:"json",
        success: function(data){ 
            if(data){
                buildTableDirecionados(data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
}

function buildTableDirecionados(data){
    var len = data.length;
    var txt = "";
    if(len > 0){
        for(var i=0;i<len;i++){
            txt +="<tr>";
            if(data[i].status == "Aguardando Retorno"){
                txt +='<td><span class="badge badge-warning" data-toggle="tooltip" data-placement="left" title="Aguardando Retorno">Aguardando Retorno</span></td>';
            }else{
                txt +='<td><span class="badge badge-info" data-toggle="tooltip" data-placement="left" title="Entrado em contato">Entrado em contato</span></td>';
            }
            txt+='<td>'+data[i].data+'</td>';
            txt+='<td>'+data[i].id_chamadoespera+'</td>';
            txt+='<td>'+data[i].usuario+'</td>';
            txt+='<td>'+data[i].empresa+'</td>';
            txt+='<td>'+data[i].contato+'</td>';
            txt+='<td>'+data[i].telefone+'</td>';
            txt+="<td><button data-toggle='tooltip' data-placement='left' title='Visualizar' class='btn btn-info' type='button' onclick='abrirVisualizacaoEspera("+data[i].id_chamadoespera+")'><i class='fas fa-search'></i></button> <a href='../pages/abrechamadoespera="+data[i].id_chamadoespera+"'><button data-toggle='tooltip' data-placement='right' title='Atender' class='btn btn-success' type='button'><i class='fas fa-share'></i></button></a></td>";
            txt+="</tr>";
        }

        if(txt != ""){
            $("#loadingdirecionados").html('');
            $("#tabeladirecionados").append(txt);
            $('#tabeladirecionados').DataTable({
                pageLength: 10,
                responsive: isCelular(),
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
                },
                "initComplete": function(settings, json) {
                    $('[data-toggle="tooltip"]').tooltip()
                  }
            });
        }
    }else{
        $('#loadingdirecionados').html('<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Que bom, você não possuí nenhum chamado direcionado aguardando Retorno!</div>');
    }
}

$.extend( true, $.fn.dataTable.defaults, {
    "ordering": false
} );

function abrirVisualizacao(id){
    $("#modalConsulta").load("../modals/modalConsultaChamado.php?id_chamado="+id);
    setTimeout(function(){
        $("#modalCon").modal('show');
    }, 300);
}

function abrirVisualizacaoEspera(id){
    $("#modalConsulta").load("../modals/modalConsultaEspera.php?id_chamadoespera="+id);
    setTimeout(function(){
        $("#modalCon").modal('show');
    }, 300);
}