
components= [
    id = $("#id_chamado"),
    empresa = $("#empresa"),
    contato = $("#contato"),
    forma_contato = $("#formaContato"),
    versao = $("#versao"),
    telefone = $("#telefone"),
    sistema = $("#sistema"),
    backup = $("#backup"),
    categoria = $("#categoria"),
    descproblema = $("#descproblema"),
    descsolucao = $("#descsolucao"),
]
erros = [];

$("#submit").click(function(){
    $("#submit").addClass( ' disabled ' );
    $("#submit").html('<img src="../imagem/ajax-loader.gif">');
    validar(components);
    return null;
})

$("#cancel").click(function(){
    window.location.assign("../pages/home");
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
        $("#submit").html("Finalizar");
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
        url: "../utilsPHP/altera_chamado.php",
        data: carregaDados(),
        success: function(data){
            data = data.trim();
            if(data == "success"){
                notificationSuccess('Registro salvo', 'Chamado finalizado com sucesso!');
                setTimeout(function(){
                    window.location.assign("../pages/chamados");
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
    data.push({name: 'id_chamado', value: id.val()});
    data.push({name: 'empresa', value: empresa.val()});
    data.push({name: 'contato', value: contato.val()});
    data.push({name: 'telefone', value: telefone.val()});
    data.push({name: 'versao', value: versao.val()});
    data.push({name: 'formacontato', value: forma_contato.val()});
    data.push({name: 'categoria', value: categoria.val()});
    data.push({name: 'descproblema', value: descproblema.val()});
    data.push({name: 'descsolucao', value: descsolucao.val()});
    data.push({name: 'backup', value: backup.val()});
    data.push({name: 'sistema', value: sistema.val()});
    return data;
}

contato.focusout(function() {
    if(!isEmpty(contato.val()))
    $(contato.selector+"-div").removeClass("has-error");
});
forma_contato.focusout(function() {
    if(!isEmpty(forma_contato.val()))
    $(forma_contato.selector+"-div").removeClass("has-error");
});
telefone.focusout(function() {
    if(!isEmpty(telefone.val()))
    $(telefone.selector+"-div").removeClass("has-error");
});
sistema.focusout(function() {
    if(!isEmpty(sistema.val()))
    $(sistema.selector+"-div").removeClass("has-error");
});
versao.focusout(function() {
    if(!isEmpty(versao.val()))
    $(versao.selector+"-div").removeClass("has-error");
});
backup.focusout(function() {
    if(!isEmpty(backup.val()))
    $(backup.selector+"-div").removeClass("has-error");
});
categoria.focusout(function() {
    if(!isEmpty(categoria.val()))
    $(categoria.selector+"-div").removeClass("has-error");
});
descproblema.focusout(function() {
    if(!isEmpty(descproblema.val()))
    $(descproblema.selector+"-div").removeClass("has-error");
});
descsolucao.focusout(function() {
    if(!isEmpty(descsolucao.val()))
    $(descsolucao.selector+"-div").removeClass("has-error");
});