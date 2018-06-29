$(function () {$('#skills').autocomplete({source: '../utilsPHP/search.php'});});

$(document).ready(function() {
    $("#loading").html('<img src="../imagem/loading.gif">');
    loadTable();
});

$("#buscar").on("click", function(){
    $("#loading").html('<img src="../imagem/loading.gif">');
    var data = $('#filtros').serialize();
    $.ajax({
        type: 'POST',
        url: '../consultaTabelas/tabelaempresas.php',
        data: data,
        dataType:"json",
        success: function(dados){ 
            $('#tabela').DataTable().destroy();
            $('#tbody').empty();
            if(dados){
                buildTable(dados);
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
    return false;
});
$("#novo").on("click", function(){
    window.location.assign("/chamados/pages/cad_empresa");
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
        url: '../consultaTabelas/tabelaempresas.php',
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
            txt +="<tr><td>"+data[i].id_empresa+"</td>";
            txt +="<td>"+ data[i].nome +"</td>";
            txt +="<td>"+data[i].situacao+"</td>";
            txt +="<td>"+data[i].cnpj+"</td>";
            if(data[i].sistema == null){
                txt +="<td></td>";
            }else{
                txt +="<td>"+data[i].sistema+"</td>";
            }
            if(data[i].versao == null){
                txt +="<td></td>";
            }else{
                txt +="<td>"+data[i].versao+"</td>";
            }
            txt +="<td><a style='margin-top:2px;' href='../pages/editaempresa/"+data[i].id_empresa+"'><button data-toggle='tooltip' data-placement='left' title='Editar Cadastro' class='btn btn-warning btn-sm btn-block' type='button'><span class='glyphicon glyphicon-pencil'></span></button></a></td>";
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