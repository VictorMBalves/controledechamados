$( document ).ready(function() {
    $("#loading").html('<img src="../imagem/loading.gif">');
    loadTable();
});

function erro(){
    alert('Acesso negado! Redirecinando a pagina principal.');
    window.location.assign("../pages/chamadoespera.php");
}
$(function () {
    $.getJSON('../utilsPHP/search.php').done(function(response){
        $('#empresaCad').flexdatalist({
            minLength: 1,
            searchIn: 'nome',
            data: response,
            noResultsText: 'Sem resultados para "{keyword}" <a href="../pages/cad_empresa?term={keyword}">Cadastrar!</a>',
        }).on('select:flexdatalist', function(ev, result){
            callApi(result.nome);
        });;
    });
});

function loadTable(){
    $.ajax({
        type: 'POST',
        url: '../consultaTabelas/tabelaplantao.php',
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
            txt+='<td><span class="badge badge-info" data-toggle="tooltip" data-placement="left" title="Status: Finalizado">Finalizado</span></td>';
            txt+='<td>'+data[i].data+'</td>';
            txt+='<td>'+data[i].usuario+'</td>';
            txt+='<td>'+data[i].id_plantao+'</td>';
            txt+='<td>'+data[i].empresa+'</td>';
            txt+='<td>'+data[i].contato+'</td>';
            txt+='<td>'+data[i].telefone+'</td>';
            txt+='<td><button class="btn btn-info btn-sm btn-block" type="button" onclick="abrirVisualizacao('+data[i].id_plantao+')">Consultar</button></td>';
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

$.extend( true, $.fn.dataTable.defaults, {
    "ordering": false
} );

function abrirVisualizacao(id){
    $("#modalConsulta").load("../modals/modalConsultaPlantao.php?id_plantao="+id);
    setTimeout(function(){
        $("#modalCon").modal('show');
    }, 300);
}