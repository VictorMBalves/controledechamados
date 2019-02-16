<?php
	include '../validacoes/verificaSessionFinan.php';
	require_once '../include/Database.class.php';
    $db = Database::conexao();
	$sql = $db->prepare('SELECT nome, nivel, disponivel FROM usuarios');
	$sql->execute();
	$result = $sql->fetchall(PDO::FETCH_ASSOC);
?>
<!Doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Controle de chamados German Tech">
	<meta name="author" content="Victor Alves">
	<link rel="shortcut icon" href="../imagem/favicon.ico" />
	<title>Chamados</title>

	<!-- Custom fonts for this template-->
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
	 rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
	<link href="../assets/css/jquery-ui.css" rel="stylesheet">
	<!--Toastr notification-->
	<link href="../assets/css/toastr.css" rel="stylesheet" />
	<link href="../assets/css/animate.css" rel="stylesheet" />
	<link href="../assets/css/jquery.flexdatalist.css" rel="stylesheet" />
</head>

<body>

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
							<h1 class="h3 mb-0 text-gray-800">Chamado em espera</h1>
							<div id="plantao"></div>
						</div>
						<div  class="card">
							<div class="card-body animated fadeInRight" style="background-color:#f4f4f4;">
								<div class="row"> 
									<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
										<label for="empresa-espera">Empresa solicitante:</label>
										<input id="empresa-espera" onblur="callApi(this)" name="empresa-espera" type="text" class="form-control flexdatalist">
									</div>
									<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
										<label for="enderecado">Atribuir para:</label>
										<select id="enderecado" name="enderecado" type="text" class="form-control">
											<option value=""></option>
											<?php 
												foreach ($result as $row) {
													if ($row["nivel"] != 1) {
														echo '<option>'.$row['nome'].'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
										<label for="contato">Contato:</label>
										<input name="contato" id="contato" type="text" class="form-control">
									</div>
									<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
										<label class="col-md-2 control-label" for="telefone">Telefone:</label>
										<input name="telefone" type="text" id="telefone" class="form-control" onkeypress="return SomenteNumero(event)">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
										<label for="versao">Versão</label>
										<input id="versao" name="versao" type="text" class="form-control">
									</div>
									<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
									<label class="col-md-2 control-label" for="sistema">Sistema:</label>
										<input id="sistema" name="sistema" type="text" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="descproblema">Descrição do problema:</label>
									<textarea name="descproblema" id="desc_problema" class="form-control"></textarea>
								</div>
								<!-- Button -->
								<div class="col-md-12 text-center">
									<?php include "../utilsPHP/statusDados.php";?>
									<button id="submit" class="btn btn-group-lg btn-primary">Salvar</button>
									<button id="cancel" class="btn btn-group-lg btn-warning">Cancelar</button>
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

		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>

		<div id="modalCadastro">
		</div>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<!-- <script src="../assets/js/jquery-1.8.3.min.js"></script>
		<script src="../assets/js/jquery-ui-1.9.2.custom.min.js"></script> -->
		<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- Core plugin JavaScript-->
		<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
		<!-- Custom scripts for all pages-->
		<script src="../assets/js/sb-admin-2.min.js"></script>
		<script src="../assets/js/jquery.flexdatalist.js"></script>										
		<script src="../assets/js/jquery.shortcuts.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../js/apiConsulta.js"></script>
		<script src="../js/links.js"></script>
		<script src="../js/cadChamadoEspera.js"></script>
	</body>

</html>