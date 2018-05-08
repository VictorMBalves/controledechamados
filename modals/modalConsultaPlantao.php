<?php
    include '../validacoes/verificaSession.php';
    include '../include/dbconf.php';
    $conn->exec('SET CHARACTER SET utf8');
    $id=$_GET['id_plantao'];
    $sql = $conn->prepare("SELECT *, DATE_FORMAT(data,'%d/%m/%Y') as data FROM plantao WHERE id_plantao=$id");
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $empresa = $row['empresa'];
    $sql2 = $conn->prepare("SELECT backup FROM empresa WHERE nome = '$empresa'");
    $sql2->execute();
    $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
?>
<div class="modal" tabindex="-1" role="dialog" id="modalCon">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Consulta Plantão Nº <?php echo $id ?></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="plantao.php" method="POST">
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="empresa">Empresa solicitante:</label>
                            <div class="col-sm-10">
                                <input value='<?php echo $row['empresa'];?>' name="empresa" type="text" disabled class="form-control disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="contato">Contato:</label>
                            <div class="col-sm-4">
                                <input value='<?php echo $row['contato'];?>' id="nome" name="contato" type="text" disabled class="form-control disabled">
                            </div>
                            <label class="col-md-2 control-label">Forma de contato:</label>
                            <div class="col-sm-4">
                                <select name="formacontato" class="form-control disabled" disabled>
                                    <option>
                                        <?php echo $row['formacontato'];?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="telefone">Telefone:</label>
                            <div class="col-sm-4">
                                <input value='<?php echo $row['telefone'];?>' disabled name="telefone" type="text" class="form-control disabled">
                            </div>
                            <label class="col-md-2 control-label" for="sistema">Sistema:</label>
                            <div class="col-sm-4">
                                <select name="sistema" class="form-control disabled" disabled>
                                    <option>
                                        <?php  echo $row['sistema'];?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="backup">backup:</label>
                            <div class="col-sm-4">
                                <select id="backup" disabled name="backup" class="form-control disabled">
                                    <option>
                                        <?php 
                                            if ($row2['backup'] == 0) {
                                                echo "Google drive não configurado";
                                            } else {
                                                echo "Google drive configurado";
                                            }
                                        ?>
                                    </option>
                                </select>
                            </div>
                            <label class="col-md-2 control-label">Categoria:</label>
                            <div class="col-sm-4">
                                <select name="categoria" disabled class="form-control disabled">
                                    <option value="Manager">
                                        <?php  echo $row['categoria'];?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Data inicio: </label>
                            <div class="col-sm-4">
                                <input class="form-control disabled" disabled value='<?php echo $row['data'].' '.$row['horainicio'];?>'>
                            </div>
                            <label class="col-md-2 control-label">Data término:</label>
                            <div class="col-sm-4">
                                <input class="form-control forma disabled" disabled value='<?php echo $row['data'].' '.$row['horafim'];?>'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Responsavel:</label>
                            <div class="col-sm-10">
                                <input class="form-control disabled" disabled value='<?php echo $row['usuario']?>'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Descrição do problema:</label>
                            <div class="col-sm-10">
                                <textarea name="descproblema" class="form-control disabled" disabled><?php echo $row['descproblema'];?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label ">Solução:</label>
                            <div class="col-sm-10">
                                <textarea name="descsolucao" class="form-control label1 disabled" disabled><?php echo $row['descsolucao'];?></textarea>
                            </div>
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