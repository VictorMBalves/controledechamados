empresa = $("#empresa");
enderecado = $("#enderecado");
contato = $("#contato");
telefone = $("#telefone");
versao = $("#versao");
sistema = $("#sistema");
descProblema = $("#desc_problema");
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
$("#showAtendente").click(function(){
    $("#sidebar").toggleClass("collapsed");
    $("#content").toggleClass("col-md-9 col-md-12");
    $("#flecha").toggleClass("glyphicon-arrow-left glyphicon-arrow-right");
})

function validar(){ 
    erros = [];
    if(isEmpty(empresa.val()))
        erros.push(empresa.selector);
    if(isEmpty(contato.val()))
        erros.push(contato.selector);
    if(isEmpty(telefone.val()))
        erros.push(telefone.selector);
    if(isEmpty(versao.val()))
        erros.push(versao.selector);
    if(isEmpty(sistema.val()))
        erros.push(sistema.selector);
    if(isEmpty(descProblema.val()))
        erros.push(descProblema.selector);

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
        url: "../inserts/inserechamadoespera.php",
        data: carregaDados(),
        success: function(data){
            data = data.trim();
            console.log(data);
            if(data == "success"){
                notificationSuccess('Registro salvo', 'Chamado registrado com sucesso!');
                resetForm();
                $("#submit").removeClass('disabled');
                $("#submit").html('Salvar');
            }else if(data == "success1"){
                notificationSuccess('Registro salvo', 'Chamado registrado com sucesso!');
                resetForm();
                $("#submit").removeClass('disabled');
                $("#submit").html('Salvar');
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

function resetForm(){
    empresa.val('');
    contato.val('');
    telefone.val('');
    versao.val('');
    descProblema.val('');
    sistema.val('');
    $('#infLoad').addClass('hidden');
    $('#erroLoad').addClass('hidden');
    $('#successLoad').addClass('hidden');
    $('#alertLoad').addClass('hidden');
    $('#resultado').html('<div class="alert alert-info" role="alert"><center>Novo chamado em espera:</center></div>');
}

empresa.focusout(function() {
    if(!isEmpty(empresa.val()))
        $(empresa.selector+"-div").removeClass("has-error");
});
enderecado.focusout(function() {
    if(!isEmpty(enderecado.val()))
        $(enderecado.selector+"-div").removeClass("has-error");
});
contato.focusout(function() {
    if(!isEmpty(contato.val()))
        $(contato.selector+"-div").removeClass("has-error");
});
telefone.focusout(function() {
    if(!isEmpty(telefone.val()))
        $(telefone.selector+"-div").removeClass("has-error");
});
versao.focusout(function() {
    if(!isEmpty(versao.val()))
        $(versao.selector+"-div").removeClass("has-error");
});
sistema.focusout(function() {
    if(!isEmpty(sistema.val()))
        $(sistema.selector+"-div").removeClass("has-error");
});
descProblema.focusout(function() {
    if(!isEmpty(descProblema.val()))
        $(descProblema.selector+"-div").removeClass("has-error");
});

function carregaDados(){
    var data = [];
    data.push({name: 'empresa', value: empresa.val()});
    data.push({name: 'enderecado', value: enderecado.val()});
    data.push({name: 'contato', value: contato.val()});
    data.push({name: 'telefone', value: telefone.val()});
    data.push({name: 'versao', value: versao.val()});
    data.push({name: 'sistema', value: sistema.val()});
    data.push({name: 'descproblema', value: descProblema.val()});
    return data;
}

function refresh_usuarios() {
    var url = "../utilsPHP/atendentedispo.php";
    jQuery("#usuarios").load(url);
}

$(window).load(function (){
    $("#tarefas").addClass("col-sm-9");
})

$(function () {
    refresh_usuarios(); //first initialize
});
setInterval(function () {
    refresh_usuarios() // this will run after every 5 seconds
}, 5000);

function erro() {
    alert('Acesso negado! Redirecinando a pagina principal.');
    window.location.assign("home");
}
$(function () {
    $("#empresa").autocomplete({
        source: '../utilsPHP/search.php'
    });
});