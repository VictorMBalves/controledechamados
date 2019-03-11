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
    backupPlantao = $("#backup"),
    categoriaPlantao = $("#categoria"),
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
    data.push({ name: 'backup', value: backupPlantao.val() });
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
    categoriaPlantao.val('');
    descproblemaPlantao.val('');
    backupPlantao.val('');
    sistemaPlantao.val('');
    dataPlantaoPlantao.val('');
    horafimPlantao.val('');
    horainicioPlantao.val('');
    descsolucaoPlantao.val('');
    $('#infLoad').addClass('hidden');
    $('#erroLoad').addClass('hidden');
    $('#successLoad').addClass('hidden');
    $('#alertLoad').addClass('hidden');
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
backupPlantao.focusout(function () {
    if (!isEmpty(backupPlantao.val()))
        $(backupPlantao.selector).removeClass("is-invalid");
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
