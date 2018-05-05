
$("#entrar").bind("click", function(){
    validaLogin();
});

$(document).keypress(function(e){
    if (e.which == 13){
        $("#entrar").click();
        return false;
    }
});

function validaLogin(){
    login = $("#login").val();
    senha = $("#senha").val();
    i = 0;

    if(login == null || login == ""){
        $("#divLogin").addClass(" has-error ");
        $("#pLogin").removeClass(" hidden ");
        i++;
    }
    if(senha == null || senha == ""){
        $("#divSenha").addClass(" has-error ");
        $("#pSenha").removeClass(" hidden ");
        i++;
    }

    if(i <= 0){
        $("#divLogin").removeClass(" has-error ");
        $("#pLogin").addClass(" hidden ");
        $("#divSenha").removeClass(" has-error ");
        $("#pSenha").addClass(" hidden ");
        $("#entrar").html('<img src="imagem/ajax-loader.gif">');
        enviaDados();
    }

    function enviaDados(){
        usuario = $("#login").val();
        senha = $("#senha").val();
        $.ajax({
            type: "POST",
            url: "validacoes/validalogin.php",
            data: { 
                usuario: usuario, 
                senha: senha, 
            },	
            success: function(data){
                data = data.trim();
		        if(data == 'success'){
			        window.location.href='pages/home.php';
                }else if (data == 'successNivel1'){
                    window.location.href='pages/chamadoespera.php';
                }else{
                    $("#entrar").html("Entrar");
                    $("#errorMsg").html('<div class="alert alert-danger text-center" role="alert">Acesso negado<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('error: ' + textStatus + ': ' + errorThrown);
            }
        });
    }
}