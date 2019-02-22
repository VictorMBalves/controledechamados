const token = hex_md5(new Date().toString('yyyy')+'11586637000128'+new Date().toString('MM')+new Date().toString('d'))
const production = "http://api.gtech.site/";
const development = "http://localhost:3000/";

$( document ).ready(function() {
    $("#loading").html('<img src="../imagem/loading.gif">');
    loadTable();
    $("#liRegistroErros").addClass("active")
});


function loadTable(){
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": production+"error_tasks/",
        "method": "GET",
        "headers": {
          "Authorization": token,
          "Accept": "application/vnd.germantech.v2",
          "cache-control": "no-cache",
          "Postman-Token": "2caf4d18-3e5c-4d72-9de8-ffdfdf71fc93"
        }
      }
      
      $.ajax(settings).done(function (response) {
        buildTable(response);
      });
}

function buildTable(data){
    var len = data.length;
    var txt = "";
    if(len > 0){ 
        for(var i=0;i<len;i++){
            color = data[i].task_created ? "table-light" : "table-danger";
            txt +="<tr id="+i+" class="+color+" onclick='loadForm("+JSON.stringify(data[i])+")'>";
            txt+='<td>'+data[i].name+'</td>';
            txt+='<td>'+(data[i].reason == "ATUALIZACAO" ? "Atualização" : data[i].reason)+'</td>';
            txt+='<td>'+new Date(data[i].date_erro).toString('dd/MM/yyyy HH:mm:ss')+'</td>';
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
        $('#loading').html('<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>UAU, nenhum registro de exceção!</div>');
    }
} 

function loadForm(data){
    $("#error_task_id").val(data.id);
    $("#company").val(data.name);
    $("#message_error").val(data.message_error);
    $("#reason").val(data.reason == "ATUALIZACAO" ? "Atualização" : data.reason);
    $("#date_erro").val(new Date(data.date_erro).toString('dd/MM/yyyy HH:mm:ss'));
    $("#system").val(data.system);
    $("#last_version").val(data.version);
    $("#log").html(data.log);
    $("#phone").val(data.phone)
    $("#responsible").val(data.responsible)
    if(data.task_created){
        $("#createCall").attr('disabled', true);
    }else{
        $("#createCall").attr('disabled', false);
    }
}

$.extend( true, $.fn.dataTable.defaults, {
    "ordering": false
});

$("#createCall").click(function(){
    if(isEmpty($("#error_task_id").val())){
        notificationWarningOne("Deve ser selecionado um registro!")
        return false;
    }
    $("#submit").addClass( ' disabled ' );
    $("#submit").html('<img src="../imagem/ajax-loader.gif">');
    enviarDados()
})

function carregaDados(){
    var data = [];
    data.push({name: 'empresa', value: $("#company").val()});
    data.push({name: 'contato', value: $("#responsible").val()});
    data.push({name: 'telefone', value: $("#phone").val()});
    data.push({name: 'versao', value: $("#last_version").val()});
    data.push({name: 'formacontato', value: ""});
    data.push({name: 'categoria', value: $("#reason").val() == "ATUALIZACAO" ? "Atualização" : $("#reason").val()});
    data.push({name: 'descproblema', value:  $("#message_error").val()});
    data.push({name: 'backup', value: "1"});
    data.push({name: 'sistema', value: $("#system").val()});
    return data;
}

function enviarDados(){
    $.ajax({
        type: "POST",
        url: "../inserts/inserechamadoespera.php",
        data: carregaDados(),
        success: function(data){
            data = data.trim();
            if(data == "success"){
                notificationSuccess('Registro salvo', 'Chamado registrado com sucesso!');
                $("#createCall").removeClass('disabled');
                $("#createCall").html('Criar chamado em espera');
                registraAPI();
            }else{
                notificationError('Ocorreu um erro ao salvar o registro: ', data);
                $("#createCall").removeClass( ' disabled ' );
                $("#createCall").html('Criar chamado em espera');
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
}
function registraAPI(){
    var id = $("#error_task_id").val()

    var settings = {
    "async": false,
    "crossDomain": true,
    "url": production+"error_tasks/"+id,
    "method": "PUT",
    "dataType": "json",
    "headers": {
        "Authorization": token,
        "Accept": "application/vnd.germantech.v2",
    },
    "data":{
            "error_task": {
                "task_created": true,
            }
        }
    }

    $.ajax(settings).done(function (response) {
        window.location.reload(false);
    }).error(function(response){
        notificationError('Ocorreu um erro ao enviar o registro a API: ', response);
    });
}