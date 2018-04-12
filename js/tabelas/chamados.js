function erro(){
    alert('Acesso negado! Redirecinando a pagina principal.');
    window.location.assign("chamadoespera.php");
}
$(function () {$('#skills').autocomplete({source: 'search.php'});});
$(function () {$('[data-toggle="popover"]').popover()});
$(function () {$('[data-toggle="tooltip"]').tooltip()});

$(document).ready(function() {
    $("#loading").html('<img src="imagem/loading.gif">');
    loadTable();
});

$("#buscar").on("click", function(){
    $("#loading").html('<img src="imagem/loading.gif">');
    var data = $('#filtros').serialize();
    $.ajax({
        type: 'POST',
        url: 'consultaTabelas/tabelachamados.php',
        data: data,
        dataType:"json",
        success: function(data){ 
            $('#tabela').DataTable().destroy();
            $('#tbody').empty();
            if(data){
                buildTable(data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
    return false;
});

$("#refresh").on("click", function(){
    $("#loading").html('<img src="imagem/loading.gif">');
    $('#tabela').DataTable().destroy();
    $('#tbody').empty();
    loadTable();
    return false;
});

function loadTable(){
    $.ajax({
        type: 'POST',
        url: 'consultaTabelas/tabelachamados.php',
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
                txt +='<div class="circle2" data-toggle="tooltip" data-placement="left" title="Status: Aberto"></div>';
            }else{
                txt +='<div class="circle" src="imagem/bullet_green.png" data-toggle="tooltip" data-placement="left" title="Status: Finalizado"></div>';
            }
            txt +="</td><td>"+ data[i].data +"</td><td>"+data[i].usuario+"</td><td>"+data[i].id_chamado+"</td><td>"+data[i].empresa+"</td><td>"+data[i].contato+"</td><td>"+data[i].telefone+"</td>";
        
            if (data[i].status !="Finalizado") {
                txt +='<td><center>';
                txt +='<a style="margin-top:2px; margin-right:5px;" href="editachamado.php?id_chamado='+data[i].id_chamado+'"><button data-toggle="tooltip" data-placement="left" title="Editar chamado" class="btn btn-warning" type="button"><span class="glyphicon glyphicon-pencil"></span></button></a>';
                txt +='<a href="abrechamado.php?id_chamado='+data[i].id_chamado+'"><button data-toggle="tooltip" data-placement="left" title="Finalizar chamado" class="btn btn-success" type="button"><span class="glyphicon glyphicon-ok"></span></button></a>';
                txt +='</center></td>';
            }else{
                txt +='<td><a href="consulta.php?id_chamado='+data[i].id_chamado+'"><button class="btn btn-info btn-sm btn-block" type="button">Consultar</button></a> </td>';
            }  
            txt +='</tr>';
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
        $('#loading').html('<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Nenhum registro encontrado com os filtros informados</div>');
    }
}