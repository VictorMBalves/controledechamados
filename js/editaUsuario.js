
id = $("#id")
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
        url: "../updates/updateusuario.php",
        data: carregaDados(),
        success: function(data){
            data = data.trim();
            if(data == "success"){
                notificationSuccess('Registro salvo', 'Usuário cadastrado com sucesso!');
                setTimeout(function(){
                    window.location.assign("../pages/cad_usuario");
                }, 1000);
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
    data.push({name: 'id', value: id.val()});
    data.push({name: 'nome', value: nome.val()});
    data.push({name: 'usuario', value: usuario.val()});
    data.push({name: 'email', value: email.val()});
    data.push({name: 'senha', value: senha.val()});
    data.push({name: 'nivel', value: nivel.val()});
    data.push({name: 'senhaConfirm', value: senhaConfirm.val()});
    data.push({name: 'enviarEmail', value: $("#enviarEmail").val()});
    return data;
}

function resetForm(){
    nome.val('');
    usuario.val('');
    email.val('');
    senha.val('');
    nivel.val('');
    senhaConfirm.val('');
    $(nome.selector).removeClass("is-invalid");
    $(usuario.selector).removeClass("is-invalid");
    $(email.selector).removeClass("is-invalid");
    $(senha.selector).removeClass("is-invalid");
    $(senhaConfirm.selector).removeClass("is-invalid");
    $(nivel.selector).removeClass("is-invalid");
}
nome.focusout(function() {
    if(!isEmpty(nome.val()))
    $(nome.selector).removeClass("is-invalid");
});
usuario.focusout(function() {
    if(!isEmpty(usuario.val()))
    $(usuario.selector).removeClass("is-invalid");
});
email.focusout(function() {
    if(!isEmpty(email.val()))
    $(email.selector).removeClass("is-invalid");
});
senha.focusout(function() {
    if(!isEmpty(senha.val()))
    $(senha.selector).removeClass("is-invalid");
});
senhaConfirm.focusout(function() {
    if(!isEmpty(senhaConfirm.val()))
    $(senhaConfirm.selector).removeClass("is-invalid");
    validarSenha();
});
nivel.focusout(function() {
    if(!isEmpty(nivel.val()))
    $(nivel.selector).removeClass("is-invalid");
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

function resetSubmit(){
    $("#submit").removeClass("disabled");
    $("#submit").html("Cadastrar");
}

$("#delete").click(function(){
    id = $("#id");
    var dados = [];
    dados.push({name: 'id', value: id.val()});
    $.ajax({
        type: "POST",
        url: "../deletes/excluiUsuario.php",
        data: dados,
        success: function(data){
            data = data.trim();
            if(data == "success"){
                notificationSuccess('Registro excluído', 'Usuário excluído com sucesso!');
                setTimeout(function(){
                    window.location.assign("../pages/cad_usuario");
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