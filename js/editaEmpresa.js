
$(document).ready(function(){
    $('#telefoneEdit').mask('(99) 9999-9999');
    $('#cnpjEdit').mask('99.999.999/9999-99');
    $('#celularEdit').mask('(99) 9999-99999');
})
components = [
    id = $("#id"),
    empresa = $("#empresaEdit"),
    cnpj = $("#cnpjEdit"),
    telefone = $("#telefoneEdit"),
    celular = $("#celularEdit"),
    backup = $("#backupEdit"),
    situacao = $("#situacaoEdit"),
   ];
   erros = [];
   
   $("#submit").click(function(){
       $("#submit").addClass( ' disabled ' );
       $("#submit").html('<img src="../imagem/ajax-loader.gif">');
       validar(components);
       return null;
   })
   $("#cancel").click(function(){
       window.location.assign("../pages/empresa");
   })
   function validar(components){
       erros = [];
       for(i = 0; i < components.length; i++){
           if(isEmpty(components[i].val()))
               erros.push(components[i].selector);
       }
       if(isEmpty(erros)){
           enviarDados();
       }else{
           $("#submit").removeClass("disabled");
           $("#submit").html("Salvar");
           for(i = 0; i < erros.length; i++){
               if(!$(erros[i]).hasClass("vazio")){
                   $(erros[i]).addClass("is-invalid");
               }
           }
           notificationWarningOne("Preencha os campos obrigatórios!");
       }
       return null;
   }
   
   function enviarDados(){
       $.ajax({
           type: "POST",
           url: "../updates/updateempresa.php",
           data: carregaDados(),
           success: function(data){
               data = data.trim();
               if(data == "success"){
                   notificationSuccess('Registro salvo', 'Empresa registrada com sucesso!');
                   setTimeout(function(){
                       window.location.assign("../pages/empresa");
                   }, 1000);
               }else{
                   notificationError('Ocorreu um erro ao salvar o registro: ', data);
                   $("#submit").removeClass( ' disabled ' );
                   $("#submit").html('Salvar');
               }
           },
           error: function(jqXHR, textStatus, errorThrown){
               alert('error: ' + textStatus + ': ' + errorThrown);
           }
       });
   }
   
   function carregaDados(){
       var data = [];
       data.push({name: 'id', value: id.val().toUpperCase()});
       data.push({name: 'empresa', value: empresa.val().toUpperCase()});
       data.push({name: 'cnpj', value: cnpj.val()});
       data.push({name: 'telefone', value: telefone.val()});
       data.push({name: 'celular', value: celular.val()});
       data.push({name: 'backup', value: backup.val()});
       data.push({name: 'situacao', value: situacao.val()});
       return data;
   }
   
   empresa.focusout(function() {
       if(!isEmpty(empresa.val()))
       $(empresa.selector).removeClass("is-invalid");
   });
   cnpj.focusout(function() {
       if(!isEmpty(cnpj.val()))
       $(cnpj.selector).removeClass("is-invalid");
   });
   telefone.focusout(function() {
       if(!isEmpty(telefone.val()))
       $(telefone.selector).removeClass("is-invalid");
   });
   situacao.focusout(function() {
       if(!isEmpty(situacao.val()))
       $(situacao.selector).removeClass("is-invalid");
   });
   backup.focusout(function() {
       if(!isEmpty(backup.val()))
       $(backup.selector).removeClass("is-invalid");
   });

$("#delete").click(function(){
    var dados = [];
    dados.push({name: 'id', value: id.val()});
    $.ajax({
        type: "POST",
        url: "../deletes/excluiEmpresa.php",
        data: dados,
        success: function(data){
            data = data.trim();
            if(data == "success"){
                notificationSuccess('Registro excluído', 'Empresa excluída com sucesso!');
                setTimeout(function(){
                    window.location.assign("../pages/empresa");
                }, 1000);
            }else{
                notificationError('Ocorreu um erro ao excluir o registro: ', data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
})