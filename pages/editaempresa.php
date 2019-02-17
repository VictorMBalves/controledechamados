<?php
	include '../validacoes/verificaSessionFinan.php';
	require_once '../include/Database.class.php';
    $db = Database::conexao();
	$id=$_GET['id_empresa'];
	$sql = $db->prepare("SELECT * FROM empresa WHERE id_empresa=$id");
	$sql->execute();
	$row = $sql->fetch(PDO::FETCH_ASSOC);
?>
<!Doctype html>
<html>
	<head>
		<title>Chamados</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Controle de chamados German Tech">
		<meta name="author" content="Victor Alves">
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
		<link href="../assets/css/jquery-ui.css" rel="stylesheet">
		<link href="../assets/css/toastr.css" rel="stylesheet"/>
		<link href="../assets/css/animate.css" rel="stylesheet"/>
		<link href="../assets/css/jquery.flexdatalist.css" rel="stylesheet" />
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
						<h1 class="h3 mb-0 text-gray-800">Editar chamado Nº <?php echo $id;?> </h1>
							<div id="plantao"></div>
						</div>

						<div  class="card" style="background-color:#f4f4f4;">
							<div class="card-body animated fadeInRight" >
								<div class="text-right">
									<div class="form-group">
										<button id="delete" type='reset' class='btn btn-danger' data-toggle='tooltip' data-placement='left' title='Excluir cadastro!'><i class="far fa-trash-alt"></i></button>
									</div>
								</div>
								<div class="form-horizontal">
									<input style="display:none;" id="id" name='id_empresa' value='<?php echo $id; ?>'/>
									<div class="row">
										<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
											<label for="empresaEdit">Razão Social:</label>
											<input value='<?php echo $row['nome'];?>' id="empresaEdit" name="empresaEdit" type="text" class="text-uppercase form-control">
										</div>
										<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
											<label for="cnpjEdit">CNPJ:</label>
											<input value='<?php echo $row['cnpj'];?>' id="cnpjEdit" name="cnpjEdit" data-mask="99.999.999/9999-99" type="text" class="form-control">
										</div>
									</div>
									<div class="row">
										<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
											<label for="telefoneEdit">Telefone:</label>
											<input value='<?php echo $row['telefone'];?>' id="telefoneEdit" name="telefoneEdit" type="text" class="form-control">
										</div>
										<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
											<label for="celularEdit">Celular:</label>
											<input value='<?php echo $row['celular'];?>' id="celularEdit" name="celularEdit" type="text" class="form-control">
										</div>
									</div>
									<div class="row">
										<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
											<label for="situacaoEdit">Situação:</label>
											<select name="situacaoEdit" id="situacaoEdit" class="form-control ">
												<option>
													<?php echo $row['situacao'];?>
												</option>
												<option>
												</option>
												<option value="ATIVO">Ativo
												</option>
												<option value="BLOQUEADO">Bloqueado
												</option>
												<option value="DESISTENTE">Desistente
												</option>
											</select>
										</div>
										<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
										<label for="backupEdit">Backup:</label>
											<select id="backupEdit" name="backupEdit" class="form-control  ">
													<?php 
														if ($row['backup'] == 0) {
															echo'<option value="0">Google drive não configurado</option>';
														} else {
															echo'<option value="1">Google drive configurado</option>';
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
									</div>
									<div class="row">
										<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
											<label for="sistemaEdit">Sistema:</label>
											<input value='<?php echo $row['sistema'];?>' name="sistemaEdit" type="text" class="form-control" readonly="">
										</div>
										<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
										<label for="versaoEdit">Versão:</label>
											<input value='<?php echo $row['versao'];?>' name="versaoEdit" type="text" class="form-control" readonly="">
										</div>
									</div>
									<div class="collapse" id="abrirModulos">
										<div class="form-group">
											<div id="modulos">
											</div>
										</div>
									</div>
									<div class="form-group text-center">
										<button id="verModulo" name="verModulos" class="btn btn-info" type="button" data-toggle="collapse" data-target="#abrirModulos"
											aria-expanded="false" aria-controls="collapseExample" data-placement='left' title='Visualizar módulos'>
											<i class="far fa-eye"></i>&nbspVisualizar módulos</button>
										<button type="submit" id="submit" name="singlebutton" class="btn btn-group-lg btn-primary">Alterar</button>
										<button type="reset" id="cancel" class="btn btn-group-lg btn-warning">Cancelar</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->

				</div>
				<!-- End of Main Content -->

				<!-- Footer -->
				<?php include '../include/footer.php';?>
				<!-- End of Footer -->

			</div>
			<!-- End of Content Wrapper -->

		</div>
		<!-- End of Page Wrapper -->
		<div id="modalCadastro">
		</div>

		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<!-- <script src="../vendor/jquery/jquery.min.js"></script> -->
		<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- Core plugin JavaScript-->
		<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
		<!-- Custom scripts for all pages-->
		<script src="../assets/js/sb-admin-2.min.js"></script>
		<script src="../assets/js/jquery.flexdatalist.js"></script>	
		<!-- <script src="../vendor/chart.js/Chart.min.js"></script> -->
		<script src="../assets/js/jquery.shortcuts.js"></script>
		<script src="../assets/js/jquery.maskedinput.min.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../js/links.js"></script>
		<script src="../js/editaEmpresa.js"></script>
		<script src="../js/apiConsulta.js"></script>
	</body>
</html>
