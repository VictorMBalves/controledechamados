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
							<h1 class="h3 mb-0 text-gray-800">Plantão</h1>
							<div id="plantao"></div>
						</div>
						<div class="row">
            				<div class="col-md-12">
								<ul id="tabsJustified" class="nav nav-tabs">
									<li class="nav-item">
										<a class="nav-link active" id="cad-tab" data-toggle="tab" href="#cad" role="tab" aria-controls="cad" aria-selected="true"><i class="far fa-hospital"></i>&nbsp&nbspNovo plantão decorrido</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="plantoes-tab" data-toggle="tab" href="#plantoes" role="tab" aria-controls="plantoes" aria-selected="false"><i class="fas fa-list-ul"></i>&nbsp&nbspPlantões</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="sobreaviso-tab" data-toggle="tab" href="#sobreaviso" role="tab" aria-controls="sobreaviso" aria-selected="false"><i class="far fa-calendar-alt"></i>&nbsp&nbspSobreaviso</a>
									</li>
									<?php
										if($_SESSION['UsuarioNivel'] == 3){
											echo '<li class="nav-item">
													<a class="nav-link" id="escala-tab" data-toggle="tab" href="#escala" role="tab" aria-controls="escala" aria-selected="false"><i class="fas fa-calendar-alt"></i>&nbsp&nbspEscala sobreaviso</a>
												</li>';
										}
									?>
								</ul>
								<div id="tabsJustifiedContent" class="tab-content card" style="margin-bottom:15px;">
									<!-- PLANTAO DECORRIDO -->
									<div class="tab-pane fade show active card-body animated fadeInRight" id="cad" role="tabpanel" aria-labelledby="cad-tab">
										<?php include 'cad_plantao.php';?>
									</div>
									
									<div class="tab-pane fade animated fadeInRight" id="plantoes" role="tabpanel" aria-labelledby="plantoes-tab">
										<div class="container-fluid" style="padding: .75rem;">
											<table id="tabela" class="table table-hover" style="width:100%;">
												<thead>
													<tr>
														<th>Status</th>
														<th>Data</th>
														<th>Responsável</th>
														<th>Nº Chamado</th>
														<th>Empresa</th>
														<th>Contato</th>
														<th>Telefone</th>
														<th width="100" class="text-center"><img src="../imagem/acao.png"></th>
													</tr>
												<tbody id ="tbody">
												</tbody> 
											</table>
											<div class="col-sm-12 text-center" id="loading"></div>
										</div>
									</div>

									<?php 
										if (array_key_exists('data', $_POST)) {
											$data=$_POST['data'];
											$data2=$_POST['data1'];
										} else {
											$data = date('Y-m').'-01';
											$data2 = date('Y-m-t');
										}
									?>

									<div class="tab-pane fade animated fadeInRight" id="sobreaviso" role="tabpanel" aria-labelledby="sobreaviso-tab">
										<form class="container" style="padding:.75rem;" method="POST" action="../utilsPHP/gerarReportSobreaviso.php">
											<div class="form-group">
												<label for="data1">De:</label>
												<input type="date" value="<?php echo $data;?>" name="data1" class="form-control">
											</div>
											<div class="form-group">
												<label for="data2">Até:</label>
												<input style="padding-right:15px;" type="date" value="<?php echo $data2;?>" name="data2" class="form-control">
											</div>
											<div class="form-group text-center">
												<button id="gerarSobreaviso" name="singlebutton" class="btn btn-group-lg btn-primary"><i class="fas fa-print"></i> Gerar</button>
											</div>
										</form> 
									</div>
									<?php
										if($_SESSION['UsuarioNivel'] == 3){
											echo '<div class="tab-pane fade animated fadeInRight" id="escala" role="tabpanel" aria-labelledby="escala-tab">';
											echo '<div class="container-fluid" style="padding-right: .75rem;padding-left: .75rem; padding-top: .75rem;padding-bottom: .75rem;">';
											include 'escalamensalpage.php';
											echo '</div>';
											echo '</div>';
										}
									?>
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
		<script src="../assets/js/jquery.shortcuts.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../js/links.js"></script>
		<script src="../datatables/jquery.dataTables.min.js"></script>
		<script src="../datatables/dataTables.bootstrap4.min.js"></script>
		<script src="../datatables/responsive.min.js"></script>
		<script src="../datatables/rowReorder.min.js"></script>
		<script src="../assets/js/jquery.flexdatalist.js"></script>	
		<script src="../js/md5.js"></script>
		<script src="../js/escalamensal.js"></script>
		<script src="../js/tabelas/plantao.js"></script>
		<script src="../js/cadPlantao.js"></script>

	</body>
</html>