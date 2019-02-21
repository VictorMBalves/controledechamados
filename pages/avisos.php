<!-- Parte de cima do painel de avisos -->
<div class="card" style="background-color:#d4ddf7;">
    <div class="card-header" style="background-color:#d4ddf7;">
        <div class="row">
            <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                <h1 class="h3 mb-0 text-gray-800" >Avisos</h1>
            </div>
            <div class="col-4 col-sm-4 col-xs-4 text-right">
                <?php
                    session_start(); 
                    if($_SESSION['UsuarioNivel'] == 3){
                        echo'<a href="#" id="adc" class="btn btn-success btn-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Adicionar novo aviso">
                                <i class="fas fa-plus"></i>
                            </a>';
                    }
                ?>
            </div> 
        </div>
    </div>
    <div class="card-body">
  
        <!-- Container de panels dos avisos -->
        <div class="card-columns">
            <?php
                require_once '../include/Database.class.php';
                $db = Database::conexao();
                $sql = $db->prepare("SELECT * FROM avisos ORDER BY data DESC");
                $sql->execute();
                $avisos = $sql->fetchall(PDO::FETCH_ASSOC);

                foreach($avisos as $aviso){
                    echo'<div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                        <h6 class="panel-title"><strong>'.$aviso['titulo'].'</strong></h6>
                                    </div>';
                                    if($_SESSION['UsuarioNivel'] == 3){
                                        echo '
                                        <div class="col-2 col-sm-2 col-md-2 col-lg-2 text-right" style="padding:0px;">
                                            <a class="btn btn-default btn-circle" onclick="editarAviso('.$aviso['id'].')">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </div>
                                        <div class="col-2 col-sm-2 col-md-2 col-lg-2 text-left" style="padding:0px;">
                                            <a class="btn btn-default btn-circle" onclick="excluirAviso('.$aviso['id'].')">
                                                <i class="fas fa-times-circle"></i>
                                            </a>
                                        </div>
                                    ';
                                    }
                    echo' 
                                </div>
                            </div>
                            <div class="card-body">
                                <blockquote class="blockquote mb-0">';
                                    echo $aviso['descricao'].
                            '   </blockquote>
                            </div>
                        </div>';
                
                }
            ?>
        </div>
    </div>
</div>

<!-- Modal de avisos-->
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
                    <div class="form-group" id="tituloAvisodiv">
                        <label for="titulo" >Titulo</label>
                        <input type="text" class="form-control" id="tituloAviso" name="tituloAviso">
                    </div>
                    <div class="form-group" id="descricaoAvisodiv">
                        <label for="titulo">Descrição</label>
                        <textarea type="text" class="form-control" name="descricaoAviso" id="descricaoAviso" required></textarea>
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