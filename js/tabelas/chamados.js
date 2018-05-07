function erro(){
    alert('Acesso negado! Redirecinando a pagina principal.');
    window.location.assign("../pages/chamadoespera.php");
}
$(function () {$('#skills').autocomplete({source: '../utilsPHP/search.php'});});
$(function () {$('[data-toggle="popover"]').popover();});
$(function () {$('[data-toggle="tooltip"]').tooltip();});

$(document).ready(function() {
    $("#loading").html('<img src="../imagem/loading.gif">');
    loadTable();
});

$("#buscar").on("click", function(){
    $("#loading").html('<img src="../imagem/loading.gif">');
    var data = $('#filtros').serialize();
    $.ajax({
        type: 'POST',
        url: '../consultaTabelas/tabelachamados.php',
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
    $("#loading").html('<img src="../imagem/loading.gif">');
    $('#tabela').DataTable().destroy();
    $('#tbody').empty();
    loadTable();
    return false;
});

function loadTable(){
    $.ajax({
        type: 'POST',
        url: '../consultaTabelas/tabelachamados.php',
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
            if(data[i].status !="Finalizado"){
                txt +='<td><div class="circle2" data-toggle="tooltip" data-placement="left" title="Status: Aberto"></div></td>';
            }else{
                txt +='<td><div class="circle" data-toggle="tooltip" data-placement="left" title="Status: Finalizado"></div></td>';
            }
            txt +="<td>"+ data[i].data +"</td><td>"+data[i].usuario+"</td><td>"+data[i].id_chamado+"</td><td>"+data[i].empresa+"</td><td>"+data[i].contato+"</td><td>"+data[i].telefone+"</td>";
        
            if (data[i].status !="Finalizado") {
                txt +='<td><center>';
                txt +='<a style="margin-top:2px; margin-right:5px;" href="../pages/editachamado.php?id_chamado='+data[i].id_chamado+'"><button data-toggle="tooltip" data-placement="left" title="Editar chamado" class="btn btn-warning" type="button"><span class="glyphicon glyphicon-pencil"></span></button></a>';
                txt +='<a href="../pages/abrechamado.php?id_chamado='+data[i].id_chamado+'"><button data-toggle="tooltip" data-placement="left" title="Finalizar chamado" class="btn btn-success" type="button"><span class="glyphicon glyphicon-ok"></span></button></a>';
                txt +='</center></td>';
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
                }
            });
        }
    }else{
        $('#loading').html('<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Nenhum registro encontrado com os filtros informados</div>');
    }
}

function abrirVisualizacao(id){
    $("#modalConsulta").load("../pages/modalConsultaChamado.php?id_chamado="+id);
    setTimeout(function(){
        $("#modalCon").modal('show');
    }, 300);
}