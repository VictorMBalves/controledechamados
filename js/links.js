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

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

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

function isCelular(){
    return ($( window ).width() <= 720);
}
/**
 * Checks if value is empty. Deep-checks arrays and objects
 * Note: isEmpty([]) == true, isEmpty({}) == true, isEmpty([{0:false},"",0]) == true, isEmpty({0:1}) == false
 * @param value
 * @returns {boolean}
 */
function isEmpty(value){
    if(value == '0'){
        return false;
    }
    var isEmptyObject = function(a) {
      if (typeof a.length === 'undefined') { // it's an Object, not an Array
        var hasNonempty = Object.keys(a).some(function nonEmpty(element){
          return !isEmpty(a[element]);
        });
        return hasNonempty ? false : isEmptyObject(Object.keys(a));
      }
  
      return !a.some(function nonEmpty(element) { // check if array is really not empty as JS thinks
        return !isEmpty(element); // at least one element should be non-empty
      });
    };
    return (
      value == false
      || typeof value === 'undefined'
      || value == null
      || (typeof value === 'object' && isEmptyObject(value))
    );
  }

  function notificationWarning(title, message){
    toastr.options = {
        "positionClass": "toast-bottom-right",
    }
    toastr.warning(message, title);
  }

  function notificationSuccess(title, message){
    toastr.options = {
        "positionClass": "toast-bottom-right",
    }
    toastr.success(message, title);
  }

  function notificationError(title, message){
    toastr.options = {
        "positionClass": "toast-bottom-right",
    }
    toastr.error(message, title);
  }

  function notificationInfo(title, message){
    toastr.options = {
        "positionClass": "toast-bottom-right",
    }
    toastr.info(message, title);
  }

  function notificationErrorLogin(message){
      toastr.options = {
        "positionClass": "toast-top-center",
        "preventDuplicates": "true",
      }
      toastr.error(message, "Erro");
  }
  
  function notificationWarningOne(message){
    toastr.options = {
      "positionClass": "toast-bottom-right",
      "preventDuplicates": "true",
    }
    toastr.warning(message, "Alerta");
}

function progressReport(message){
    toastr.options = {
      "positionClass": "toast-bottom-right",
      "preventDuplicates": "true",
      "progressBar": true,
    }
    toastr.info(message, "Gerando relatório:");
}

function notificationSuccessLink(title, message, link){
    toastr.options = {
        "positionClass": "toast-bottom-right",
    }
    toastr.success("<a href='"+link+"' target='_blank'>"+message+"</a>", title);
  }

