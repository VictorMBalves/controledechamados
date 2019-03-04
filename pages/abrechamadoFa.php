<?php
	include '../validacoes/verificaSession.php';
	require_once '../include/Database.class.php';
    $db = Database::conexao();
	$id=$_GET['id_chamado'];
	$sql = $db->prepare("SELECT * FROM chamado WHERE id_chamado = :id");
	$sql->bindParam(":id", $id, PDO::PARAM_INT);
	$sql->execute();
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	if($row['status'] == 'Finalizado'){
		echo '<h1>Chamado Nº'.$id.' já encerrado<h1>';
		return;
	}
	$linkPesquisa = "http://copel.gtech.site:8888?empresa=".$row['empresa']."&usuario=".$row['usuario'];

	$cnpj = $row['cnpj'];
	$empresa = $row['empresa'];

	$sqlChamados = $db->prepare("SELECT id_chamado, DATE_FORMAT(datainicio,'%d/%m/%Y %H:%i') as datainicio, descsolucao, descproblema, usu.nome  FROM chamado INNER JOIN usuarios usu ON usu.id = chamado.usuario_id WHERE (('$cnpj' <> '' AND cnpj = '$cnpj') OR ('$empresa' <> '' AND empresa = '$empresa')) AND status = 'Finalizado' ORDER BY id_chamado DESC LIMIT 3");
	$sqlChamados->execute();
	$ultimosChamados = $sqlChamados->fetchall(PDO::FETCH_ASSOC);
?>
<!Doctype html>
<html>
	<head>
		<title>Chamados</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Controle de chamados German Tech">
		<meta name="author" content="Victor Alves">
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link href="../assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
		<link href="../assets/css/toastr.css" rel="stylesheet" />
		<link href="../assets/css/animate.css" rel="stylesheet" />
		<link href="../assets/css/style.css" rel="stylesheet" />
		<link href="../assets/css/jquery.flexdatalist.css" rel="stylesheet" />
		<link href="../css/collapsed.css" rel="stylesheet" />
	</head>
	<body id="page-top">

		<!-- Page Wrapper -->
		<div id="wrapper">

			<!-- Sidebar -->
			<?php 
				include '../validacoes/verificaSession.php'; 
				include '../include/sidebar.php';
			?>
			<!-- End of Sidebar -->

			<!-- Content Wrapper -->
			<div id="content-wrapper" class="d-flex flex-column">

				<!-- Main Content -->
				<div id="content">

					<!-- Topbar -->
					<?php include '../include/topbar.php';?>
					<!-- End of Topbar -->

					<!-- Begin Page Content -->
					<div class="container-fluid">

						<!-- Page Heading -->
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Finalizar chamado Nº <?php echo $id;?> </h1>
							<div id="plantao"></div>
						</div>
						<div class="switch-version text-center" style="font-size:30px;" id="showUltimos" data-toggle="tooltip" data-placement="right" title="Últimos atendimentos">
							<i class="fas fa-clipboard-list"></i>
						</div>
						<!-- Card cadastro-->
						<div class="card" style="background-color:#f4f4f4;">
							<div class="card-body animated fadeInRight">
								<div class="row" id="row-main">
									<div class="form-horizontal col-md-12 hovered" id="contentForm">
										<input style="display:none;" name="id_chamado" id="id_chamado" value="<?php echo $id; ?>" />
										<input style="display:none;" name="cnpj" id="cnpj" value="<?php echo $row['cnpj']; ?>" />
										<div class="row">
											<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
												<label for="empresafin">Empresa solicitante:</label>
												<input value='<?php echo $row['empresa'];?>' id="empresafin" name="empresafin" type="text" class="form-control disabled" disabled>
											</div>
											<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
												<label for="contatofin">Contato:</label>
												<input value='<?php echo $row['contato'];?>' id="contatofin" name="contatofin" type="text" class="form-control">
											</div>
										</div>
										<div class="row">
											<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
												<label for="formacontatofin">Forma de contato:</label>
												<select name="formacontatofin" type="text" id="formaContatofin" class="form-control">
													<option>
														<?php echo $row['formacontato'];?>
													</option>
													<option></option>
													<option value="Cliente ligou">Cliente ligou
													</option>
													<option value="Ligado para o cliente">Ligado para o cliente
													</option>
													<option value="Whatsapp">Whatsapp
													</option>
													<option value="Team Viewer">Team Viewer
													</option>
													<option value="Skype">Skype
													</option>
												</select>
											</div>
											<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
												<label for="telefonefin">Telefone</label>
												<input value='<?php echo $row['telefone'];?>' id="telefonefin" data-mask="(999)9999-9999" name="telefonefin" type="text"  class="form-control label2" onkeypress="return SomenteNumero(event)" required="">
											</div>
										</div>
										<div class="row">
											<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
												<label for="versaofin">Versão:</label>
												<input type="text" id="versaofin" name="versaofin" class="form-control" required="" value="<?php echo $row['versao'] ?>">
											</div>
											<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
												<label for="sistemafin">Sistema:</label>
												<select name="sistemafin" type="text" id="sistemafin" class="form-control" required="">
													<option>
														<?php echo $row['sistema'];?>
													</option>
													<option></option>
													<option value="Manager">Manager
													</option>
													<option value="Light">Light
													</option>
													<option value="Gourmet">Gourmet
													</option>
													<option value="Fiscal">Fiscal
													</option>
													<option value="Folha">Folha
													</option>
													<option value="Emissor">Emissor
													</option>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
												<label for="backupfin">Backup:</label>
												<select id="backupfin" name="backupfin" class="form-control" required="">
													<?php 
															if ($row2['backup'] == 0) {
																echo "<option value='0'>Google drive não configurado</option>";
															} else {
																echo "<option value='1'>Google drive configurado</option>";
															}
														?>
													<option>
													</option>
													<option value="1">Google drive configurado
													</option>
													<option value="0">Google drive não configurado
													</option>
												</select>
											</div>
											<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
												<label for="categoriafin">Categoria:</label>
												<select name="categoriafin" id="categoriafin" type="text"
													class="form-control forma" required="">
													<option>
														<?php echo $row['categoria'];?>
													</option>
													<option></option>
													<option value="Erro">Erro
													</option>
													<option value="Duvida">Duvida
													</option>
													<option value="Atualização sistema">Atualização sistema
													</option>
													<option value="Sugestão de melhoria">Sugestão de melhoria
													</option>
													<option value="Retorno">Retorno</option>
													<option value="Outros">Outros
													</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="descproblemafin">Descrição do problema:</label>
											<textarea name="descproblemafin" id="descproblemafin" type="text" class="form-control label1" required=""><?php echo $row['descproblema'];?></textarea>
										</div>
										<div class="form-group">
											<label for="descsolucaofin">Solução:</label>
											<textarea name="descsolucaofin" id="descsolucaofin" type="text" class="form-control"></textarea>
										</div>
										<div class="text-center">
											<div class="input-group input-group-sm mb-3 col-12 col-sm-12 col-md-12 col-lg-12" style="right:0px;">
												<input type="text" id="linkPesquisa" class="form-control readonly" value="<?php echo $linkPesquisa; ?>" aria-label="Link pesquisa de satisfação" aria-describedby="inputGroup-sizing-sm" readonly>
												<div class="input-group-prepend">
													<button class="btn btn-outline-secondary" data-clipboard-target="#linkPesquisa" type="button" id="btnClipPesquisa"><i id="iconCopy" class="fas fa-copy"></i></button>
												</div>
											</div>
											<button id="criarRequest" name="criarRequest" class="btn btn-group-lg btn-danger" disabled><i class="fas fa-bug" style="-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i>&nbsp;Criar request</button>
											<button id="finalizar" name="finalizar" class="btn btn-group-lg btn-primary" disabled>Finalizar</button>
											<button id="agendar" name="agendar" class="btn btn-group-lg btn-success">Agendar</button>
											<button id="cancel" type="reset" name="cancelar" class="btn btn-group-lg btn-warning">Cancelar</button>
										</div>
									</div>
									<div class="col-md-4 collapsedRight animated fadeInRight" id="divLateral">
										<div class="d-sm-flex align-items-center justify-content-between mb-4">
											<h1 class="h3 mb-0 text-gray-800">Últimos chamados atendidos</h1>
										</div>
										<div style="max-height:600px;overflow:auto;">
										<?php
											if(empty($ultimosChamados)){
												echo '<small>Nenhum registro de atendimento finalizado para empresa.</small>';
											}else{
												foreach($ultimosChamados as $chamado){
												echo'<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">
														<div class="card border-left-info shadow h-100 py-2">
															<div class="card-body" onclick="abrirVisualizacao('.$chamado['id_chamado'].')" style="cursor: pointer;">
																<div class="row no-gutters align-items-center">
																	<div class="col mr-2">
																		<div class="text-xs font-weight-bold text-info text-uppercase mb-1">'.$chamado['datainicio'].'</div>
																		<div class="mb-0 font-weight-bold text-gray-800"><small><strong>Desc. problema:</strong> '.$chamado['descproblema'].'</small></div>
																		<div class="mb-0 font-weight-bold text-gray-800"><small><strong>Solução:</strong> '.$chamado['descsolucao'].'</small></div>
																		<div class="mb-0 font-weight-bold text-gray-800"><small><strong>Atendente responsável:</strong> '.$chamado['nome'].'</small></div>
																	</div>
																</div>
															</div>
														</div>
													</div>';
												}
											}
										?>
										</div>
									</div>
								</div>			
							</div>
						</div>
						<!--Fim Card cadastro-->
					</div>
					<!-- /.container-fluid -->
					
					<!-- Footer -->
					<?php include '../include/footer.php';?>
					<!-- End of Footer -->
					
				</div>
				<!-- End of Main Content -->
				
			</div>
			<!-- End of Content Wrapper -->
			<div id="modalCadastro">
			</div>
			<div id="modalConsulta">
			</div>
			<!--Modal agendamento-->
			<div class="modal fade" id="modalAgenda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Agendamento chamado Nº<?php echo $id;?></h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<input type="text" name="id" id="id" class="form-control" value="<?php echo $id; ?>" style="display:none;">
								<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
									<label for="dataAgenda">Data:</label>
									<input type="date" name="dataAgenda" id="dataAgenda" class="form-control">
								</div>
								<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
									<label class="col-md-2 control-label" for="horarioAgenda">Horario:</label>
									<input name="horarioAgenda" id="horarioAgenda" type="time" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label for="descproblemaAgenda">Descrição do problema:</label>
								<textarea name="descproblemaAgenda" id="descproblemaAgenda" type="text"
								class="form-control"><?php echo $row['descproblema'];?></textarea>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
							<button class="btn btn-primary" id="salvarAgendamento" type="button">Salvar</a>
						</div>
					</div>
				</div>
			</div>
			<!--Fim modal agendamento-->
		</div>
		<!-- End of Page Wrapper -->
		
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
		<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="../assets/jquery-easing/jquery.easing.min.js"></script>
		<script src="../assets/js/sb-admin-2.min.js"></script>
		<script src="../assets/js/jquery.flexdatalist.js"></script>
		<script src="../assets/js/jquery.shortcuts.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../assets/js/clipboard.min.js"></script>
		<script src="../js/links.js"></script>
		<script src="../js/finalizaChamadoFa.js"></script>
	</body>

</html>