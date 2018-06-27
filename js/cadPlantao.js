$("#gerarSobreaviso").click(function(){
    progressReport("Gerando relatório de sobreaviso");
})
components = [
 empresa = $("#empresa"),
 contato = $("#contato"),
 forma_contato = $("#formacontato"),
 telefone = $("#telefone"),
 versao = $("#versao"),
 dataPlantao = $("#data"),
 horainicio = $("#horainicio"),
 horafim = $("#horafim"),
 sistema = $("#sistema"),
 backup = $("#backup"),
 categoria = $("#categoria"),
 descproblema = $("#descproblema"),
 descsolucao = $("#descsolucao"),
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
        url: "../inserts/insere_plantao2.php",
        data: carregaDados(),
        success: function(data){
            data = data.trim();
            if(data == "success"){
                notificationSuccess('Registro salvo', 'Chamado registrado com sucesso!');
                resetForm();
                $("#submit").removeClass( ' disabled ' );
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

function carregaDados(){
    var data = [];
    data.push({name: 'empresa', value: empresa.val()});
    data.push({name: 'contato', value: contato.val()});
    data.push({name: 'telefone', value: telefone.val()});
    data.push({name: 'versao', value: versao.val()});
    data.push({name: 'formacontato', value: forma_contato.val()});
    data.push({name: 'categoria', value: categoria.val()});
    data.push({name: 'descproblema', value: descproblema.val()});
    data.push({name: 'backup', value: backup.val()});
    data.push({name: 'sistema', value: sistema.val()});
    data.push({name: 'horafim', value: horafim.val()});
    data.push({name: 'horainicio', value: horainicio.val()});
    data.push({name: 'data', value: dataPlantao.val()});
    data.push({name: 'descsolucao', value: descsolucao.val()});
    return data;
}

function resetForm(){
    empresa.val('');
    contato.val('');
    telefone.val('');
    versao.val('');
    forma_contato.val('');
    categoria.val('');
    descproblema.val('');
    backup.val('');
    sistema.val('');
    dataPlantao.val('');
    horafim.val('');
    horainicio.val('');
    descsolucao.val('');
    $('#infLoad').addClass('hidden');
    $('#erroLoad').addClass('hidden');
    $('#successLoad').addClass('hidden');
    $('#alertLoad').addClass('hidden');
    $('#resultado').html('<div class="alert alert-info" role="alert"><center>Novo chamado:</center></div>');
}
contato.focusout(function() {
    if(!isEmpty(contato.val()))
    $(contato.selector+"-div").removeClass("has-error");
});
empresa.focusout(function() {
    if(!isEmpty(empresa.val()))
    $(empresa.selector+"-div").removeClass("has-error");
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
horafim.focusout(function() {
    if(!isEmpty(horafim.val()))
    $(horafim.selector+"-div").removeClass("has-error");
});
horainicio.focusout(function() {
    if(!isEmpty(horainicio.val()))
    $(horainicio.selector+"-div").removeClass("has-error");
});
dataPlantao.focusout(function() {
    if(!isEmpty(dataPlantao.val()))
    $(dataPlantao.selector+"-div").removeClass("has-error");
});
descsolucao.focusout(function() {
    if(!isEmpty(descsolucao.val()))
    $(descsolucao.selector+"-div").removeClass("has-error");
});

function validarHorario(){
    var startTime = horainicio.val();
    var endTime = horafim.val();
    var regExp = /(\d{1,2})\:(\d{1,2})\:(\d{1,2})/;
    if(parseInt(endTime .replace(regExp, "$1$2$3")) < parseInt(startTime .replace(regExp, "$1$2$3"))){
        notificationWarningOne("Horário de termino deve ser maior que o horário de inicio");
        horafim.focus();
        return false;
    }
}
