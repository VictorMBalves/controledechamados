$( document ).ready(function() {
    $("#loading").html('<img src="imagem/loading.gif">');
    loadTable();
});

function erro(){
    alert('Acesso negado! Redirecinando a pagina principal.');
    window.location.assign("chamadoespera.php");
}
$(function() {
    $( "#skills" ).autocomplete({
        source: 'search.php'
    });
});

function validarHorario(){
    var startTime = formplantao.horainicio.value;
    var endTime = formplantao.horafim.value;
    var regExp = /(\d{1,2})\:(\d{1,2})\:(\d{1,2})/;
    if(parseInt(endTime .replace(regExp, "$1$2$3")) < parseInt(startTime .replace(regExp, "$1$2$3"))){
        alert("Horário de termino deve ser maior que o horário de inicio");
        formplantao.horafim.focus();
        return false;
    }
}

function loadTable(){
    $.ajax({
        type: 'POST',
        url: 'consultaTabelas/tabelaplantao.php',
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
            txt+='<tr>';
            txt+='<td><div class="circle" data-toggle="tooltip" data-placement="left" title="Status: Finalizado"></div></td>';
            txt+='<td>'+data[i].data+'</td>';
            txt+='<td>'+data[i].usuario+'</td>';
            txt+='<td>'+data[i].id_plantao+'</td>';
            txt+='<td>'+data[i].empresa+'</td>';
            txt+='<td>'+data[i].contato+'</td>';
            txt+='<td>'+data[i].telefone+'</td>';
            txt+="<td><a href='consultaespera.php?id_chamadoespera="+data[i].id_chamadoespera+"'><button data-toggle='tooltip' data-placement='left' title='Visualizar' class='btn btn-info bttt' type='button'><i class='glyphicon glyphicon-search'></i></button></a> <a href='abrechamadoespera.php?id_chamadoespera="+data[i].id_chamadoespera+"'><button data-toggle='tooltip' data-placement='right' title='Atender' class='btn btn-success bttt' type='button'><i class='glyphicon glyphicon-share-alt'></i></button></a></td>";
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
        $('#loading').html('<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Nenhum registro encontrado</div>');
    }
}

$.extend( true, $.fn.dataTable.defaults, {
    "ordering": false
} );