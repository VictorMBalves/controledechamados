function SomenteNumero(e) {
    var tecla = (window.event) ? event.keyCode : e.which;
    if ((tecla >= 46 && tecla < 58)) return true;
    else {
        if (tecla == 8 || tecla == 0) return true;
        else return false;
    }
}

$(function () {$('[data-toggle="tooltip"]').tooltip()})

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

  function notificationErrorOne(title, message){
    toastr.options = {
        "positionClass": "toast-bottom-right",
        "preventDuplicates": "true",
    }
    toastr.error(message, title);
  }

  $(document).ready(function() {
    consultaChamadosEspera();
  }); 

  setInterval(function(){
    consultaChamadosEspera();
  }, 50000);

  function consultaChamadosEspera(){
    $.ajax({
        type: 'POST',
        url: '../consultaTabelas/tabelahome.php',
        dataType:"json",
        success: function(data){ 
            if(data){
              find_notification(data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
}


function find_notification(dataTable){
  for(var i = 0; i < dataTable.length; i++){
      var dataAtual10 = new Date().add({minutes: -10});
      var dataChamado = new Date(dataTable[i].databanco);
      
      if(dataChamado.between(dataAtual10, new Date()))
          continue;

      if (Notification.permission !== "granted")
          Notification.requestPermission();
      else {  
          notificaUsuario(dataTable[i]);
      }
  }
}

function notificaUsuario(chamado){
  var notificacao =  new Notification("Chamado em espera!", {
      icon: '../imagem/favicon-3.png',
      body: "Há um chamado para empresa "+chamado.empresa+" em espera com mais de 10 minutos sem resposta",
      });

      notificacao.onclick = function () {
          url = "../pages/abrechamadoespera="+chamado.id_chamadoespera;
          window.open(url,
          '_blank' );      
      };
  }