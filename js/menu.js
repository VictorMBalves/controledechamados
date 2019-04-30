
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
			        window.location.href='pages/home';
                }else if (data == 'successNivel1'){
                    window.location.href='pages/chamadoesperahome';
                }else if (data == 'successNivel3'){
                    window.location.href='pages/dashBoard';
                }else if (data == 'fail'){
                    notificationErrorLogin("Acesso negado");
                    $("#entrar").html("Entrar");
                }else{
                    window.location.href=data;
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('error: ' + textStatus + ': ' + errorThrown);
            }
        });
    }
}

function notificationErrorLogin(message){
    toastr.options = {
      "positionClass": "toast-top-center",
      "preventDuplicates": "true",
    }
    toastr.error(message, "Erro");
}