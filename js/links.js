$(document).ready(function() {
  consultaChamadosEspera();
  loadResponsavelSemana();
  refresh_usuarios();
  $.Shortcuts.start();
  verificaPreferenciaSideBar()
}); 

function verificaPreferenciaSideBar(){
  if($.cookie('sidebarToggled')){
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    };
  }
}

$.Shortcuts.add({
    type: 'down',
    mask: 'Alt+q',
    handler: function() {
      window.open(
        '../pages/chamadoespera',
        '_blank' 
        );
    }
});

$.Shortcuts.add({
  type: 'down',
  mask: 'Alt+w',
  handler: function() {
     if(!($("#modalCad").data('bs.modal') || {}).isShown)
          openModal();
  }
});

$("#adcChamado").click(function(){
    openModal()
});

function openModal(){
    $("#modalCadastro").load("../modals/modalCadChamado.php", function(){
      $("#modalCad").modal('show');
    });
}

function SomenteNumero(e) {
    var tecla = (window.event) ? event.keyCode : e.which;
    if ((tecla >= 46 && tecla < 58)) return true;
    else {
        if (tecla == 8 || tecla == 0) return true;
        else return false;
    }
}

$(function () {$('[data-toggle="tooltip"]').tooltip()})

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

  setInterval(function(){
    consultaChamadosEspera();
  }, 50000);

  function consultaChamadosEspera(){
    if(window.location.pathname === '/chamados/' || window.location.pathname === '/')
        return;

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
      var notification = dataTable[i].notification == 1 ? true : false;

      if(!notification)
        continue;

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
      // notificacao.onclick = function () {
      //     url = "../pages/abrechamadoespera="+chamado.id_chamadoespera;
      //     window.open(url,
      //     '_blank' );      
      // };
}

$("#registroAtividadeEcf").click(function () {
  $.get("../modals/modalRegistroAtividades.php", function (data) {
    $("body").append(data);
  }).done(function () {
    $("#dtInicial").removeClass(' is-invalid ')
    $("#dtFinal").removeClass(' is-invalid ')
    $("#modalRegistroAtividadeEcf").modal('show');
  });
})

function loadResponsavelSemana(){
  $.ajax({
      type: "POST",
      url: "../utilsPHP/responsavelsemana.php",
      success:function(data){
          $("#plantao").html(data);
      }
  });
}

$("#sidebarToggle, #sidebarToggleTop").click(function(){
    refresh_usuarios();
    if($("#accordionSidebar").hasClass('toggled'))
      $.cookie('sidebarToggled', 'true', { expires: 1000, path: '/' });
    else{
      $.removeCookie('sidebarToggled', { path: '/' });
    }
})

function refresh_usuarios() {
  var url="../utilsPHP/atendentedispo.php";
  jQuery("#usuarios").load(url, function(){
    if($("#accordionSidebar").hasClass("toggled")){
      toogleUsers()
    }
  });
}

setInterval(function(){
  refresh_usuarios();
}, 5000);

function toogleUsers(){
  $(".userName").toggleClass("col-sm-12 col-md-12 col-lg-12 text-center ")
  $(".userImage").toggleClass("col-sm-12 col-md-12 col-lg-12")
}