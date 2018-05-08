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
        $("#descricaoAviso").addClass("error");
        i++;
       }else{
        $("#descricaoAviso").removeClass("error");
       }
       if(titulo == ""){
        $("#tituloAviso").addClass("error");
        i++;
       }else{
        $("#tituloAviso").removeClass("error");
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
                        alert("aviso salvo");
                    }else{
                        alert("Erro ao salvar");
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
                    alert("aviso excluído");
                }else{
                    alert("Erro ao excluído");
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
                    alert("aviso atualizado");
                    $("#modalAdc").modal('hide');
                }else{
                    alert("Erro ao salvar");
                }
            }
        });
    }