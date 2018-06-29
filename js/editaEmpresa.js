components = [
    id = $("#id"),
    empresa = $("#empresa"),
    cnpj = $("#cnpj"),
    telefone = $("#telefone"),
    celular = $("#celular"),
    backup = $("#backup"),
    situacao = $("#situacao"),
   ];
   erros = [];
   
   $("#submit").click(function(){
       $("#submit").addClass( ' disabled ' );
       $("#submit").html('<img src="/chamados/imagem/ajax-loader.gif">');
       validar(components);
       return null;
   })
   $("#cancel").click(function(){
       window.location.assign("/chamados/pages/empresa");
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
                   $(erros[i]+"-div").addClass("has-error");
               }
           }
           notificationWarningOne("Preencha os campos obrigatórios!");
       }
       return null;
   }
   
   function enviarDados(){
       $.ajax({
           type: "POST",
           url: "/chamados/updates/updateempresa.php",
           data: carregaDados(),
           success: function(data){
               data = data.trim();
               if(data == "success"){
                   notificationSuccess('Registro salvo', 'Empresa registrada com sucesso!');
                   setTimeout(function(){
                       window.location.assign("/chamados/pages/empresa");
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
       $(empresa.selector+"-div").removeClass("has-error");
   });
   cnpj.focusout(function() {
       if(!isEmpty(cnpj.val()))
       $(cnpj.selector+"-div").removeClass("has-error");
   });
   telefone.focusout(function() {
       if(!isEmpty(telefone.val()))
       $(telefone.selector+"-div").removeClass("has-error");
   });
   situacao.focusout(function() {
       if(!isEmpty(situacao.val()))
       $(situacao.selector+"-div").removeClass("has-error");
   });
   backup.focusout(function() {
       if(!isEmpty(backup.val()))
       $(backup.selector+"-div").removeClass("has-error");
   });

$("#delete").click(function(){
    var dados = [];
    dados.push({name: 'id', value: id.val()});
    $.ajax({
        type: "POST",
        url: "/chamados/deletes/excluiEmpresa.php",
        data: dados,
        success: function(data){
            data = data.trim();
            if(data == "success"){
                notificationSuccess('Registro excluído', 'Empresa excluída com sucesso!');
                setTimeout(function(){
                    window.location.assign("/chamados/pages/empresa");
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