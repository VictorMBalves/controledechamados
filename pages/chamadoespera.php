<?php
	include '../validacoes/verificaSessionFinan.php';
	require_once '../include/Database.class.php';
    $db = Database::conexao();
	$sql = $db->prepare('SELECT nome, nivel, disponivel FROM usuarios WHERE nivel in(3,2)');
	$sql->execute();
	$result = $sql->fetchall(PDO::FETCH_ASSOC);
?>
<!Doctype html>
<html>

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
						<div  class="card" style="background-color:#f4f4f4;">
							<div class="card-body animated fadeInRight">
								<div class="row"> 
									<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
										<label for="empresaEspera">Empresa solicitante:</label>
										<input name="empresaEspera" type="text" id="empresaEspera" class="form-control flexdatalist">
										<div id="empresaBloqueada" class="text-danger hidden"><small>Empresa bloqueada</small></div>
									</div>
									<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
										<label for="enderecado">Atribuir para:</label>
										<select id="enderecado" name="enderecado" type="text" class="form-control">
											<option value=""></option>
											<?php 
												foreach ($result as $row) {
													echo '<option>'.$row['nome'].'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
										<label for="contatoEspera">Contato:</label>
										<input name="contatoEspera" id="contatoEspera" type="text" class="form-control">
									</div>
									<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
										<label for="telefoneEspera">Telefone:</label>
										<input name="telefoneEspera" type="text" id="telefoneEspera" class="form-control" onkeypress="return SomenteNumero(event)">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
										<label for="versaoEspera">Versão</label>
										<input id="versaoEspera" name="versaoEspera" type="text" class="form-control">
									</div>
									<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
									<label for="sistemaEspera">Sistema:</label>
										<input id="sistemaEspera" name="sistemaEspera" type="text" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for="descproblema">Descrição do problema:</label>
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
		<?php  if($_SESSION['UsuarioNivel'] != 1 && $_SESSION['UsuarioNivel'] != 4) { 
			echo '<div id="modalCadastro">
					</div>';
		}?>
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
		<script src="../js/cadChamadoEspera.js"></script>
	</body>

</html>