var clipboard = new ClipboardJS('#btnClipPesquisa');

clipboard.on('success', function (e) {
    $("#finalizar").removeAttr("disabled");
    e.clearSelection();
    $("#btnClipPesquisa").html('<i id="iconCopy" class="fas fa-check"></i>');
});

$("#showUltimos").on("click", function () {
    $("#divLateral").toggleClass("collapsedRight");
    $("#contentForm").toggleClass("col-md-8 col-md-12");

})

$(".spin-icon").on("click", function () {
    $(".theme-config-box ").toggleClass('show')
})

cnjp = $("#cnpj");
components = [
    id = $("#id_chamado"),
    empresa = $("#empresafin"),
    contato = $("#contatofin"),
    forma_contato = $("#formaContatofin"),
    versao = $("#versaofin"),
    telefone = $("#telefonefin"),
    sistema = $("#sistemafin"),
    categoria = $("#categoriafilter"),
    descproblema = $("#descproblemafin"),
    descsolucao = $("#descsolucaofin"),
]
erros = [];

$("#finalizar").click(function () {
    finalizar();
    return null;
})
function finalizar() {
    $("#finalizar").addClass(' disabled ');
    $("#finalizar").html('<img src="../imagem/ajax-loader.gif">');
    validar(components);
}

$("#cancel").click(function () {
    window.location.assign("../pages/home");
})


function validar(components) {
    erros = [];
    for (i = 0; i < components.length; i++) {
        if (isEmpty(components[i].val()))
            erros.push(components[i].selector);
    }
    if (isEmpty(erros)) {
        enviarDados();
    } else {
        $("#finalizar").removeClass("disabled");
        $("#finalizar").html("Finalizar");
        for (i = 0; i < erros.length; i++) {
            if (!$(erros[i]).hasClass("vazio")) {
                $(erros[i]).addClass("is-invalid");
            }
        }
        notificationWarningOne("Preencha os campos obrigatórios!");
    }
    return null;
}

function enviarDados() {
    $.ajax({
        type: "POST",
        url: "../utilsPHP/altera_chamado.php",
        data: carregaDados(),
        success: function (data) {
            data = data.trim();
            if (data == "success") {
                notificationSuccess('Registro salvo', 'Chamado finalizado com sucesso!');
                setTimeout(function () {
                    window.location.assign("../pages/home");
                }, 1000);
            } else {
                notificationError('Ocorreu um erro ao salvar o registro: ', data);
                $("#finalizar").removeClass(' disabled ');
                $("#finalizar").html('Salvar');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
}

function carregaDados() {
    var data = [];
    data.push({ name: 'id_chamado', value: id.val() });
    data.push({ name: 'empresa', value: empresa.val() });
    data.push({ name: 'contato', value: contato.val() });
    data.push({ name: 'telefone', value: telefone.val() });
    data.push({ name: 'versao', value: versao.val() });
    data.push({ name: 'formacontato', value: forma_contato.val() });
    data.push({ name: 'categoria', value: categoria.val() });
    data.push({ name: 'descproblema', value: descproblema.val() });
    data.push({ name: 'descsolucao', value: descsolucao.val() });
    data.push({ name: 'sistema', value: sistema.val() });
    return data;
}

contato.focusout(function () {
    if (!isEmpty(contato.val()))
        $(contato.selector).removeClass("is-invalid");
});
forma_contato.focusout(function () {
    if (!isEmpty(forma_contato.val()))
        $(forma_contato.selector).removeClass("is-invalid");
});
telefone.focusout(function () {
    if (!isEmpty(telefone.val()))
        $(telefone.selector).removeClass("is-invalid");
});
sistema.focusout(function () {
    if (!isEmpty(sistema.val()))
        $(sistema.selector).removeClass("is-invalid");
});
versao.focusout(function () {
    if (!isEmpty(versao.val()))
        $(versao.selector).removeClass("is-invalid");
});
categoria.focusout(() => {
    if (!isEmpty(categoria.val()))
        $(categoria.selector).removeClass("is-invalid");
});
descproblema.focusout(() => {
    if (!isEmpty(descproblema.val()))
        $(descproblema.selector).removeClass("is-invalid");
});
descsolucao.focusout(() => {
    if (!isEmpty(descsolucao.val()))
        $(descsolucao.selector).removeClass("is-invalid");
});

$("#criarRequest").on("click", () => {
    linkRequest = "http://request.gtech.site/requests/new?request[description]=" + descproblema.val() + "&request[requester_cnpj]=" + cnjp.val() + "&request[requester_name]=" + cnjp.val() + " - " + empresa.val();
    window.open(
        linkRequest,
        '_blank'
    );
    if ($("#categoriafin").val() == "Sugestão de melhoria" && $("#iconCopy").hasClass(' fa-check ')) {
        finalizar();
    } else if (!$("#iconCopy").hasClass(' fa-check ')) {
        notificationWarningOne("Copie o link da pesquisa!")
    }
    return false;
});

$("#agendar").on("click", () => {
    $('#modalAgenda').modal('show');
    return false;
})

$("#salvarAgendamento").on("click", function () {
    data = $("#dataAgenda");
    horario = $("#horarioAgenda");
    id = $("#id");
    i = 0;
    if (data.val() === "") {
        data.addClass("is-invalid");
        i++;
    }
    if (horario.val() === "") {
        horario.addClass("is-invalid");
        i++;
    }
    if (i != 0) {
        notificationWarningOne("Preencha os campos obrigatórios!");
        return;
    }
    $(this).html('<img src="../imagem/ajax-loader.gif">');
    $(this).addClass(" disabled ");

    $.ajax({
        type: "POST",
        url: "../inserts/finaliza_chamado_insere_espera.php",
        data: { id: id.val(), dataagendamento: data.val() + " " + horario.val(), problema: $("#descproblemaAgenda").val() },
        success: function (data) {
            data = data.trim();
            if (data == "success") {
                $("#salvarAgendamento").html("Salvar");
                notificationSuccess('Registro salvo', 'Agendamento salvo com sucesso!');
                setTimeout(function () {
                    $("#modalAgenda").modal('hide');
                }, 1000);
                window.location.assign("../pages/home");
            } else {
                $("#salvarAgendamento").html("Salvar");
                $("#salvarAgendamento").removeClass(" disabled ");
                notificationError('Ocorreu um erro ao salvar o registro: ', data);
            }
        }
    });

    return false;
})

function abrirVisualizacao(id) {
    $("#modalConsulta").load("../modals/modalConsultaChamado.php?id_chamado=" + id, function () {
        $("#modalCon").modal('show');
    });
}

$("#categoriafin").on('change', () => {
    alterarCategoria()
})

$(() => {
    $('.chosen-select').chosen({ no_results_text: "Categoria não encontrada", allow_single_deselect: true });
    alterarCategoria();
})

function alterarCategoria() {
    sendRequestCategoria((response) => {
        for (i = 0; i < response.length; i++) {
            dado = response[i];
            icon = '<i class="fas fa-cubes"></i>';
            if(dado.categoria == "ERROS"){
                icon = '<i class="fas fa-bug"></i>';
            }else if(dado.categoria == "DÚVIDAS"){
                icon = '<i class="fas fa-question"></i>';
            }
            $(".chosen-select").append($('<option>', {
                html : icon+" ["+dado.categoria+"] "+dado.descricao,
                value: dado.id,
                // text : ''
            }));
        }
        $('.chosen-select').trigger("chosen:updated");
    })

}
function sendRequestCategoria(callback) {
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "../controllers/controllerCategoria.php",
        "method": "GET",
        "headers": {
            "Content-Type": "application/json",
            "cache-control": "no-cache",
            "Postman-Token": "1fbbd708-31dc-4395-8462-c333ae164ec5"
        },
        "processData": false,
        "data": ""
    }
    $.ajax(settings).done(function (response) {
        callback(JSON.parse(response));
    });
}

$(()=>{
    body = "<div class='form-group'>"+
                "<select data-placeholder=' ' width='100' id='usuarioAlterecao' type='text' class='form-control chosen-select-usuario'><option value=''></option></select>"+
            "</div>"+
            "<div class='form-group text-center'>"+
            "<button id='alterarUsuario' onclick='alterarUsuario()' class='btn btn-success'>Alterar</button>"
            "</div>"


    var options = {
        title: "<div class='text-center' style='width:250px;'>Alterar usuário</div>",
        placement: "top",
        html: true,
        content: body,
        trigger: 'click'
    }
    $("#alterarAtendente").popover(options);
})

$("#alterarAtendente").on("click", ()=>{
    updateUsuariosList()
    return false;
})

function updateUsuariosList(){
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "../utilsPHP/searchusers.php",
        "method": "GET",
        "headers": {
            "Content-Type": "application/json",
            "cache-control": "no-cache",
            "Postman-Token": "1fbbd708-31dc-4395-8462-c333ae164ec5"
        },
        "processData": false,
        "data": ""
    }
    $.ajax(settings).done(function (response) {
        $('.chosen-select-usuario').chosen({ no_results_text: "Usuário não encontrada"});
        $('#usuarioAlterecao_chosen').css( "width", "+=200" );
        var usuarios = JSON.parse(response);
        $.each( usuarios, function( key, usuario ) {
            $(".chosen-select-usuario").append($('<option>', {
                html : usuario.nome,
                value: usuario.id
            }));
        });
        $('.chosen-select-usuario').trigger("chosen:updated");
    });
}

 function alterarUsuario(){
     if(isEmpty($('.chosen-select-usuario').val())){
         notificationWarning('Alerta', "Informe o usuário para continuar");
         return;
     }
    $("#alterarUsuario").html('<img src="../imagem/ajax-loader.gif">')
    var data = JSON.stringify({
        "usuario_id": $('.chosen-select-usuario').val(),
        "usuario": $('.chosen-select-usuario').text
    })
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "../controllers/controllerChamado.php?id="+id.val(),
        "method": "PUT",
        "headers": {
            "Content-Type": "application/json",
            "cache-control": "no-cache",
        },
        "processData": false,
        "data": data,
    }
    $.ajax(settings).done(function (response) {
        response = JSON.parse(response);
        if (response.status == "200") {
            notificationSuccess('Sucesso', response.message);
            location.reload();
        } else if (response.status == "201") {
            notificationWarning('Alerta', response.message);
        } else {
            notificationError('Erro', response.message);
        }
        $("#alterarUsuario").html('Alterar')
    });
}