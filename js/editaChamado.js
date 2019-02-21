id = $("#id_chamado");
empresa = $("#empresaEdit");
contato = $("#contatoEdit");
forma_contato = $("#formaContatoEdit");
versao = $("#versaoEdit");
telefone = $("#telefoneEdit");
sistema = $("#sistemaEdit");
backup = $("#backupEdit");
categoria = $("#categoriaEdit");
descproblema = $("#descproblemaEdit");
erros = [];
$("#alterar").click(function(){
    $("#alterar").addClass( ' disabled ' );
    $("#alterar").html('<img src="../imagem/ajax-loader.gif">');
    validar();
    return null;
})
$("#cancel").click(function(){
    window.location.assign("../pages/home");
})

function validar(){ 
    erros = [];
    if(isEmpty(empresa.val()))
        erros.push(empresa.selector);
    if(isEmpty(contato.val()))
        erros.push(contato.selector);
    if(isEmpty(forma_contato.val()))
        erros.push(forma_contato.selector);
    if(isEmpty(telefone.val()))
        erros.push(telefone.selector);
    if(isEmpty(versao.val()))
        erros.push(versao.selector);
    if(isEmpty(sistema.val()))
        erros.push(sistema.selector);
    if(isEmpty(descproblema.val()))
        erros.push(descproblema.selector);
    if(isEmpty(backup.val()))
        erros.push(backup.selector);
    if(isEmpty(categoria.val()))
        erros.push(categoria.selector);
            
    if(isEmpty(erros)){
        enviarDados();
    }else{
        $("#alterar").removeClass("disabled");
        $("#alterar").html("Salvar");
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
        url: "../updates/updatechamado.php",
        data: carregaDados(),
        success: function(data){
            data = data.trim();
            if(data == "success"){
                notificationSuccess('Registro salvo', 'Chamado atualizado com sucesso!');
                setTimeout(function(){
                    window.location.assign("../pages/chamados");
                }, 1000);
            }else{
                notificationError('Ocorreu um erro ao atualizar o registro: ', data);
                $("#submit").removeClass( ' disabled ' );
                $("#submit").html('Alterar');
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
}

function carregaDados(){
    var data = [];
    data.push({name: 'id_chamado', value: id.val()});
    data.push({name: 'empresa', value: empresa.val()});
    data.push({name: 'contato', value: contato.val()});
    data.push({name: 'telefone', value: telefone.val()});
    data.push({name: 'versao', value: versao.val()});
    data.push({name: 'formacontato', value: forma_contato.val()});
    data.push({name: 'categoria', value: categoria.val()});
    data.push({name: 'descproblema', value: descproblema.val()});
    data.push({name: 'backup', value: backup.val()});
    data.push({name: 'sistema', value: sistema.val()});
    return data;
}

contato.focusout(function() {
    if(!isEmpty(contato.val()))
    $(contato.selector).removeClass("is-invalid");
});
empresa.focusout(function() {
    if(!isEmpty(empresa.val()))
    $(empresa.selector).removeClass("is-invalid");
});
forma_contato.focusout(function() {
    if(!isEmpty(forma_contato.val()))
    $(forma_contato.selector).removeClass("is-invalid");
});
telefone.focusout(function() {
    if(!isEmpty(telefone.val()))
    $(telefone.selector).removeClass("is-invalid");
});
sistema.focusout(function() {
    if(!isEmpty(sistema.val()))
    $(sistema.selector).removeClass("is-invalid");
});
versao.focusout(function() {
    if(!isEmpty(versao.val()))
    $(versao.selector).removeClass("is-invalid");
});
backup.focusout(function() {
    if(!isEmpty(backup.val()))
    $(backup.selector).removeClass("is-invalid");
});
categoria.focusout(function() {
    if(!isEmpty(categoria.val()))
    $(categoria.selector).removeClass("is-invalid");
});
descproblema.focusout(function() {
    if(!isEmpty(descproblema.val()))
    $(descproblema.selector).removeClass("is-invalid");
});


