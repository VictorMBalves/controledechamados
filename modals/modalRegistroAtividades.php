<div class="modal" tabindex="-1" role="dialog" id="modalCad">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Registro de atividades ECF</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="POST">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="dtInicial">Data Inicial:</label>
                        <div id="dtInicial-div" class="col-sm-4">
                            <input id="dtInicial" name="dtInicial" type="date" class="form-control">
                        </div>
                        <label class="col-md-2 control-label" for="dtFinal">Data Final:</label>
                        <div id="dtFinal-div" class="col-sm-4">
                            <input id="dtFinal" name="dtFinal" type="date" class="form-control">
                        </div>
				    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label class="col-md-4 control-label">
                                <input type="checkbox" id="agruparSituacao"> Agrupar por situação
                            </label>
                        </div>
				    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-center">
                    <button id="gerar" name="gerar" class="btn btn-group-lg btn-success">Gerar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#gerar").click(function(){
        dtInicial = $("#dtInicial");
        dtFinal = $("#dtFinal");
        components = [
            dtInicial,
            dtFinal,
        ];
		$("#gerar").addClass( ' disabled ' );
        $("#gerar").html('<img src="../imagem/ajax-loader.gif">');
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
            $("#gerar").removeClass("disabled");
            $("#gerar").html("gerar");
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
        try{
            var request = new XMLHttpRequest();
            request.open('POST', 'http://coruja.gtech.site/generate_pdf/', true);
            request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8', "Access-Control-Expose-Headers", "Content-Disposition");
            request.responseType = 'blob';
            request.onload = function() {
                // Only handle status code 200
                if(request.status === 200) {
                    var filename = "Registro de atividades ECF "
                    // The actual download
                    var blob = new Blob([request.response], { type: 'application/pdf' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;

                    document.body.appendChild(link);

                    link.click();

                    document.body.removeChild(link);
                    $("#modalCad").modal('hide');
                    $("#gerar").removeClass( ' disabled ' );
                    $("#gerar").html('Gerar');
                    return false;
                }
                $("#modalCad").modal('hide');
                $("#gerar").removeClass( ' disabled ' );
                $("#gerar").html('Gerar');
                notificationErrorLogin("Erro ao gerar relatório "+request.response);
            };
            request.send(JSON.stringify(carregaDados()));
        }catch(e){
            notificationErrorLogin("Erro ao gerar relatório "+e);
            return false;
        }
    }

    function carregaDados(){
      return {	
        "name": "registro_atividade_ecf", 
        "connection": "germantech_api", 
        "parameters": {
            "dataInicial": dtInicial.val(), 
            "dataFinal": dtFinal.val(),
            "agrupar": $("#agruparSituacao").is( ":checked" ) ? true : false
            }
        }
    }
</script>