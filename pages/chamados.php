<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Chamados</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Controle de chamados German Tech">
		<meta name="author" content="Victor Alves">
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
		<link href="../datatables/datatables.min.css" rel="stylesheet">
    	<link href="../datatables/responsive.dataTables.min.css" rel="stylesheet">
    	<link href="../datatables/rowReorder.dataTables.min.css" rel="stylesheet">
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
					<h1 class="h3 mb-0 text-gray-800">Chamados</h1>
					<div id="plantao"></div>
				</div>
				<div  class="card" style="margin:15px;padding:5px; background-color:#f4f4f4;">
					<div class="card-header" style="border-bottom:none;"data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
						Filtros	
					</div>
					<div class="collapse" id="collapseExample">
						<div class="card-body animated fadeInRight">
							<?php include '../filtros/filtroChamados.php';?> 
						</div>
					</div>
				</div>

					<!-- Content Row -->
					<div class="animated fadeInRight">
						<table id="tabela" class="table table-responsive table-hover" style="width:100%">
							<thead>
								<tr>
									<th>Status</th>
									<th width="100px">Data</th>
									<th>Responsável</th>
									<th>Nº</th>
									<th>Empresa</th>
									<th>Contato</th>
									<th>Telefone</th>
									<th width="130" class="text-center"><img src="../imagem/acao.png"></th>
								</tr>
							<tbody id ="tbody">
							</tbody> 
							<div class="col-sm-12 text-center" id="loading"></div>
						</table>
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

		<div id="modalConsulta">
		</div>
		<div id="modalCadastro">
		</div>
		
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
		<script src="../assets/js/sb-admin-2.min.js"></script>
		<script src="../assets/js/jquery.shortcuts.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../js/links.js"></script>
		<script src="../datatables/jquery.dataTables.min.js"></script>
		<script src="../datatables/dataTables.bootstrap4.min.js"></script>
		<script src="../datatables/responsive.min.js"></script>
		<script src="../datatables/rowReorder.min.js"></script>
		<script src="../assets/js/jquery.flexdatalist.js"></script>	
		<script src="../js/tabelas/chamados.js"></script>
	</body>
</html>