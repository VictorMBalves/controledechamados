id = $("#id_chamado");
descSolucao = $("#descsolucao");
erros = [];

$("#submit").click(function(){
    $("#submit").addClass( ' disabled ' );
    $("#submit").html('<img src="../imagem/ajax-loader.gif">');
    validar();
    return null;
})
$("#cancel").click(function(){
    window.location.assign("../pages/chamados.php");
})

function validar(){ 
    erros = [];
    if(isEmpty(descSolucao.val()))
        erros.push(descSolucao.selector);
            
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
                    window.location.assign("../pages/chamados.php");
                }, 1000);
            }else{
                notificationError('Ocorreu um erro ao salvar o registro: ', data);
                $("#submit").removeClass( ' disabled ' );
                $("#submit").html('Finalizar');
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
    data.push({name: 'descsolucao', value: descSolucao.val()});
    return data;
}

descSolucao.focusout(function() {
    if(!isEmpty(descSolucao.val()))
    $(descSolucao.selector+"-div").removeClass("has-error");
});


