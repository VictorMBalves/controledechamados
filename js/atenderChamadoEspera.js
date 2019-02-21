    
    id = $("#id_chamado");
    empresa = $("#empresaCad");
    contato = $("#contato");
    formaContato = $("#forma_contato");
    telefone = $("#telefone");
    sistema = $("#sistema");
    versao = $("#versao");
    backup = $("#backup");
    categoria = $("#categoria");
    descProblema = $("#descricao_proplema");
    erros = [];
$( document ).ready(function() {
    $("#submit").click();
});


$("#submit").click(function(){
    $("#submit").addClass( ' disabled ' );
    $("#submit").html('<img src="../imagem/ajax-loader.gif">');
    enviarDados();
    return null;
})
$("#cancel").click(function(){
    window.location.assign("../pages/home");
}) 
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
                    window.location.assign("../pages/abrechamadoFa="+data.idChamado);
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