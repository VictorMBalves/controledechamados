$(document).ready(function() {
    $("#loading").html('<img src="imagem/loading.gif">');
    loadTable();
});

function erro() {
    alert('Acesso negado! Redirecinando a pagina principal.');
    window.location.assign("../pages/home.php");
}

function cancelar() {
    window.location.assign("../pages/chamados.php");
}

$(function() {
    $("input[name='usuario']").on('blur', function() {
        var usuario = $(this).val();
        $.get('../utilsPHP/verificausuario.php?usuario=' + usuario, function(data) {
            $('#resultado').html(data);
        });
    });
});

function loadTable(){
    $.ajax({
        type: 'POST',
        url: '../consultaTabelas/tabelausuarios.php',
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
            txt+='<td>'+data[i].id+'</td>';
            txt+='<td>'+data[i].nome+'</td>';
            txt+='<td>'+data[i].usuario+'</td>';
            txt+='<td>'+data[i].email+'</td>';
            txt+="<td><a style='margin-top:2px;' href='../pages/editausuario.php?id="+data[i].id+"'><button data-toggle='tooltip' data-placement='left' title='Editar cadastro' class='btn btn-warning btn-sm btn-block' type='button'><span class='glyphicon glyphicon-pencil'></span></button></a></td>";
            txt+="</tr>";
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