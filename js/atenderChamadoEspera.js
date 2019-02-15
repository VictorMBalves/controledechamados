    
    id = $("#id_chamado");
    empresa = $("#empresa");
    contato = $("#contato");
    formaContato = $("#forma_contato");
    telefone = $("#telefone");
    sistema = $("#sistema");
    versao = $("#versao");
    backup = $("#backup");
    categoria = $("#categoria");
    descProblema = $("#descricao_proplema");
    erros = [];
$("#submit").click(function(){
    $("#submit").addClass( ' disabled ' );
    $("#submit").html('<img src="../imagem/ajax-loader.gif">');
    validar();
    return null;
})
$("#cancel").click(function(){
    window.location.assign("../pages/home");
})

function validar(){ 
    erros = [];
    if(isEmpty(id.val()))
        erros.push(id.selector);
    if(isEmpty(empresa.val()))
        erros.push(empresa.selector);
    if(isEmpty(contato.val()))
        erros.push(contato.selector);
    if(isEmpty(formaContato.val()))
        erros.push(formaContato.selector);
    if(isEmpty(telefone.val()))
        erros.push(telefone.selector);
    if(isEmpty(sistema.val()))
        erros.push(sistema.selector);
    if(isEmpty(versao.val()))
        erros.push(versao.selector);
    if(isEmpty(backup.val()))
        erros.push(backup.selector);
    if(isEmpty(categoria.val()))
        erros.push(categoria.selector);
    if(isEmpty(descProblema.val()))
        erros.push(descProblema.selector);

    if(isEmpty(erros)){
        enviarDados();
    }else{
        $("#submit").removeClass("disabled");
        $("#submit").html("Atender");
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
        url: "../inserts/insere_chamado2.php",
        data: carregaDados(),
        success: function(data){
            data = JSON.parse(data);
            if(data.status == "success"){
                notificationSuccess('Registro salvo', 'Chamado registrado com sucesso!');
                setTimeout(function(){
                    window.location.assign("../pages/chamados");
                }, 1000);
            }else{
                notificationError('Ocorreu um erro ao salvar o registro: ', data);
                $("#submit").removeClass( ' disabled ' );
                $("#submit").html('Atender');
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
}

contato.focusout(function() {
    if(!isEmpty(contato.val()))
    $(contato.selector).removeClass("is-invalid");
});
formaContato.focusout(function() {
    if(!isEmpty(formaContato.val()))
    $(formaContato.selector).removeClass("is-invalid");
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
descProblema.focusout(function() {
    if(!isEmpty(descProblema.val()))
    $(descProblema.selector).removeClass("is-invalid");
});

function carregaDados(){
    var data = [];
    data.push({name: 'id_chamadoespera', value: id.val()});
    data.push({name: 'empresa', value: empresa.val()});
    data.push({name: 'contato', value: contato.val()});
    data.push({name: 'telefone', value: telefone.val()});
    data.push({name: 'versao', value: versao.val()});
    data.push({name: 'formacontato', value: formaContato.val()});
    data.push({name: 'categoria', value: categoria.val()});
    data.push({name: 'descproblema', value: descProblema.val()});
    data.push({name: 'backup', value: backup.val()});
    data.push({name: 'sistema', value: sistema.val()});
    return data;
}