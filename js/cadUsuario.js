components = [
    nome = $("#nome"),
    usuario = $("#usuario"),
    email = $("#email"),
    senha = $("#senha"),
    nivel = $("#nivel"),
    senhaConfirm = $("#senhaconfirm"),
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
        if(!ValidateEmail()){
            resetSubmit();
            return;
        }
        if(!validaLogin()){
            resetSubmit();
            return;
        }
    }else{
        resetSubmit();
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
        url: "../inserts/insereusuario.php",
        data: carregaDados(),
        success: function(data){
            data = data.trim();
            if(data == "success"){
                notificationSuccess('Registro salvo', 'Usuário cadastrado com sucesso!');
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
    data.push({name: 'nome', value: nome.val()});
    data.push({name: 'usuario', value: usuario.val()});
    data.push({name: 'email', value: email.val()});
    data.push({name: 'senha', value: senha.val()});
    data.push({name: 'nivel', value: nivel.val()});
    data.push({name: 'senhaConfirm', value: senhaConfirm.val()});
    return data;
}

function resetForm(){
    nome.val('');
    usuario.val('');
    email.val('');
    senha.val('');
    nivel.val('');
    senhaConfirm.val('');
    $(nome.selector+"-div").removeClass("has-error");
    $(usuario.selector+"-div").removeClass("has-error");
    $(email.selector+"-div").removeClass("has-error");
    $(senha.selector+"-div").removeClass("has-error");
    $(senhaConfirm.selector+"-div").removeClass("has-error");
    $(nivel.selector+"-div").removeClass("has-error");
}
nome.focusout(function() {
    if(!isEmpty(nome.val()))
    $(nome.selector+"-div").removeClass("has-error");
});
usuario.focusout(function() {
    if(!isEmpty(usuario.val()))
    $(usuario.selector+"-div").removeClass("has-error");
});
email.focusout(function() {
    if(!isEmpty(email.val()))
    $(email.selector+"-div").removeClass("has-error");
});
senha.focusout(function() {
    if(!isEmpty(senha.val()))
    $(senha.selector+"-div").removeClass("has-error");
});
senhaConfirm.focusout(function() {
    if(!isEmpty(senhaConfirm.val()))
    $(senhaConfirm.selector+"-div").removeClass("has-error");
    validarSenha();
});
nivel.focusout(function() {
    if(!isEmpty(nivel.val()))
    $(nivel.selector+"-div").removeClass("has-error");
});

function validarSenha(){
    if(senha.val() != senhaConfirm.val()){
        notificationWarningOne("Senha diferente da senha de confirmação!");
        senha.focus();
        return (false);
    }
    return (true);
}

function ValidateEmail() {
 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.val()))
  {
    return (true)
  }
    notificationWarningOne("Formato de e-mail invalido")
    email.focus();
    return (false)
}

function validaLogin(){
    $.ajax({
        type: "GET",
        url: "/chamados/utilsPHP/verificausuario.php?usuario=" + usuario.val(),
        success: function(data){
            if(data == 'valido'){
                enviarDados();
                return (true);
            }if(data == 'invalido'){
                notificationErrorOne('Erro!', 'Usuário <strong>'+usuario.val()+'</strong> indisponivel');
                usuario.focus();
                return (false);
            }if(data == 'vazio'){
                notificationWarningOne('Preencha o campo usuário');
                usuario.focus();
                return (false);
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
}

function resetSubmit(){
    $("#submit").removeClass("disabled");
    $("#submit").html("Cadastrar");
}