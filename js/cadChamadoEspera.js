$(document).ready(function() {
    $("#liChamados").addClass("active")
    $("#liChamados").children('a').click()
}); 
  
empresaEspera = $("#empresaEspera");
enderecadoEspera = $("#enderecado");
contatoEspera = $("#contatoespera");
telefoneEspera = $("#telefone");
versaoEspera = $("#versao");
sistemaEspera = $("#sistema");
descProblemaEspera = $("#desc_problema");
errosEspera = [];

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
    errosEspera = [];
    if(isEmpty(empresaEspera.val()))
        errosEspera.push(empresaEspera.selector);
    if(isEmpty(contatoEspera.val()))
        errosEspera.push(contatoEspera.selector);
    if(isEmpty(telefoneEspera.val()))
        errosEspera.push(telefoneEspera.selector);
    if(isEmpty(versaoEspera.val()))
        errosEspera.push(versaoEspera.selector);
    if(isEmpty(sistemaEspera.val()))
        errosEspera.push(sistemaEspera.selector);
    if(isEmpty(descProblemaEspera.val()))
        errosEspera.push(descProblemaEspera.selector);

    if(isEmpty(errosEspera)){
        enviarDados();
    }else{
        $("#submit").removeClass("disabled");
        $("#submit").html("Salvar");
        for(i = 0; i < errosEspera.length; i++){
            if(!$(errosEspera[i]).hasClass("vazio")){
                $(errosEspera[i]).addClass("is-invalid");
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
    empresaEspera.val('');
    contatoEspera.val('');
    telefoneEspera.val('');
    versaoEspera.val('');
    descProblemaEspera.val('');
    sistemaEspera.val('');
    $('#infLoad').addClass('hidden');
    $('#erroLoad').addClass('hidden');
    $('#successLoad').addClass('hidden');
    $('#alertLoad').addClass('hidden');
    $('#resultado').html('<div class="alert alert-info text-center" role="alert">Novo chamado em espera:</div>');
}

empresaEspera.focusout(function() {
    if(!isEmpty(empresaEspera.val()))
        $(empresaEspera.selector).removeClass("is-invalid");
});
enderecadoEspera.focusout(function() {
    if(!isEmpty(enderecadoEspera.val()))
        $(enderecadoEspera.selector).removeClass("is-invalid");
});
contatoEspera.focusout(function() {
    if(!isEmpty(contatoEspera.val()))
        $(contatoEspera.selector).removeClass("is-invalid");
});
telefoneEspera.focusout(function() {
    if(!isEmpty(telefoneEspera.val()))
        $(telefoneEspera.selector).removeClass("is-invalid");
});
versaoEspera.focusout(function() {
    if(!isEmpty(versaoEspera.val()))
        $(versaoEspera.selector).removeClass("is-invalid");
});
sistemaEspera.focusout(function() {
    if(!isEmpty(sistemaEspera.val()))
        $(sistemaEspera.selector).removeClass("is-invalid");
});
descProblemaEspera.focusout(function() {
    if(!isEmpty(descProblemaEspera.val()))
        $(descProblemaEspera.selector).removeClass("is-invalid");
});

function carregaDados(){
    var data = [];
    data.push({name: 'empresa', value: empresaEspera.val()});
    data.push({name: 'enderecado', value: enderecadoEspera.val()});
    data.push({name: 'contato', value: contatoEspera.val()});
    data.push({name: 'telefone', value: telefoneEspera.val()});
    data.push({name: 'versao', value: versaoEspera.val()});
    data.push({name: 'sistema', value: sistemaEspera.val()});
    data.push({name: 'descproblema', value: descProblemaEspera.val()});
    return data;
}

function erro() {
    alert('Acesso negado! Redirecinando a pagina principal.');
    window.location.assign("home");
}

$(function () {
    $.getJSON('../utilsPHP/search.php').done(function(response){
        $('#empresaEspera').flexdatalist({
            minLength: 1,
            searchIn: 'nome',
            data: response,
            noResultsText: 'Sem resultados para "{keyword}" <a href="../pages/cad_empresa?term={keyword}">Cadastrar!</a>',
        }).on('select:flexdatalist', function(ev, result){
            callApi(result.nome);
        });;
    });
});