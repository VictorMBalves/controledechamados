<?php
	include '../validacoes/verificaSessionFinan.php';
	require_once '../include/Database.class.php';
    $db = Database::conexao();
	$sql = $db->prepare('SELECT nome, nivel, disponivel FROM usuarios WHERE nivel in(3,2)');
	$sql->execute();
	$result = $sql->fetchall(PDO::FETCH_ASSOC);
?>
<link href="../assets/css/component-chosen.min.css" rel="stylesheet" />
<link href="../assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

<div class="modal" tabindex="-1" role="dialog" id="modalCadEspera">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chamado em espera</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="empresaEspera">Empresa solicitante:</label>
                        <input name="empresaEspera" type="text" id="empresaEspera" class="form-control flexdatalist">
                        <div id="empresaBloqueada" class="text-danger hidden"><small>Empresa bloqueada</small></div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="enderecado">Atribuir para:</label>
                                <select id="enderecado" name="enderecado" type="text" class="form-control chosen-select"
                                    data-placeholder="Selecione um usuário...">
                                    <option value=""></option>
                                    <?php 
                                foreach ($result as $row) {
                                    echo '<option>'.$row['nome'].'</option>';
                                }
                            ?>
                                </select>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="dataAgendamento">Agendar </label>
                                <input type="text" name="dataAgendamento" id="dataAgendamento"
                                    class="form-control mb-2 mr-sm-2">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="contatoEspera">Contato:</label>
                                <input name="contatoEspera" id="contatoEspera" type="text" class="form-control">
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="telefoneEspera">Telefone:</label>
                                <input name="telefoneEspera" type="text" id="telefoneEspera" class="form-control"
                                    onkeypress="return SomenteNumero(event)">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="versaoEspera">Versão</label>
                                <input id="versaoEspera" name="versaoEspera" type="text" class="form-control">
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="sistemaEspera">Sistema:</label>
                                <input id="sistemaEspera" name="sistemaEspera" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="descproblema">Descrição do problema:</label>
                            <textarea name="descproblema" id="desc_problema" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <?php include "../utilsPHP/statusDados.php";?>
                            </div>
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-center">
                    <button id="cadastrarEspera" name="cadastrarEspera"
                        class="btn btn-group-lg btn-success">Salvar</button>
                    <button class="btn btn-group-lg btn-info" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/chosen.jquery.min.js"></script>
<script src="../assets/js/bootstrap-datetimepicker.min.js"></script>

<script>
$('.chosen-select').chosen({
    no_results_text: "Nenhum registro encontrado",
    allow_single_deselect: true
});

$(function() {
    $('#dataAgendamento').datetimepicker({
        icons: {
            time: 'fas fa-clock'
        },
        format: 'DD/MM/YYYY HH:mm'
    });
});

var cnpjEspera = "";
empresaEspera = $("#empresaEspera");
enderecadoEspera = $("#enderecado");
contatoEspera = $("#contatoEspera");
telefoneEspera = $("#telefoneEspera");
versaoEspera = $("#versaoEspera");
sistemaEspera = $("#sistemaEspera");
descProblemaEspera = $("#desc_problema");
dataagendamento = $("#dataAgendamento");
errosEspera = [];

empresaEspera.flexdatalist({
    minLength: 1,
    visibleProperties: '{cnpj} - {name}',
    valueProperty: 'name',
    textProperty: 'name',
    searchIn: ['name', 'cnpj'],
    url: "../utilsPHP/search.php",
    noResultsText: 'Sem resultados para "{keyword}"',
    searchByWord: true,
    searchContain: true,
}).on('select:flexdatalist', function(ev, result) {
    $("#infoLoad").addClass(' hidden ');
    $("#successLoad").removeClass(' hidden ');
    if (result.is_blocked) {
        $("#empresaBloqueada").removeClass(' hidden ');
        empresaEspera.addClass(' is-invalid ');
    } else {
        $('#empresaBloqueada').addClass('hidden');
        empresaEspera.removeClass(' is-invalid ');
    }
    sistemaEspera.val(result.system);
    telefoneEspera.val(result.phone);
    versaoEspera.val(result.version);
    cnpjEspera = result.cnpj;
}).on('before:flexdatalist.search', function(ev, key, data) {
    $("#infoLoad").removeClass(' hidden ');
});


$("#cadastrarEspera").click(function() {
    $("#cadastrarEspera").addClass(' disabled ');
    $("#cadastrarEspera").html('<img src="../imagem/ajax-loader.gif">');
    validar();
    return null;
});

function validar() {
    errosEspera = [];
    if (isEmpty(empresaEspera.val()))
        errosEspera.push(empresaEspera.selector);
    if (isEmpty(contatoEspera.val()))
        errosEspera.push(contatoEspera.selector);
    if (isEmpty(telefoneEspera.val()))
        errosEspera.push(telefoneEspera.selector);
    if (isEmpty(versaoEspera.val()))
        errosEspera.push(versaoEspera.selector);
    if (isEmpty(sistemaEspera.val()))
        errosEspera.push(sistemaEspera.selector);
    if (isEmpty(descProblemaEspera.val()))
        errosEspera.push(descProblemaEspera.selector);

    if (isEmpty(errosEspera)) {
        enviarDadosCadastroChamadoEspera();
    } else {
        $("#cadastrarEspera").removeClass("disabled");
        $("#cadastrarEspera").html("Salvar");
        for (i = 0; i < errosEspera.length; i++) {
            if (!$(errosEspera[i]).hasClass("vazio")) {
                $(errosEspera[i]).addClass("is-invalid");
            }
        }
        notificationWarningOne("Preencha os campos obrigatórios!");
    }
    return null;
}

function enviarDadosCadastroChamadoEspera() {
    $.ajax({
        type: "POST",
        url: "../inserts/inserechamadoespera.php",
        data: carregaDados(),
        success: function(data) {
            console.log(data)
            data = data.trim();
            if (data == "success") {
                notificationSuccessLink('Registro salvo', 'Chamado registrado com sucesso!', '../pages/chamados');
                $("#modalCadEspera").modal('hide');
            } else {
                notificationError('Ocorreu um erro ao salvar o registro: ', data);
                $("#cadastrarEspera").removeClass(' disabled ');
                $("#cadastrarEspera").html('Salvar');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('error: ' + textStatus + ': ' + errorThrown);
        }
    });
}

function resetForm() {
    empresaEspera.val('');
    contatoEspera.val('');
    telefoneEspera.val('');
    versaoEspera.val('');
    descProblemaEspera.val('');
    sistemaEspera.val('');
    $('#infLoad').addClass('hidden');
    $('#erroLoad').addClass('hidden');
    $('#successLoad').addClass('hidden');
    $('#alertLoad').addClass('hidden');
    $('#resultado').html('<div class="alert alert-info text-center" role="alert">Novo chamado em espera:</div>');
}

empresaEspera.focusout(function() {
    if (!isEmpty(empresaEspera.val()))
        $(empresaEspera.selector).removeClass("is-invalid");
});
enderecadoEspera.focusout(function() {
    if (!isEmpty(enderecadoEspera.val()))
        $(enderecadoEspera.selector).removeClass("is-invalid");
});
contatoEspera.focusout(function() {
    if (!isEmpty(contatoEspera.val()))
        $(contatoEspera.selector).removeClass("is-invalid");
});
telefoneEspera.focusout(function() {
    if (!isEmpty(telefoneEspera.val()))
        $(telefoneEspera.selector).removeClass("is-invalid");
});
versaoEspera.focusout(function() {
    if (!isEmpty(versaoEspera.val()))
        $(versaoEspera.selector).removeClass("is-invalid");
});
sistemaEspera.focusout(function() {
    if (!isEmpty(sistemaEspera.val()))
        $(sistemaEspera.selector).removeClass("is-invalid");
});
descProblemaEspera.focusout(function() {
    if (!isEmpty(descProblemaEspera.val()))
        $(descProblemaEspera.selector).removeClass("is-invalid");
});

function carregaDados() {
    var data = [];
    data.push({ name: 'empresa', value: empresaEspera.val() });
    data.push({ name: 'enderecado', value: enderecadoEspera.val() });
    data.push({ name: 'contato', value: contatoEspera.val() });
    data.push({ name: 'telefone', value: telefoneEspera.val() });
    data.push({ name: 'versao', value: versaoEspera.val() });
    data.push({ name: 'sistema', value: sistemaEspera.val() });
    data.push({ name: 'descproblema', value: descProblemaEspera.val() });
    data.push({name: 'cnpj', value: cnpjEspera});
    if(moment(dataagendamento.val(), "DD/MM/YYYY HH:mm").isValid())
        data.push({name: 'dataagendamento', value: moment(dataagendamento.val(), "DD/MM/YYYY HH:mm").format("YYYY-MM-DD HH:mm")});
    else data.push({name: 'dataagendamento', value: null});

    return data;
}

function erro() {
    alert('Acesso negado! Redirecinando a pagina principal.');
    window.location.assign("home");
}
</script>