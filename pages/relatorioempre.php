<?php
	include '../validacoes/verificaSession.php';
	if (array_key_exists('data', $_POST)) {
		$data = $_POST['data'];
		$data2 = $_POST['data1'];
	} else {
		$data = date('Y-m') . '-01';
		$data2 = date('Y-m-t');
	}
?>
<!doctype html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Chamados</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Controle de chamados German Tech">
		<meta name="author" content="Victor Alves">
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link href="../assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
		<link href="../assets/css/jquery-ui.css" rel="stylesheet">
		<link href="../assets/css/toastr.css" rel="stylesheet"/>
		<link href="../assets/css/animate.css" rel="stylesheet"/>
<link href="../assets/css/style.css" rel="stylesheet"/>
		<link href="../assets/css/jquery.flexdatalist.css" rel="stylesheet" />
	</head>
	<body id="page-top">
		<!-- Page Wrapper -->
		<div id="wrapper">

				<!-- Sidebar -->
				<?php 
					include '../validacoes/verificaSession.php'; 
					include '../include/sidebar.php';
					if (array_key_exists('data', $_POST)) {
						$data = $_POST['data'];
						$data2 = $_POST['data1'];
					} else {
						$data = date('Y-m') . '-01';
						$data2 = date('Y-m-t');
					}
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
							<h1 class="h3 mb-0 text-gray-800">Chamados por empresa</h1>
							<div id="plantao"></div>
						</div>
						<!-- Content Row -->
						<div id="chamados" class="row animated fadeInRight">

							<div  class="card" style="margin:15px;padding:5px; background-color:#f4f4f4;">
								<div class="card-header" style="border-bottom:none;"data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
									Filtros	
								</div>
								<div class="collapse" id="collapseExample">
									<div class="card-body animated fadeInRight">
										<form method="POST" action="relatorioempre" class="text-center">
											<div class="form-group">
												<label for="data">De:</label>
												<input type="date" value="<?php echo $data; ?>" name="data" class="form-control">
											</div>
											<div class="form-group">
												<label for="data1">Até:</label>
												<input type="date" value="<?php echo $data2; ?>" name="data1" class="form-control">
											</div>
											<div class="form-group">
												<label for="limite">Numero de Registros:</label>
												<input type="number" value="10" name="limite" class="form-control">
											</div>
											<div class="form-group">
												<button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Buscar</button>
											</div>
										</form>
									</div>
								</div>
							</div>

							<div class="container-fluid animated fadeInRight">
								<?php
									require_once '../include/Database.class.php';
									$db = Database::conexao();

									if (array_key_exists('data', $_POST)) {
										$data = $_POST['data'];
										$data2 = $_POST['data1'];
										$limite = $_POST['limite'];
									} else {
										$data = time('Y-m-d');
										$data2 = time('Y-m-d');
										$limite = '10';
									}

									if (array_key_exists('data', $_POST)) {
										$data = $_POST['data'];
										$data2 = $_POST['data1'];
										$limite = $_POST['limite'];
										echo '<div class="table-responsive table-hover">';
										echo '<table class="table table-striped text-center">';
										echo '<thead>';
										echo '<tr class="text-center">';
										echo '<th class="text-center">Nº de Chamados</th>';
										echo '<th class="text-center">Empresa</th>';
										echo '</tr>';
										echo '</thead>';

										echo '<tbody>';
										$query = $db->prepare("SELECT COUNT(empresa), empresa FROM chamado WHERE date(datainicio) BETWEEN '$data' and '$data2' GROUP BY empresa ORDER BY COUNT(empresa) DESC LIMIT $limite");
										$query->execute();
										$result = $query->fetchAll(PDO::FETCH_ASSOC);
										foreach ($result as $row) {
											echo '<tr>';
											echo '<td >' . $row['COUNT(empresa)'] . '</td>';
											echo '<td>' . $row['empresa'] . '</td>';
											echo '</tr>';
										}
										echo '</tbody>';
										echo '</table>';
										echo '</div>';
									}
								?>
							</div>
						</div>
						<!--/content Row-->
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

		<div id="modalConsulta">
		</div>
		<div id="modalCadastro">
		</div>

        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/jquery-easing/jquery.easing.min.js"></script>
        <script src="../assets/js/sb-admin-2.min.js"></script>
        <script src="../assets/js/jquery.flexdatalist.js"></script>	
        <script src="../assets/js/jquery.shortcuts.js"></script>
        <script src="../assets/js/toastr.min.js"></script>
        <script src="../assets/js/date.js"></script>
        <script src="../js/links.js"></script>
		<script>
            $("#liRelatorio").addClass("active")
        </script>
	</body>
</html>
