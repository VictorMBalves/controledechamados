<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<div style="background-color:#222; color:white; padding:5px; border-top-right-radius:2px; border-top-left-radius:2px;">
    <div style="height:35px;">
        <div class="col-sm-10 col-xs-10" style="padding-top:5px;">Avisos</div>
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
<div style="max-height: 300px; overflow: auto;">
<br>
<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $sql = $db->prepare("SELECT * FROM avisos ORDER BY data DESC");
    $sql->execute();
    $avisos = $sql->fetchall(PDO::FETCH_ASSOC);

    foreach($avisos as $aviso){
    echo'<div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-10 col-xs-10">
                        <h3 class="panel-title"><strong>'.$aviso['titulo'].'</strong></h3>
                    </div>';
                        if($_SESSION['UsuarioNivel'] == 3){
                            echo '
                            <div class="col-sm-1">
                                <a type="button" class="btn btn-default btn-xs" onclick="editarAviso('.$aviso['id'].')">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            </div>
                            <div class="col-sm-1">
                                <a type="button" class="btn btn-default btn-xs" onclick="excluirAviso('.$aviso['id'].')">
                                    <span aria-hidden="true">&times;</span>
                                </a>
                            </div>';
                        }
                echo' 
                </div>
            </div>
            <div class="panel-body">';
                echo  $aviso['descricao'];
            echo '
            </div>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Avisos</h5>
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
                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-primary" id="modal-salvar">salvar</button>
                    <button type="button" class="btn btn-secundary" id="modal-retornar">Retornar</button>
                </div>
            </div>
            </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="../js/avisos.js"></script>
