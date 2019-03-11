function erro(){
    alert('Acesso negado! Redirecinando a pagina principal.');
    window.location.assign("../pages/chamadoespera.php");
}
$('#empresafiltro').flexdatalist({
    minLength: 1,
    visibleProperties: '{cnpj} - {name}',
    valueProperty: '*',
    textProperty: 'name',
    searchIn: ['name', 'cnpj'],
    url: "../utilsPHP/search.php",
    noResultsText: 'Sem resultados para "{keyword}"',
    searchByWord: true,
    searchContain: true,
})


$(document).ready(function() {
    $("#loading").html('<img src="../imagem/loading.gif">');
    loadTable();
    $("#liChamados").addClass("active")
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
                txt +='<td><span class="badge badge-warning" data-toggle="tooltip" data-placement="left" title="Status: Aberto"></div> Aberto</td>';
            }else{
                txt +='<td><span class="badge badge-success" data-toggle="tooltip" data-placement="left" title="Status: Finalizado"></div> Finalizado</td>';
            }
            txt +="<td>"+ data[i].data +"</td><td>"+data[i].usuario+"</td><td>"+data[i].id_chamado+"</td><td>"+data[i].empresa+"</td><td>"+data[i].contato+"</td><td>"+data[i].telefone+"</td>";
            
            txt +='<td class="text-center">';
            if(data[i].status != "Finalizado"){
                txt +='<a style="margin-top:2px; margin-right:5px;" href="../pages/editachamado='+data[i].id_chamado+'"><button data-toggle="tooltip" data-placement="top" title="Editar chamado" class="btn btn-warning" type="button"><i class="fas fa-pencil-alt"></i></button></a>';
                txt +='<a style="margin-top:2px; margin-right:5px;" href="../pages/abrechamadofa='+data[i].id_chamado+'"><button data-toggle="tooltip" data-placement="top" title="Finalizar chamado" class="btn btn-success" type="button"><i class="far fa-check-circle"></i></button></a>';
            }
            txt +='<button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Consulta chamado" type="button" onclick="abrirVisualizacao('+data[i].id_chamado+')"><i class="fas fa-search"></i></button>';
            txt +='</td>';
        
            
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
                  },
                "order": [[ 3, "desc" ]] 
            }).columns.adjust().draw();
        }
    }else{
        $('#loading').html('<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Nenhum registro encontrado com os filtros informados</div>');
    }
}

function abrirVisualizacao(id){
    $("#modalConsulta").load("../modals/modalConsultaChamado.php?id_chamado="+id, function(){
        $("#modalCon").modal('show');
    });
}