var clipboard = new ClipboardJS('#btnClipPesquisa');

clipboard.on('success', function (e) {
    $("#finalizar").removeAttr("disabled");
    e.clearSelection();
    $("#btnClipPesquisa").html('<i id="iconCopy" class="fas fa-check"></i>');
});

$("#showUltimos").on("click", function(){
    $("#divLateral").toggleClass("collapsedRight");
    $("#contentForm").toggleClass("col-md-8 col-md-12");

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
    backup = $("#backupfin"),
    categoria = $("#categoriafin"),
    descproblema = $("#descproblemafin"),
    descsolucao = $("#descsolucaofin"),
]
erros = [];

$("#finalizar").click(function () {
    finalizar();
    return null;
})
function finalizar(){
    $(this).addClass(' disabled ');
    $(this).html('<img src="../imagem/ajax-loader.gif">');
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
    data.push({ name: 'backup', value: backup.val() });
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
backup.focusout(function () {
    if (!isEmpty(backup.val()))
        $(backup.selector).removeClass("is-invalid");
});
categoria.focusout(function () {
    if (!isEmpty(categoria.val()))
        $(categoria.selector).removeClass("is-invalid");
});
descproblema.focusout(function () {
    if (!isEmpty(descproblema.val()))
        $(descproblema.selector).removeClass("is-invalid");
});
descsolucao.focusout(function () {
    if (!isEmpty(descsolucao.val()))
        $(descsolucao.selector).removeClass("is-invalid");
});

$("#categoriafin").on("change", function(){
    value = this.value.trim() ;
    if(value == "Erro" || value == "Sugestão de melhoria"){
        $("#criarRequest").removeAttr(" disabled ")
    }else{
        $("#criarRequest").attr( "disabled", "disabled" );
    }
    return false;
})

$("#criarRequest").on("click", function(){
    linkRequest = "http://request.gtech.site/requests/new?request[description]="+descproblema.val()+"&request[requester_cnpj]="+cnjp.val()+"&request[requester_name]="+cnjp.val()+" - "+empresa.val();
    window.open(
        linkRequest,
        '_blank' 
        );
    if($("#categoriafin").val() == "Sugestão de melhoria" && $("#iconCopy").hasClass(' fa-check ')){
        finalizar();
    }else if(!$("#iconCopy").hasClass(' fa-check ')){
        notificationWarningOne("Copie o link da pesquisa!")
    }
    return false;
});

$("#agendar").on("click", function () {
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
        data: { id: id.val(), dataagendamento: data.val() + " " + horario.val(), problema:  $("#descproblemaAgenda").val() },
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

$("#showAtendente").click(function(){
    $("#sidebar").toggleClass("collapsed");
    $("#content").toggleClass("col-md-9 col-md-12");
})

function abrirVisualizacao(id){
    $("#modalConsulta").load("../modals/modalConsultaChamado.php?id_chamado="+id, function(){
        $("#modalCon").modal('show');
    });
}