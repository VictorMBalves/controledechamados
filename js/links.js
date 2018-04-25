function home() {
    window.location.assign("../pages/home.php");
}

function novo() {
    window.location.assign("../pages/cad_chamado.php");
}

function chamado() {
    window.location.assign("../pages/chamados.php");
}

function sair() {
    window.location.assign("../utilsPHP/logout.php");
}

function redireciona() {
    window.location.assign("../pages/cad_chamado.php");
}

function cancelar() {
    window.location.assign("../pages/chamados.php");
}

function cancelar2() {
    window.location.assign("../pages/empresa.php");
}

function cancelar3() {
    window.location.assign("../pages/plantao.php");
}

function cancelar4() {
    window.location.assign("../pages/cad_usuario.php");
}

function cadastrar() {
    window.location.assign("../pages/cad_empresa.php");
}

function reeturn() {
    window.location.assign("../pages/plantao.php");
}

function SomenteNumero(e) {
    var tecla = (window.event) ? event.keyCode : e.which;
    if ((tecla >= 46 && tecla < 58)) return true;
    else {
        if (tecla == 8 || tecla == 0) return true;
        else return false;
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
    var url = "../utilsPHP/notifica.php";
    jQuery("#tarefas").load(url);
}
setTimeout("atualizarTarefas()", 100);