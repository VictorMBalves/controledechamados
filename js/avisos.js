var modalConfirm = function(callback){
    $("#adc").on("click", function(){
        $("#descricaoAviso").val('');
        $("#tituloAviso").val('');
        $("#modalAdc").modal('show');
    });
  
    $("#modal-salvar").on("click", function(){

       descricao = $("#descricaoAviso").val();
       titulo = $("#tituloAviso").val();
        i = 0;

       if(descricao == ""){
        $("#descricaoAvisodiv").addClass("has-error");
        notificationWarningOne("Preencha os campos obrigatórios!");
        i++;
       }else{
        $("#descricaoAvisodiv").removeClass("has-error");
       }
       if(titulo == ""){
        $("#tituloAvisodiv").addClass("has-error");
        notificationWarningOne("Preencha os campos obrigatórios!");
        i++;
       }else{
        $("#tituloAvisodiv").removeClass("has-error");
       }
       if(i<=0){
        callback(true);
        $("#modalAdc").modal('hide');
       }
    });
    
    $("#modal-retornar").on("click", function(){
        callback(false);
        $("#modalAdc").modal('hide');
    });
};
    modalConfirm(function(confirm){
        if(confirm){
            var dados = $('#formAviso').serialize();
                    
            $.ajax({
                type: "POST",
                url: "../updates/updateAviso.php?acao=novo",
                data:dados,
                success: function(data)
                {
                    data = data.trim();
                    if(data == "success"){
                        $("#avisos").load("avisos.php");
                        notificationSuccess("Registro salvo", "Aviso salvo com sucesso");
                    }else{
                        notificationSuccess("Ocorreu um erro ao salvar o registro:", data);
                    }
                }
            });
        }
    });
    

    function excluirAviso(id){
        $.ajax({
            type: "POST",
            url: "../updates/updateAviso.php?acao=excluir",
            data:{id:id},
            success: function(data)
            {
                data = data.trim();
                if(data == "success"){
                    $("#avisos").load("avisos.php");
                    notificationSuccess("Registro excluído", "Aviso excluído com sucesso");
                }else{
                    notificationSuccess("Ocorreu um erro ao excluir o registro:", data);
                }
            }
        });
    }

    function editarAviso(id){
        (function() {
        var getAviso = "../updates/updateAviso.php?id="+id+"&acao=getAviso";
        $.getJSON( getAviso, {
            format: "json"
        })
            .done(function( data ) {
                $("#descricaoAviso").val(data.descricao);
                $("#tituloAviso").val(data.titulo);
                $("#rodape").html('<button type="button" class="btn btn-primary" onclick="updateAviso('+id+')">Salvar</button>');
                $("#modalAdc").modal('show');
            });
        })();
    }

    function updateAviso(id){
        var dados = $('#formAviso').serialize();
        $.ajax({
            type: "POST",
            url: "../updates/updateAviso.php?acao=update&id="+id,
            data:dados,
            success: function(data)
            {
                data = data.trim();
                if(data == "success"){
                    $("#avisos").load("avisos.php");
                    notificationSuccess("Registro salvo", "Aviso atualizado com sucesso");
                    $("#modalAdc").modal('hide');
                }else{
                    notificationSuccess("Ocorreu um erro ao atualizar o registro:", data);
                }
            }
        });
    }