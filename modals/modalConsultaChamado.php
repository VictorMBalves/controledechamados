<?php
    include '../validacoes/verificaSession.php';
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $id=$_GET['id_chamado'];
    $sql = $db->prepare("SELECT 
                                cha.id_chamado,
								cha.empresa,
								cha.contato,
								cha.formacontato,
								cha.versao,
								cha.categoria_id,
                                cha.categoria,
								cha.telefone,
								cha.sistema,
								cha.descproblema,
                                cha.descsolucao,
								usu.nome AS usuario, 
                                DATE_FORMAT(cha.datainicio,'%d/%m/%Y %H:%i') as datainicio, 
                                DATE_FORMAT(cha.datafinal,'%d/%m/%Y %H:%i') as datafinal
                            FROM chamado cha 
                            INNER JOIN usuarios usu ON usu.id = cha.usuario_id WHERE cha.id_chamado = :id");
    $sql->execute(array(
		":id" => $id
	));
    $chamado = $sql->fetch(PDO::FETCH_ASSOC);
    $idCategorias = $chamado['categoria_id'];
    $categorias = [];
    if($idCategorias != null){
        $sql = $db->prepare("SELECT * FROM categoria WHERE id in ($idCategorias)");
        $sql->execute();
        $categorias = $sql->fetchall(PDO::FETCH_ASSOC);
    }
    $linkRequest = "http://request.gtech.site/requests/new?request[description]=".$chamado['descproblema']."&request[requester_cnpj]=".$chamado['cnpj']."&request[requester_name]=".$chamado['cnpj']." - ".$chamado['empresa'];
?>
<link href="../assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<div class="modal" tabindex="-1" role="dialog" id="modalCon">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4 >Consulta Chamado Nº <?php echo $id ?></h4>
                        <div class="row m-1" data-toggle="tooltip" data-placement="bottom" title="Categorias do chamado">
                            <?php
                                foreach($categorias as $categoria){
                                    $style = "";
                                    $icon = "";
                                    switch($categoria['categoria']){
                                        case 'ERROS':
                                            $style = "badge-danger";
                                            $icon = "<i class='fas fa-bug'></i>";
                                            break;
                                        case 'DÚVIDAS':
                                            $style = "badge-warning";
                                            $icon = "<i class='fas fa-question'></i>";
                                            break;
                                        default:
                                            $style = "badge-info";
                                            $icon = "<i class='fas fa-cubes'></i>";
                                            break;
                                    }
                                    echo '<span class="badge '.$style.' m-1 text-uppercase">'.$icon.' '.$categoria['descricao'].'</span>';
                                }
                                if($chamado['categoria'])
                                    echo '<span class="badge badge-info m-1 text-uppercase">'.$icon.' '.$chamado['categoria'].'</span>';
                            ?>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="empresa">Empresa solicitante:</label>
                            <input value='<?php echo $chamado['empresa'];?>'name="empresa" type="text" disabled class="form-control disabled" required/>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
                                <label for="contato">Contato:</label>
                                <input value='<?php echo $chamado['contato'];?>' id="nome" name="contato" type="text" disabled class="form-control disabled" required/>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
                                <label for="responsavel">Responsável:</label>
                                <input class="form-control label1 disabled" name="responsavel" disabled value='<?php echo $chamado['usuario']?>'>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
                            <label for="formacontato">Forma de contato:</label>
                                <input value="<?php echo $chamado['formacontato'];?>" name="formacontato" type="text" class="form-control disabled" disabled>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
                                <label for="versao">Versão:</label>
                                <input type="text" name="versao" class="form-control disabled" value="<?php echo $chamado['versao']?>" disabled>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
                                <label for="cep">Telefone:</label>
                                <input value='<?php echo $chamado['telefone'];?>' disabled name="telefone" type="text" class="form-control disabled" onkeypress="return SomenteNumero(event)">
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
                                <label for="sistema">Sistema:</label>
                                <input value="<?php  echo $chamado['sistema'];?>" name="sistema" type="text" class="form-control  disabled" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="datainicio">Data inicio: </label>
                                <input name="datainicio" class="form-control disabled" disabled value='<?php echo $chamado['datainicio']?>'>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="datafinal">Data término:</label>
                                <?php 
                                    if($_SESSION['UsuarioNivel'] == 3 && $chamado['datafinal'] != null){
                                        echo '<input class="form-control" name="datafinalchamadoconsulta" id="datafinalchamadoconsulta" value="'.$chamado['datafinal'].'">';
                                    }else{
                                        echo '<input class="form-control disabled" disabled name="datafinalchamadoconsulta" id="datafinalchamadoconsulta" value="'.$chamado['datafinal'].'">';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desproblema">Descrição do problema:</label>
                            <textarea name="descproblema" class="form-control disabled" disabled><?php echo $chamado['descproblema'];?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="descsolucao">Solução:</label>
                            <textarea name="descsolucao" class="form-control disabled" disabled><?php echo $chamado['descsolucao'];?></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-center">
                        <?php
                            if($row['status'] == "Finalizado")
                                echo '<a href="'.$linkRequest.'" target="_blank" id="criarRequest" name="criarRequest" class="btn btn-group-lg btn-danger"><i class="fas fa-bug" style="-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i>&nbsp;Criar request</a>';
                        ?>
                        <a id="showTimeLine" name="showTimeLine" class="btn btn-group-lg btn-info" href="timeline=<?php echo $id;?>"><i class="fas fa-stream m-1"></i>Timeline</a>
                        <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary" data-dismiss="modal">Retornar</button>
                        <?php 
                            if($_SESSION['UsuarioNivel'] == 3){
                                echo '<button id="btnSalvarAlteracaoChamado" name="btnSalvarAlteracaoChamado" class="btn btn-group-lg btn-info">Salvar</button>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>
    <script> 
        dataFinalChamadoAlteracao = $("#datafinalchamadoconsulta");
        chamadoId = <?php echo $id;?>;
        $(function() {
            $('#datafinalchamadoconsulta').datetimepicker({
                icons: {
                    time: 'fas fa-clock'
                },
                format: 'DD/MM/YYYY HH:mm'
            });

            $('#btnSalvarAlteracaoChamado').on('click', function(){
                $("#btnSalvarAlteracaoChamado").addClass(' disabled ');
                $("#btnSalvarAlteracaoChamado").html('<img src="../imagem/ajax-loader.gif">');
                validar();
                return null;
            })
        });

        function validar() {
            errosEspera = [];
            if (isEmpty(dataFinalChamadoAlteracao.val()))
                errosEspera.push(dataFinalChamadoAlteracao.selector);
            if(!moment(dataFinalChamadoAlteracao.val(), "DD/MM/YYYY HH:mm").isValid()){
                notificationWarningOne("Preencha os campos obrigatórios!");
                return null;
            }
            
            if (isEmpty(errosEspera)) {
                enviarDadosCadastroChamadoEspera();
            } else {
                $("#btnSalvarAlteracaoChamado").removeClass("disabled");
                $("#btnSalvarAlteracaoChamado").html("Salvar");
                for (i = 0; i < errosEspera.length; i++) {
                    if (!$(errosEspera[i]).hasClass("vazio")) {
                        $(errosEspera[i]).addClass("is-invalid");
                    }
                }
                notificationWarningOne("Preencha os campos obrigatórios!");
            }
            return null;
        }  
        
        function enviarDadosCadastroChamadoEspera() {
            $.ajax({
                type: "POST",
                url: "../inserts/alterarChamadoFinalizado.php",
                data: carregaDadosAlteracao(),
                success: function(data) {
                    data = data.trim();
                    if (data == "success") {
                        notificationSuccessLink('Registro salvo', 'Chamado alterado com sucesso!', '../pages/chamados');
                        location.href = location.href;
                    } else {
                        notificationError('Ocorreu um erro ao salvar o registro: ', data);
                        $("#btnSalvarAlteracaoChamado").removeClass(' disabled ');
                        $("#btnSalvarAlteracaoChamado").html('Salvar');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error: ' + textStatus + ': ' + errorThrown);
                }
            });
        }

        function carregaDadosAlteracao() {
            var data = [];
            data.push({ name: 'datafinal', value: dataFinalChamadoAlteracao.val() });
            data.push({ name: 'chamado_id', value: chamadoId });
            data.push({name: 'datafinal', value: moment(dataFinalChamadoAlteracao.val(), "DD/MM/YYYY HH:mm").format("YYYY-MM-DD HH:mm")});    
            return data;
        }
    </script>