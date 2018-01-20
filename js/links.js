function home() {
    window.location.assign("home.php");
}

function novo() {
    window.location.assign("cad_chamado.php");
}

function chamado() {
    window.location.assign("chamados.php");
}

function sair() {
    window.location.assign("logout.php");
}

function redireciona() {
    window.location.assign("cad_chamado.php");
}

function cancelar() {
    window.location.assign("chamados.php");
}

function cancelar2() {
    window.location.assign("empresa.php");
}

function cancelar3() {
    window.location.assign("plantao.php");
}

function cancelar4() {
    window.location.assign("cad_usuario.php");
}

function cadastrar() {
    window.location.assign("cad_empresa.php");
}

function reeturn() {
    window.location.assign("plantao.php");
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
    var url = "notifica.php";
    jQuery("#tarefas").load(url);
}
setTimeout("atualizarTarefas()", 100);

$(document).ready(function() {
    $("input[name='empresa']").blur(function() {
        var $telefone = $("input[name='telefone']");
        var $versao = $("input[name='versao']");
        var $backup = $("input[name='backup']");
        var $sistema = $("select[name='sistema']");
        var select = document.getElementById('backup');
        var $celular;
        var $bloqueado = new Boolean(false);

        $telefone.val('Carregando...');

        $.getJSON(
                'callAPI.php', {
                    empresa: $(this).val()
                }
            )
            .done(function(data) {
                $bloqueado = data.is_blocked;
                $telefone.val(data.phone);
                $versao.val(data.version);
                $sistema.val(data.system).change();

                //Verifica o bloqueio do sistema
                $.get('verificabloqueio.php?bloqueio=' + $bloqueado, function(data) {
                    $('#resultado').html(data);
                });

                if ($bloqueado == true) {
                    if (!document.getElementById('salvar').disabled) document.getElementById('salvar').disabled = true;
                } else if ($bloqueado == false) {
                    if (document.getElementById('salvar').disabled) document.getElementById('salvar').disabled = false;
                }


            })
    });
});