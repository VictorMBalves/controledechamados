function home(){
    window.location.assign("home.php");
} 

function novo(){
    window.location.assign("cad_chamado.php");
}
function chamado(){
    window.location.assign("chamados.php");
}
function sair(){
    window.location.assign("logout.php");
}
function redireciona(){
    window.location.assign("cad_chamado.php");
}
function cancelar(){
    window.location.assign("chamados.php");
}
function cancelar2(){
    window.location.assign("empresa.php");
}
function cancelar3(){
    window.location.assign("plantao.php");
}
function cancelar4(){
    window.location.assign("cad_usuario.php");
}
function cadastrar(){
    window.location.assign("cad_empresa.php");
}
function reeturn(){
    window.location.assign("plantao.php");
}

function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
        if((tecla>=46 && tecla<58)) return true;
            else{
                if (tecla==8 || tecla==0) return true;
            else  return false;
}
}
 function validar() {
        var usuario = form1.usuario.value;
        var senha = form1.senha.value;
    
        if (usuario == "") {
        alert("Preencha o campo Usuário!");
        form1.usuario.focus();
        return false;
        }

        if (senha == "") {
        alert("Preencha o campo Senha!");
        form1.senha.focus();
        return false;
        }
    }	
  function atualizarTarefas() {
           var url="notifica.php";
            jQuery("#tarefas").load(url);
        }
        setTimeout("atualizarTarefas()", 100);

    