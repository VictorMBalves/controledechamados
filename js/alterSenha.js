components = [
    senha = $("#senha"),
    senhaConfirm = $("#senhaconfirm"),
    userName = $("#nome")
];
erros = [];

$("#submit").click(function(){
    $("#submit").addClass( ' disabled ' );
    $("#submit").html('<img src="../imagem/ajax-loader.gif">');
    validar(components);
    return null;
})

$("#cancel").click(function(){
    resetForm();
})

function validar(components){
    erros = [];
    for(i = 0; i < components.length; i++){
        if(isEmpty(components[i].val()))
            erros.push(components[i].selector);
    }
    
    if(isEmpty(erros)){
        if(!validarSenha()){
            resetSubmit();
            return;
        }
        enviarDados();
    }else{
        resetSubmit();
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
        url: "../updates/updatesenha.php",
        data: carregaDados(),
        success: function(data){
            data = data.trim();
            if(data == "success"){
                notificationSuccess('Registro salvo', 'Senha alterada com sucesso!');
                resetForm();
                resetSubmit();
            }else{
                notificationError('Ocorreu um erro ao salvar o registro: ', data);
                resetSubmit();
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
}

function carregaDados(){
    var data = [];
    data.push({name: 'senha', value: senha.val()}); 
    data.push({name: 'usuario', value: userName.val()});
    return data;
}

senha.focusout(function() {
    if(!isEmpty(senha.val()))
    $(senha.selector).removeClass("is-invalid");
});

senhaConfirm.focusout(function() {
    if(!isEmpty(senhaConfirm.val()))
    $(senhaConfirm.selector).removeClass("is-invalid");
    validarSenha();
});

function validarSenha(){
    if(senha.val() != senhaConfirm.val()){
        notificationWarningOne("Senha diferente da senha de confirmação!");
        senha.focus();
        return (false);
    }
    return (true);
}

function resetSubmit(){
    $("#submit").removeClass("disabled");
    $("#submit").html("Alterar");
}

function resetForm(){
    senha.val('');
    senhaConfirm.val('');
}