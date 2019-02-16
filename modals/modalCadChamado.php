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
                        <input name="empresa" type="text" id="empresa" onblur="callApi(this)" class="form-control">
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
                </form>
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <?php include "../utilsPHP/statusDados.php";?>
                    </div>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-center">
                    <button id="cadastrar" name="cadastrar" class="btn btn-group-lg btn-success">Cadastrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#empresa").autocomplete({
            source: '../utilsPHP/search.php',
            autoFocus: true
        });
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
        validar(components);
        return null;
    });
    
    function validar(components){
        erros = [];
        for(i = 0; i < components.length; i++){
            if(isEmpty(components[i].val()))
                erros.push(components[i].selector);
        }
        if(isEmpty(erros)){
            enviarDados();
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

    function enviarDados(){
        $.ajax({
            type: "POST",
            url: "../inserts/insere_chamado2.php",
            data: carregaDados(),
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
                    $("#cadastrar").html('Cadastrar');
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('error: ' + textStatus + ': ' + errorThrown);
            }
        });
    }

    function carregaDados(){
        var data = [];
        data.push({name: 'empresa', value: empresa.val()});
        data.push({name: 'contato', value: contato.val()});
        data.push({name: 'telefone', value: telefone.val()});
        data.push({name: 'versao', value: versao.val()});
        data.push({name: 'sistema', value: sistema.val()});
        return data;
    }
</script>
<script src="../js/apiConsulta.js"></script>