<!-- Parte de cima do painel de avisos -->
<div class="col-sm-12 cabecalhoAviso">
    <div class="row" style="height:35px;">
        <div class="col-sm-10 col-xs-10" style="padding-top:6px;">Avisos</div>
            <div class="col-sm-2 col-xs-2 text-center">
                <?php
                    session_start(); 
                    if($_SESSION['UsuarioNivel'] == 3){
                        echo'<a type="button" href="#" class="btn plus" id="adc">
                                <i class="fas fa-plus-circle"></i>
                            </a>';
                    }
                ?>
            </div> 
        </div>
    </div>
</div>

<!-- Container de panels dos avisos -->
<div class="col-sm-12" style="max-height: 300px; overflow: auto;">
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
                            <div class="col-sm-8 col-xs-8">
                                <h3 class="panel-title"><strong>'.$aviso['titulo'].'</strong></h3>
                            </div>';
                            if($_SESSION['UsuarioNivel'] == 3){
                                echo '
                                <div class="col-sm-4 col-xs-4 text-right">
                                    <a type="button" class="btn btn-default btn-xs" onclick="editarAviso('.$aviso['id'].')">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>
                                    <a type="button" class="btn btn-default btn-xs" onclick="excluirAviso('.$aviso['id'].')">
                                        <i class="fas fa-times-circle"></i>
                                    </a>
                                </div>';
                            }
                        echo' 
                        </div>
                    </div>
                    <div class="panel-body">';
                        echo $aviso['descricao'].
                    '</div>
                </div>';
        }
    ?>
</div>

<!-- Modal de avisos-->
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
                    <div class="form-group" id="tituloAvisodiv">
                        <label for="titulo" class="control-label col-sm-2">Titulo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tituloAviso" name="tituloAviso">
                        </div>
                    </div>
                    <div class="form-group" id="descricaoAvisodiv">
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

<script src="../js/avisos.js"></script>
