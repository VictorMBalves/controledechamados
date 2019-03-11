<div class="modal" tabindex="-1" role="dialog" id="modalCad">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cadastro Chamado</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form  action="#" method="POST">
                    <div class="form-group">
                        <label for="empresa">Empresa solicitante:</label>
                        <input name="empresa" type="text" id="empresa" class="form-control flexdatalist">
                        <div id="empresaBloqueada" class="text-danger hidden"><small>Empresa bloqueada</small></div>
                    </div>
                    <div class="form-group">
                        <label for="contato">Contato:</label>
                        <input id="contato" name="contato" type="text" class="form-control" required/>
                    </div>
        
                    <div class="form-group">
                        <label for="cep">Telefone:</label>
                        <input name="telefone" id="telefone" type="text" class="form-control" onkeypress="return SomenteNumero(event)">
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="versao">Versão:</label>
                            <input id="versao" name="versao" type="text" class="form-control disabled" disabled>
                        </div>
                        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="sistema">Sistema:</label>
                            <input id="sistema" name="sistema" type="text" class="form-control disabled" disabled>
                        </div>
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
                    <button id="cadastrar" name="cadastrar" class="btn btn-group-lg btn-success">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var cnpj = "";
    $('#empresa').flexdatalist({
        minLength: 1,
        visibleProperties: '{cnpj} - {name}',
        valueProperty: '*',
        textProperty: 'name',
        searchIn: ['name', 'cnpj'],
        url: "../utilsPHP/search.php",
        noResultsText: 'Sem resultados para "{keyword}"',
        searchByWord: true,
        searchContain: true,
    }).on('select:flexdatalist', function(ev, result){
        $("#infoLoad").addClass(' hidden ');
        $("#successLoad").removeClass(' hidden ');
        if(result.is_blocked){
            $("#empresaBloqueada").removeClass(' hidden ');
            $("#empresa").addClass(' is-invalid ');
        }
        $("#sistema").val(result.system);
        $("#telefone").val(result.phone);
        $("#versao").val(result.version);
        cnpj = result.cnpj;
    }).on('before:flexdatalist.search', function(ev, key, data){
        $("#infoLoad").removeClass(' hidden ');
    });



    $("#cadastrar").click(function(){
        versao = $("#versao");
        sistema = $("#sistema");
        components = [
            empresa = $("#empresa"),
            contato = $("#contato"),
            telefone = $("#telefone"),
        ];
		$("#cadastrar").addClass( ' disabled ' );
        $("#cadastrar").html('<img src="../imagem/ajax-loader.gif">');
        validarCadastroChamado(components);
        return null;
    });
    
    function validarCadastroChamado(components){
        erros = [];
        for(i = 0; i < components.length; i++){
            if(isEmpty(components[i].val()))
                erros.push(components[i].selector);
        }
        if(isEmpty(erros)){
            enviarDadosCadastroChamado();
        }else{
            $("#cadastrar").removeClass("disabled");
            $("#cadastrar").html("Cadastrar");
            for(i = 0; i < erros.length; i++){
                if(!$(erros[i]).hasClass("vazio")){
                    $(erros[i]).addClass("is-invalid");
                }
            }
            notificationWarningOne("Preencha os campos obrigatórios!");
        }
        return null;
    }

    function enviarDadosCadastroChamado(){
        $.ajax({
            type: "POST",
            url: "../inserts/insere_chamado2.php",
            data: carregaDadosCadastroChamado(),
            success: function(data){
                data = JSON.parse(data);
                if(data.status == "success"){
                    notificationSuccessLink('Registro salvo', 'Chamado registrado com sucesso!', '../pages/chamados');
                    window.open(
                    '../pages/abrechamadoFa='+data.idChamado,
                    '_blank' 
                    );
                    $("#modalCad").modal('hide');
                }else{
                    notificationError('Ocorreu um erro ao salvar o registro: ', data);
                    $("#cadastrar").removeClass( ' disabled ' );
                    $("#cadastrar").html('Salvar');
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('error: ' + textStatus + ': ' + errorThrown);
            }
        });
    }

    function carregaDadosCadastroChamado(){
        var data = [];
        data.push({name: 'empresa', value: empresa.val()});
        data.push({name: 'contato', value: contato.val()});
        data.push({name: 'telefone', value: telefone.val()});
        data.push({name: 'versao', value: versao.val()});
        data.push({name: 'sistema', value: sistema.val()});
        data.push({name: 'cnpj', value: cnpj});
        return data;
    }
</script>
