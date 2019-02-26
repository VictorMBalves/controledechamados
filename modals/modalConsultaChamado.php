<?php
    include '../validacoes/verificaSession.php';
    require_once '../include/Database.class.php';
    $db = Database::conexao();

    $id=$_GET['id_chamado'];
    $sql = $db->prepare("SELECT *, DATE_FORMAT(datainicio,'%d/%m/%Y %H:%i') as datainicio, DATE_FORMAT(datafinal,'%d/%m/%Y %H:%i') as datafinal FROM chamado WHERE id_chamado=$id");
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $empresa = $row['empresa'];
    $sql2 = $db->prepare("SELECT backup FROM empresa WHERE nome = '$empresa'");
    $sql2->execute();
    $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
    $linkRequest = "http://request.gtech.site/requests/new?request[description]=".$row['descproblema']."&request[requester_cnpj]=".$row['cnpj']."&request[requester_name]=".$row['cnpj']." - ".$row['empresa'];
?>
<div class="modal" tabindex="-1" role="dialog" id="modalCon">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Consulta Chamado Nº <?php echo $id ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="empresa">Empresa solicitante:</label>
                            <input value='<?php echo $row['empresa'];?>'name="empresa" type="text" disabled class="form-control disabled" required/>
                        </div>
                        <div class="form-group">
                            <label for="contato">Contato:</label>
                            <input value='<?php echo $row['contato'];?>' id="nome" name="contato" type="text" disabled class="form-control disabled" required/>
                        </div>
                        <div class="form-group">
                            <label for="responsavel">Responsável:</label>
                            <input class="form-control label1 disabled" name="responsavel" disabled value='<?php echo $row['usuario']?>'>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="formacontato">Forma de contato:</label>
                                <input value="<?php echo $row['formacontato'];?>" name="formacontato" type="text" class="form-control disabled" disabled>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="versao">Versão:</label>
                                <input type="text" name="versao" class="form-control disabled" value="<?php echo $row['versao']?>" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="cep">Telefone:</label>
                                <input value='<?php echo $row['telefone'];?>' disabled name="telefone" type="text" class="form-control disabled" onkeypress="return SomenteNumero(event)">
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="sistema">Sistema:</label>
                                <input value="<?php  echo $row['sistema'];?>" name="sistema" type="text" class="form-control  disabled" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="backup">Backup:</label>
                                <input type="text" value="<?php 
                                            if ($row2['backup'] == 0) {
                                                echo "Google drive não configurado";
                                            } else {
                                                echo "Google drive configurado";
                                            }
                                        ?>" name="backup" class="form-control  disabled" disabled="">
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label class="col-md-2 control-label">Categoria:</label>
                                <input type="text" value="<?php  echo $row['categoria'];?>" name="categoria" disabled class="form-control  disabled">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="datainicio">Data inicio: </label>
                                <input name="datainicio" class="form-control disabled" disabled value='<?php echo $row['datainicio']?>'>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="datafinal">Data término:</label>
                                <input class="form-control disabled" name="datafinal" disabled value='<?php echo $row['datafinal']?>'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desproblema">Descrição do problema:</label>
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
                        <?php
                            if($row['categoria'] == "Erro" || $row['categoria'] == "Sugestão de melhoria"){
                                echo '<a href="'.$linkRequest.'" target="_blank" id="criarRequest" name="criarRequest" class="btn btn-group-lg btn-danger"><i class="fas fa-bug" style="-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i>&nbsp;Criar request</a>';
                            }
                        ?>
                        <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary" data-dismiss="modal">Retornar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>