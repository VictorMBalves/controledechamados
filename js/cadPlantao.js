$("#gerarSobreaviso").click(function(){
    progressReport("Gerando relatório de sobreaviso");
})
components = [
 empresa = $("#empresaCad"),
 contato = $("#contatoCad"),
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

$("#salvarPlantao").click(function(){
    $("#salvarPlantao").addClass( ' disabled ' );
    $("#salvarPlantao").html('<img src="../imagem/ajax-loader.gif">');
    validarPlantao(components);
    return null;
})
$("#cancel").click(function(){
    resetForm();
})
function validarPlantao(components){
    erros = [];
    for(i = 0; i < components.length; i++){
        if(isEmpty(components[i].val()))
            erros.push(components[i].selector);
    }
    if(isEmpty(erros)){
        if(!validarHorario()){
            $("#salvarPlantao").removeClass("disabled");
            $("#salvarPlantao").html("Salvar");
            return;
        }
        enviarDadosPlantao();
    }else{
        $("#salvarPlantao").removeClass("disabled");
        $("#salvarPlantao").html("Salvar");
        for(i = 0; i < erros.length; i++){
            if(!$(erros[i]).hasClass("vazio")){
                $(erros[i]).addClass("is-invalid");
            }
        }
        notificationWarningOne("Preencha os campos obrigatórios!");
    }
    return null;
}

function enviarDadosPlantao(){
    $.ajax({
        type: "POST",
        url: "../inserts/insere_plantao2.php",
        data: carregaDados(),
        success: function(data){
            data = data.trim();
            if(data == "success"){
                notificationSuccess('Registro salvo', 'Chamado registrado com sucesso!');
                resetForm();
                $("#salvarPlantao").removeClass( ' disabled ' );
                $("#salvarPlantao").html('Salvar');
            }else{
                notificationError('Ocorreu um erro ao salvar o registro: ', data);
                $("#salvarPlantao").removeClass( ' disabled ' );
                $("#salvarPlantao").html('Salvar');
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
horafim.focusout(function() {
    if(!isEmpty(horafim.val()))
    $(horafim.selector).removeClass("is-invalid");
});
horainicio.focusout(function() {
    if(!isEmpty(horainicio.val()))
    $(horainicio.selector).removeClass("is-invalid");
});
dataPlantao.focusout(function() {
    if(!isEmpty(dataPlantao.val()))
    $(dataPlantao.selector).removeClass("is-invalid");
});
descsolucao.focusout(function() {
    if(!isEmpty(descsolucao.val()))
    $(descsolucao.selector).removeClass("is-invalid");
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
    return true;
}
