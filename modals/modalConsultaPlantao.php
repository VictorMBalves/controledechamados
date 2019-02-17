<?php
    include '../validacoes/verificaSession.php';
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $id=$_GET['id_plantao'];
    $sql = $db->prepare("SELECT *, DATE_FORMAT(data,'%d/%m/%Y') as data FROM plantao WHERE id_plantao=$id");
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $empresa = $row['empresa'];
    $sql2 = $db->prepare("SELECT backup FROM empresa WHERE nome = '$empresa'");
    $sql2->execute();
    $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
?>
<div class="modal" tabindex="-1" role="dialog" id="modalCon">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Consulta Plantão Nº <?php echo $id ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="empresa">Empresa solicitante:</label>
                            <input value='<?php echo $row['empresa'];?>' name="empresa" type="text" disabled class="form-control disabled">
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="contato">Contato:</label>
                                <input value='<?php echo $row['contato'];?>' id="nome" name="contato" type="text" disabled class="form-control disabled">
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="formacontato">Forma de contato:</label>
                                <input value="<?php echo $row['formacontato'];?>" type="text" name="formacontato" class="form-control disabled" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="telefone">Telefone:</label>
                                <input value='<?php echo $row['telefone'];?>' disabled name="telefone" type="text" class="form-control disabled">
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="sistema">Sistema:</label>
                                <input type="text" value="<?php  echo $row['sistema'];?>" name="sistema" class="form-control disabled" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="backup">backup:</label>
                                <input type="text" value="<?php 
                                            if ($row2['backup'] == 0) {
                                                echo "Google drive não configurado";
                                            } else {
                                                echo "Google drive configurado";
                                            }
                                        ?>" id="backup" disabled name="backup" class="form-control disabled">
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="categoria">Categoria:</label>
                                <input type="text" value="<?php  echo $row['categoria'];?>" name="categoria" disabled class="form-control disabled">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="datainicio">Data inicio: </label>
                                <input class="form-control disabled" name="datainicio" disabled value='<?php echo $row['data'].' '.$row['horainicio'];?>'>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="datafim">Data término:</label>
                                <input class="form-control forma disabled" name="datafim" disabled value='<?php echo $row['data'].' '.$row['horafim'];?>'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="responsavel">Responsável:</label>
                            <input class="form-control disabled" name="responsavel" disabled value='<?php echo $row['usuario']?>'>
                        </div>
                        <div class="form-group">
                            <label for="descproblema">Descrição do problema:</label>
                            <textarea name="descproblema" class="form-control disabled" disabled><?php echo $row['descproblema'];?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="descsolucao">Solução:</label>
                            <textarea name="descsolucao" class="form-control disabled" disabled><?php echo $row['descsolucao'];?></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-center">
                        <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary" data-dismiss="modal">Retornar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>