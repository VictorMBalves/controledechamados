var components = [
    categoriaCad = $("#categoria"),
    descricaoCad = $("#descricao"),
]
var idCad = $("#categoria_id");


$(document).ready(() => {
    $("#loading").html('<img src="../imagem/loading.gif">');
    loadTable();
    resetForm();
    $("#liChamados").addClass("active")
});

$("#salvar").on('click', () => {
    validarCategoria(components);
    return false;
});

$("#excluir").on("click", () => {
    var dados = carregaDados();
    sendRequest("DELETE", dados, (response)=>{
        if (response.status == "200") {
            notificationSuccess('Sucesso', response.message);
            loadTable();
            resetForm();
        } else if (response.status == "201") {
            notificationWarning('Alerta', response.message);
        } else {
            notificationError('Erro', response.message);
            $("#salvar").removeClass(' disabled ');
            $("#salvar").html('Salvar');
        }
    });
    return false;
})

$("#novo").on("click", () => {
    resetForm();
    return false;
})

function loadTable() {
    sendRequest("GET", null, (response) => {
        if (response) {
            $('#tabela').DataTable().destroy();
            $('#tbody').empty();
            buildTable(response);
        }
    });
}

function validarCategoria(components) {
    errosCategoria = [];
    for (i = 0; i < components.length; i++) {
        if (isEmpty(components[i].val()))
            errosCategoria.push(components[i].selector);
    }
    if (isEmpty(errosCategoria)) {
        enviarDadosCategoria();
    } else {
        $("#salvar").removeClass("disabled");
        $("#salvar").html("salvar");
        for (i = 0; i < errosCategoria.length; i++) {
            if (!$(errosCategoria[i]).hasClass("vazio")) {
                $(errosCategoria[i]).addClass("is-invalid");
            }
        }
        notificationWarningOne("Preencha os campos obrigatórios!");
    }
    return null;
}

categoriaCad.focusout(() => {
    if (!isEmpty(categoriaCad.val()))
        $(categoriaCad.selector).removeClass("is-invalid");
});

descricaoCad.focusout(() => {
    if (!isEmpty(descricaoCad.val()))
        $(descricaoCad.selector).removeClass("is-invalid");
});

function carregaDados() {
    return JSON.stringify({
        "categoria": categoriaCad.val(),
        "descricao": descricaoCad.val(),
        "id": idCad.val()
    });
}

function enviarDadosCategoria() {
    var dados = carregaDados();
    var request_type;
    if (isEmpty(idCad.val())) {
        request_type = "POST";
    } else {
        request_type = "PUT";
    }

    sendRequest(request_type, dados, (response) => {
        if (response.status == "200") {
            notificationSuccess('Sucesso', response.message);
            loadTable();
            resetForm();
        } else if (response.status == "201") {
            notificationWarning('Alerta', response.message);
        } else {
            notificationError('Erro', response.message);
            $("#salvar").removeClass(' disabled ');
            $("#salvar").html('Salvar');
        }
    })
}


function resetForm() {
    categoriaCad.val('');
    descricaoCad.val('');
    idCad.val('');
    $("#excluir").addClass(' disabled ');
    $("#salvar").removeClass(' disabled ');
    $("#salvar").html('Salvar');
}

function loadForm(data) {
    idCad.val(data.id);
    categoriaCad.val(data.categoria);
    descricaoCad.val(data.descricao);
    if (!isEmpty(idCad.val())) {
        $("#excluir").removeClass("disabled");
    }
}


function sendRequest(request_method, dados, callback) {
    var settings = {
        "async": false,
        "crossDomain": true,
        "url": "../controllers/controllerCategoria.php",
        "method": request_method,
        "headers": {
            "Content-Type": "application/json",
            "cache-control": "no-cache",
        },
        "processData": false,
        "data": dados,
        error: function (jqXHR, textStatus, errorThrown) {
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    }
    $.ajax(settings).done((response) => {
        callback(JSON.parse(response));
    });
}

function buildTable(data) {
    var dados = data;
    var len = dados.length;
    var txt = "";
    if (len > 0) {
        for (var i = 0; i < len; i++) {
            txt += "<tr id=" + i + " onclick='loadForm(" + JSON.stringify(dados[i]) + ")'>";
            txt += '<td>' + dados[i].id + '</td>';
            txt += '<td>' + dados[i].categoria + '</td>';
            txt += '<td>' + dados[i].descricao + '</td>';
            txt += "</tr>";
        }

        if (txt != "") {
            $("#loading").html('');
            $("#tabela").append(txt);
            $('#tabela').DataTable({
                pageLength: 10,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
                },
                "initComplete": function(settings, json) {
                    $('[data-toggle="tooltip"]').tooltip()
                  },
                  "order": [[ 0, "desc" ]] 
            }).columns.adjust().draw();
        }
    } else {
        $('#loading').html('<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Nenhuma categoria cadastrada!</div>');
    }
}