<div style="max-height: 400px; overflow: auto;">
    <div style="background-color:#222;color:white; border-top-left-radius:3px; border-top-right-radius:3px; " class="col-sm-12">
        <div class="row">
            <div class="col-sm-10" style="padding-top:5px;">Avisos</div>
            <div class="col-sm-1">
                <?php
                session_start(); 
            if($_SESSION['UsuarioNivel'] == 3){
            echo '<a type="button" href="#" class="btn plus" id="adc">
                <span class="glyphicon glyphicon-plus-sign"></span>
                </a>';
            }
            ?>
        </div> 
    </div>
</div>
<br>
<br>
<?php
    include "include/dbconf.php";
    $sql = $conn->prepare("SELECT * FROM avisos ORDER BY data DESC");
    $sql->execute();
    $avisos = $sql->fetchall();

    foreach($avisos as $aviso){
    echo'<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-10">
                <h3 class="panel-title"><strong>'.$aviso['titulo'].'</strong></h3>
            </div>
            <div class="col-sm-1">';
            if($_SESSION['UsuarioNivel'] == 3){
            echo '<a type="button" class="btn btn-default btn-xs" onclick="editarAviso('.$aviso['id'].')">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>';
            }
        echo'   </div>
            <div class="col-sm-1">';
            if($_SESSION['UsuarioNivel'] == 3){
            echo'    <a type="button" class="btn btn-default btn-xs" onclick="excluirAviso('.$aviso['id'].')">
                    <span aria-hidden="true">&times;</span>
                </a>';
            }
        echo '</div>
        </div>
    </div>
    <div class="panel-body">';
      echo  $aviso['descricao'];
    echo '</div>
    </div>';
    }
?>
</div>

<!--
    Modal
-->
  <div class="modal" tabindex="-1" role="dialog" id="modalAdc">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Avisos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAviso" class="form-horizontal">
                    <div class="form-group">
                        <label for="titulo" class="control-label col-sm-2">Titulo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tituloAviso" name="tituloAviso">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="titulo" class="control-label col-sm-2">Descrição</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" name="descricaoAviso" id="descricaoAviso" required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" id="rodape">
                <button type="button" class="btn btn-primary" id="modal-salvar">salvar</button>
                <button type="button" class="btn btn-secundary" id="modal-retornar">Retornar</button>
            </div>
            </div>
        </div>
    </div>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<script>
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
  }
    modalConfirm(function(confirm){
        if(confirm){
            var dados = $('#formAviso').serialize();
                    
            $.ajax({
                type: "POST",
                url: "updates/updateAviso.php?acao=novo",
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
            url: "updates/updateAviso.php?acao=excluir",
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
        var getAviso = "updates/updateAviso.php?id="+id+"&acao=getAviso";
        $.getJSON( getAviso, {
            format: "json"
        })
            .done(function( data ) {
                $("#descricaoAviso").val(data["descricao"]);
                $("#tituloAviso").val(data["titulo"]);
                $("#rodape").html('<button type="button" class="btn btn-primary" onclick="updateAviso('+id+')">Salvar</button>');
                $("#modalAdc").modal('show');
            });
        })();
    }

    function updateAviso(id){
        var dados = $('#formAviso').serialize();
        $.ajax({
            type: "POST",
            url: "updates/updateAviso.php?acao=update&id="+id,
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
</script>
