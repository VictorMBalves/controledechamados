<?php
    include '../validacoes/verificaSession.php';
    
    require_once '../include/Database.class.php';
    $db = Database::conexao();

	$id=$_GET['id_chamadoespera'];
	$sql = $db->prepare("SELECT *, DATE_FORMAT(data,'%d/%m/%Y %H:%i') as data FROM chamadoespera WHERE id_chamadoespera=$id");
	$sql->execute();
	$row = $sql->fetch(PDO::FETCH_ASSOC);
?>
<div class="modal" tabindex="-1" role="dialog" id="modalCon">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Consulta Chamado em espera Nº <?php echo $id ?></h4>
                </div>
                <div class="modal-body">
                    <div id="resultadoHistorico">
                    </div>
                    <form class="form-horizontal">
                    <input style="display:none;" id="idChamado" name="id_chamadoespera" value="<?php echo $id?>">
                        <div class="form-group"> 
                            <label class="col-md-2 control-label">Empresa Solicitante:</label>
                            <div class="col-sm-10">
                                <input name="empresa" type="text" class="form-control disabled" disabled value="<?php echo $row['empresa'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Contato:</label>
                            <div class="col-sm-4">
                                <input name="contato" value="<?php echo $row['contato'];?>" type="text" class="form-control disabled" disabled>
                            </div>
                            <label class="col-md-2 control-label">Telefone:</label>
                            <div class="col-sm-4">
                                <input name="telefone" value="<?php echo $row['telefone'];?>" type="text" class="form-control disabled" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Usuário Solicitante:</label>
                            <div class="col-sm-4">
                                <input name="usuario" value="<?php echo $row['usuario'];?>" type="text" class="form-control disabled" disabled>
                            </div>
                            <label class="col-md-2 control-label empresa">Data:</label>
                            <div class="col-sm-4">
                                <input name="usuario" value="<?php echo $row['data'];?>" type="text" class="form-control disabled" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="versao">Versão</label>
                            <div class="col-sm-4">
                                <input id="versao" name="versao" type="text" class="form-control disabled" value="<?php echo $row['versao']?>" disabled>
                            </div>
                            <label class="col-md-2 control-label" for="sistema">Sistema:</label>
                            <div class="col-sm-4">
                                <input name="sistema" type="text" class="form-control disabled" value="<?php echo $row['sistema']?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="descproblema">Descrição do problema:</label>
                            <div class="col-sm-10">
                                <textarea name="descproblema" class="form-control disabled" disabled required=""><?php echo $row['descproblema'];?></textarea>
                            </div>
                        </div>
                            <?php 
                                if (!(is_null($row['historico']))) {
                                    echo '<div class="form-group">
                                                <label class="col-md-2 control-label" for="descproblema">Histórico de contato:</label> 
                                            <div class="col-sm-10">
                                                <textarea name="historico" class="form-control label1 disabled" disabled>'.$row['historico'].'</textarea> 
                                            </div>
                                        </div>';
                                }
                            ?>
                        <div class="collapse" id="abrirHistorico">
                            <div class="form-group" id="divHistorico">
                                <label class="col-md-2 control-label" for="descproblema">Histórico de contato:</label>
                                <div class="col-sm-10">
                                    <textarea name="historico" id="historico" class="form-control label1 "></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-group-lg btn-success" id="salvarHistorico">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#abrirHistorico" aria-expanded="false" aria-controls="collapseExample" data-placement='left' title='Adicionar histórico de contato!'>Adcionar Histórico de contato</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#salvarHistorico").on("click", function () {
           id = $("#idChamado").val();
           historico = $("#historico").val();

           if(historico == ''){
               $("#divHistorico").addClass("has-error");
               return;
           }else{
                $("#salvarHistorico").html('<img src="../imagem/ajax-loader.gif">');
                $.ajax({
                type: "POST",
                url: "../updates/updateconsulta.php",
                data:{id:id,
                      historico:historico},
                success: function(data)
                {
                    data = data.trim();
                    if(data == "success"){
                        $("#salvarHistorico").html("salvar");
                        $("#resultadoHistorico").html('<div class="alert alert-success text-center" role="alert">Histórico adicionado com sucesso</div>');
                        setTimeout(function(){
                            $("#modalCon").modal('hide');
                        }, 1000);
                    }else{
                        $("#salvarHistorico").html("salvar");
                        $("#resultadoHistorico").html('<div class="alert alert-danger text-center" role="alert">Erro ao salvar histórico</div>');
                    }
                }
            });
           }
        });

        $(function () {$('[data-toggle="tooltip"]').tooltip()});
    </script>