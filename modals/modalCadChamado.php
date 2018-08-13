<div class="modal" tabindex="-1" role="dialog" id="modalCad">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cadastro Chamado</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="POST">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Empresa solicitante:</label>
                        <div id="empresa-div" class="col-sm-10">
                            <input name="empresa" type="text" id="empresa" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="contato">Contato:</label>
                        <div id="contato-div" class="col-sm-10">
                            <input id="contato" name="contato" type="text" class="form-control" required/>
                        </div>
                    </div>
        
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="cep">Telefone:</label>
                        <div id="telefone-div" class="col-sm-10">
                            <input name="telefone" id="telefone" type="text" class="form-control" onkeypress="return SomenteNumero(event)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="versao">Versão:</label>
                        <div id="versao-div" class="col-sm-4">
                            <input id="versao" name="versao" type="text" class="form-control disabled" disabled>
                        </div>
                        <label class="col-md-2 control-label" for="sistema">Sistema:</label>
                        <div id="sistema-div" class="col-sm-4">
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
            source: '../utilsPHP/search.php'
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
                    $(erros[i]+"-div").addClass("has-error");
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