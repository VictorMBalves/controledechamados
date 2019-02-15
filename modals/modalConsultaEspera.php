<?php
    include '../validacoes/verificaSession.php';
    
    require_once '../include/Database.class.php';
    $db = Database::conexao();

	$id = $_GET['id_chamadoespera'];
	$sql = $db->prepare("SELECT *, DATE_FORMAT(data,'%d/%m/%Y %H:%i') as data FROM chamadoespera WHERE id_chamadoespera=$id");
	$sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);

    if($row['status'] == "Finalizado"){
        echo '<script type="text/javascript"> notificationError("Ocorreu um erro ao visualizar o registro: ", "Chamado finalizado");</script>';
        exit;
    }

    $sql= "SELECT id, id_chamadoespera, DATE_FORMAT(dataregistro,'%d/%m/%Y %H:%i') as data, usuario, descricaohistorico, emailusuario FROM historicochamado WHERE id_chamadoespera=$id ORDER BY dataregistro DESC";
    $query = $db->prepare($sql);
    $query->execute();
    $historicos = $query->fetchall(PDO::FETCH_ASSOC);
?>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalCon" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                        <h4 class="modal-title">Consulta Chamado em espera Nº <?php echo $id ?></h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <?php
                            // if($_SESSION['UsuarioNivel'] == 3){
                            //     echo '
                            //         <script>colorNotification('.$row['notification'].')</script>
                            //         <div class="col-sm-12 text-right">';
                            //         if($row['notification'])
                            //             echo '<input type="checkbox" name="notification" id="notification" style="display:none;" checked>';
                            //         else
                            //             echo '<input type="checkbox" name="notification" id="notification" style="display:none;" >';
                                   
                            //          echo '<label id="labelNotification" for="notification" data-toggle="tooltip" data-placement="top" title="Habilitar/Desabilitar notificações"><i class="glyphicon glyphicon-bell icon"></i></label>';
                            //     echo'</div>
                            //         <br/>';
                            // }
                        ?>
                       
                </div>
                <div class="modal-body">
                    <div id="resultadoHistorico">
                    </div>
                    <input style="display:none;" id="idChamado" name="id_chamadoespera" value="<?php echo $id?>">
                    <div class="form-group"> 
                        <label for="empresa">Empresa Solicitante:</label>
                        <input name="empresa" type="text" class="form-control disabled" disabled value="<?php echo $row['empresa'];?>">
                    </div>
                    <div class="row"> 
                        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="contato" >Contato:</label>
                            <input name="contato" value="<?php echo $row['contato'];?>" type="text" class="form-control disabled" disabled>
                        </div>
                        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="telefone">Telefone:</label>
                            <input name="telefone" value="<?php echo $row['telefone'];?>" type="text" class="form-control disabled" disabled>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="usuario">Usuário Solicitante:</label>
                            <input name="usuario" value="<?php echo $row['usuario'];?>" type="text" class="form-control disabled" disabled>
                        </div>
                        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="data">Data:</label>
                            <input name="data" value="<?php echo $row['data'];?>" type="text" class="form-control disabled" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="versao">Versão</label>
                            <input id="versao" name="versao" type="text" class="form-control disabled" value="<?php echo $row['versao']?>" disabled>
                        </div>
                        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                            <label class="col-md-2 control-label" for="sistema">Sistema:</label>
                            <input name="sistema" type="text" class="form-control disabled" value="<?php echo $row['sistema']?>" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descproblema">Descrição do problema:</label>
                        <textarea name="descproblema" class="form-control disabled" disabled required=""><?php echo $row['descproblema'];?></textarea>
                    </div>       
                            
                            <?php 
                                if (!empty($historicos)) {
                                    echo ' <label>Histórico de contato:</label>
                                            <div class="form-group well" style="max-height: 150px; overflow: auto;"> 
                                            ';
                                            foreach ($historicos as $historico) {
                                                echo '<div class="card" style="padding:5px;">';
                                                echo '<div class="card-header">
                                                        <div class="row">';
                                                    echo '<div class="col-6 col-sm-6 col-md-6 col-lg-6"> 
                                                            <img class="img-profile rounded-circle" src="https://www.gravatar.com/avatar/'.md5($historico['emailusuario']).'" width="25px"> '.$historico['usuario'];
                                                    echo '</div>
                                                          <div class="col-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                            <small><i class="far fa-clock"></i> '.$historico['data'].'</small>
                                                          </div>
                                                        </div>';
                                                echo '</div>';
                                                    echo '<div class="card-body">';
                                                        echo $historico['descricaohistorico'];
                                                    echo '</div>';
                                                echo '</div>';
                                            }
                                    echo'</div>';
                                }
                            ?>
                        <div class="collapse" id="abrirHistorico">
                            <div class="form-group" id="divHistorico">
                                <label for="historico">Histórico de contato:</label>
                                <textarea name="historico" id="historico" class="form-control label1 "></textarea>
                            </div>
                            <div class="form-group text-center">
                                <button type="button" class="btn btn-group-lg btn-success" id="salvarHistorico">Salvar</button>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#abrirHistorico" aria-expanded="false" aria-controls="collapseExample" data-placement='left' title='Adicionar histórico de contato!'>Adicionar Histórico de contato</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#salvarHistorico").on("click", function () {
           $("#salvarHistorico").addClass(" disabled ");
           id = $("#idChamado").val();
           historico = $("#historico").val();

           if(historico == ''){
               $("#divHistorico").addClass("has-error");
               notificationWarningOne("Preencha os campos obrigatórios!");
               $("#salvarHistorico").removeClass(" disabled ");
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
                        $("#salvarHistorico").html("Salvar");
                        notificationSuccess('Registro salvo', 'Histórico de contato salvo com sucesso!');
                        $("#loading").html('<img src="../imagem/loading.gif">');
                        $('#tabela').DataTable().destroy();
                        $('#tbody').empty();
                        loadTable();
                        setTimeout(function(){
                            $("#modalCon").modal('hide');
                        }, 1000);
                    }else{
                        $("#salvarHistorico").html("Salvar");
                        $("#salvarHistorico").removeClass(" disabled ");
                        notificationError('Ocorreu um erro ao salvar o registro: ', data);
                    }
                }
            });
           }
        });
        
        $("#notification").on("click", function (){
            id = $("#idChamado").val();
            colorNotification($("#notification").is( ":checked" ));
            $.ajax({
                type: "POST",
                url: "../updates/updateconsulta.php",
                data:{id:id,
                      notification:$("#notification").is( ":checked" )},
                success: function(data)
                {
                    data = data.trim();
                    if(data == "success"){
                        notificationSuccess('Registro salvo', 'Notificação salva com sucesso');
                        setTimeout(function(){
                            $("#modalCon").modal('hide');
                        }, 2000);
                    }else{
                        $("#salvarHistorico").html("Salvar");
                        notificationError('Ocorreu um erro ao salvar o registro: ', data);
                    }
                }
            });
        });
    </script>