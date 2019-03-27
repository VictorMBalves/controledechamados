$("#gerarSobreaviso").click(function () {
    progressReport("Gerando relatório de sobreaviso");
})
var cnpjPlantao = "";
components = [
    empresaPlantao = $("#empresaPlantao"),
    contatoPlantao = $("#contatoPlantao"),
    forma_contatoPlantao = $("#formacontato"),
    telefonePlantao = $("#telefonePlantao"),
    versaoPlantao = $("#versaoPlantao"),
    dataPlantaoPlantao = $("#data"),
    horainicioPlantao = $("#horainicio"),
    horafimPlantao = $("#horafim"),
    sistemaPlantao = $("#sistemaPlantao"),
    categoriaPlantao = $("#categoriafilter"),
    descproblemaPlantao = $("#descproblema"),
    descsolucaoPlantao = $("#descsolucao"),
];
errosPlantao = [];

empresaPlantao.flexdatalist({
    minLength: 1,
    visibleProperties: '{cnpj} - {name}',
    valueProperty: 'name',
    textProperty: 'name',
    searchIn: ['name', 'cnpj'],
    url: "../utilsPHP/search.php",
    noResultsText: 'Sem resultados para "{keyword}"',
    searchByWord: true,
    searchContain: true,
}).on('select:flexdatalist', function (ev, result) {
    $("#infoLoad").addClass(' hidden ');
    $("#successLoad").removeClass(' hidden ');
    if(result.is_blocked){
        $("#empresaBloqueada").removeClass(' hidden ');
        empresaPlantao.addClass(' is-invalid ');
    }else{
        $('#empresaBloqueada').addClass('hidden');
        empresaPlantao.removeClass(' is-invalid ');
    }
    sistemaPlantao.val(result.system);
    telefonePlantao.val(result.phone);
    versaoPlantao.val(result.version);
    cnpjPlantao = result.cnpj;
}).on('before:flexdatalist.search', function(ev, key, data){
    $("#infoLoad").removeClass(' hidden ');
});

$("#salvarPlantao").click(function () {
    $("#salvarPlantao").addClass(' disabled ');
    $("#salvarPlantao").html('<img src="../imagem/ajax-loader.gif">');
    validarPlantao(components);
    return null;
})
$("#cancel").click(function () {
    resetForm();
})
function validarPlantao(components) {
    errosPlantao = [];
    for (i = 0; i < components.length; i++) {
        if (isEmpty(components[i].val()))
            errosPlantao.push(components[i].selector);
    }
    if (isEmpty(errosPlantao)) {
        if (!validarHorario()) {
            $("#salvarPlantao").removeClass("disabled");
            $("#salvarPlantao").html("Salvar");
            return;
        }
        enviarDadosPlantao();
    } else {
        $("#salvarPlantao").removeClass("disabled");
        $("#salvarPlantao").html("Salvar");
        for (i = 0; i < errosPlantao.length; i++) {
            if (!$(errosPlantao[i]).hasClass("vazio")) {
                $(errosPlantao[i]).addClass("is-invalid");
            }
        }
        notificationWarningOne("Preencha os campos obrigatórios!");
    }
    return null;
}

function enviarDadosPlantao() {
    $.ajax({
        type: "POST",
        url: "../inserts/insere_plantao2.php",
        data: carregaDados(),
        success: function (data) {
            data = data.trim();
            if (data == "success") {
                notificationSuccess('Registro salvo', 'Chamado registrado com sucesso!');
                resetForm();
                $("#salvarPlantao").removeClass(' disabled ');
                $("#salvarPlantao").html('Salvar');
            } else {
                notificationError('Ocorreu um erro ao salvar o registro: ', data);
                $("#salvarPlantao").removeClass(' disabled ');
                $("#salvarPlantao").html('Salvar');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
}

function carregaDados() {
    var data = [];
    data.push({ name: 'empresa', value: empresaPlantao.val() });
    data.push({ name: 'contato', value: contatoPlantao.val() });
    data.push({ name: 'telefone', value: telefonePlantao.val() });
    data.push({ name: 'versao', value: versaoPlantao.val() });
    data.push({ name: 'formacontato', value: forma_contatoPlantao.val() });
    data.push({ name: 'categoria', value: categoriaPlantao.val() });
    data.push({ name: 'descproblema', value: descproblemaPlantao.val() });
    data.push({ name: 'sistema', value: sistemaPlantao.val() });
    data.push({ name: 'horafim', value: horafimPlantao.val() });
    data.push({ name: 'horainicio', value: horainicioPlantao.val() });
    data.push({ name: 'data', value: dataPlantaoPlantao.val() });
    data.push({ name: 'descsolucao', value: descsolucaoPlantao.val() });
    data.push({name: 'cnpj', value: cnpjPlantao});
    return data;
}

function resetForm() {
    empresaPlantao.val('');
    contatoPlantao.val('');
    telefonePlantao.val('');
    versaoPlantao.val('');
    forma_contatoPlantao.val('');
    $(".chosen-select").val('').trigger("chosen:updated");
    descproblemaPlantao.val('');
    sistemaPlantao.val('');
    dataPlantaoPlantao.val('');
    horafimPlantao.val('');
    horainicioPlantao.val('');
    descsolucaoPlantao.val('');
    $('#infLoad').addClass('hidden');
    $('#erroLoad').addClass('hidden');
    $('#successLoad').addClass('hidden');
    $('#alertLoad').addClass('hidden');
    $('#empresaBloqueada').addClass('hidden');
}
contatoPlantao.focusout(function () {
    if (!isEmpty(contatoPlantao.val()))
        $(contatoPlantao.selector).removeClass("is-invalid");
});
empresaPlantao.focusout(function () {
    if (!isEmpty(empresaPlantao.val()))
        $(empresaPlantao.selector).removeClass("is-invalid");
});
forma_contatoPlantao.focusout(function () {
    if (!isEmpty(forma_contatoPlantao.val()))
        $(forma_contatoPlantao.selector).removeClass("is-invalid");
});
telefonePlantao.focusout(function () {
    if (!isEmpty(telefonePlantao.val()))
        $(telefonePlantao.selector).removeClass("is-invalid");
});
sistemaPlantao.focusout(function () {
    if (!isEmpty(sistemaPlantao.val()))
        $(sistemaPlantao.selector).removeClass("is-invalid");
});
versaoPlantao.focusout(function () {
    if (!isEmpty(versaoPlantao.val()))
        $(versaoPlantao.selector).removeClass("is-invalid");
});
categoriaPlantao.focusout(function () {
    if (!isEmpty(categoriaPlantao.val()))
        $(categoriaPlantao.selector).removeClass("is-invalid");
});
descproblemaPlantao.focusout(function () {
    if (!isEmpty(descproblemaPlantao.val()))
        $(descproblemaPlantao.selector).removeClass("is-invalid");
});
horafimPlantao.focusout(function () {
    if (!isEmpty(horafimPlantao.val()))
        $(horafimPlantao.selector).removeClass("is-invalid");
});
horainicioPlantao.focusout(function () {
    if (!isEmpty(horainicioPlantao.val()))
        $(horainicioPlantao.selector).removeClass("is-invalid");
});
dataPlantaoPlantao.focusout(function () {
    if (!isEmpty(dataPlantaoPlantao.val()))
        $(dataPlantaoPlantao.selector).removeClass("is-invalid");
});
descsolucaoPlantao.focusout(function () {
    if (!isEmpty(descsolucaoPlantao.val()))
        $(descsolucaoPlantao.selector).removeClass("is-invalid");
});

function validarHorario() {
    var startTime = horainicioPlantao.val();
    var endTime = horafimPlantao.val();
    var regExp = /(\d{1,2})\:(\d{1,2})\:(\d{1,2})/;
    if (parseInt(endTime.replace(regExp, "$1$2$3")) < parseInt(startTime.replace(regExp, "$1$2$3"))) {
        notificationWarningOne("Horário de termino deve ser maior que o horário de inicio");
        horafim.focus();
        return false;
    }
    return true;
}

$(()=>{
    $('.chosen-select').chosen({no_results_text: "Categoria não encontrada",allow_single_deselect: true, width:"100%"});
    alterarCategoria()
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
        "url": "../inserts/insere_categoria.php",
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