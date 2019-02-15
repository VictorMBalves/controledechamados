<!DOCTYPE html>
<html lang="en">

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
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
  <!--Toastr notification-->
  <link href="../assets/css/toastr.css" rel="stylesheet"/>
  <link href="../assets/css/animate.css" rel="stylesheet"/>

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
            <h1 class="h3 mb-0 text-gray-800">Home</h1>
           	<div id="plantao"></div>
          </div>

			<!-- Content Row -->
			<div class="row animated fadeInRight">
				<!--Chamados pendentes-->
				<div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
					<?php include 'chamadospendentes.php';?>
				</div>
				<!--Chamados pendentes-->

				<!--Chamados AGENDADOS -->
				<div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
					<?php include 'chamadosagendados.php'; ?>
				</div>
				<!--Chamados AGENDADOS -->
				
				<!--Chamados ATRASADOS -->
				<div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
					<!-- HEADER -->
					<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">
						<div class="card border-left-warning shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-warning text-uppercase mb-1"><h6>ATRASADOS</h6></div>
										<div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
									</div>
									<div class="col-auto">
										<i class="far fa-clock fa-2x text-gray-300"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- HEADER -->

					<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">
						<div class="card border-left-warning shadow h-100 py-2">
							<div class="card-header">
								<div class="row no-gutters align-items-center">
									Germantech sistemas adminstrativos bla bla bla
								</div>
							</div>
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<small>
									Empresa não consegue realizar emissão
									</small>
								</div>
							</div>
							<div class="card-footer">
								<div class="row no-gutters align-items-center">
									<div class="col-6 col-sm-6 col-md-6 col-lg-6">
										<a href="#" class="btn btn-success btn-circle">
											<i class="fas fa-share"></i>
										</a>
										<a href="#" class="btn btn-info btn-circle">
											<i class="fas fa-search"></i>
										</a>
									</div>
									<div class="col-6 col-sm-6 col-md-6 col-lg-6 text-danger text-right">
										<small>
										<i class="far fa-clock"></i>
										5 min
										</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				<!--Chamados ENTRADO EM CONTATO -->
				</div>

				<!--Chamados EM ATENDIMENTO -->
				<div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
					<!-- HEADER -->
					<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">
						<div class="card border-left-primary shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><h6>EM ATENDIMENTO</h6></div>
										<div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
									</div>
									<div class="col-auto">
										<i class="far fa-check-circle fa-2x text-gray-300"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- HEADER -->

					<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">
						<div class="card border-left-primary shadow h-100 py-2">
							<div class="card-header">
								<div class="row no-gutters align-items-center">
									Germantech sistemas adminstrativos bla bla bla
								</div>
							</div>
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<small>
									Empresa não consegue realizar emissão de nota fiscal devera ser entrado em contato....
									</small>
								</div>
							</div>
							<div class="card-footer">
								<div class="row no-gutters align-items-center">
									<div class="col-6 col-sm-6 col-md-6 col-lg-6">
										<a href="#" class="btn btn-info btn-circle">
											<i class="fas fa-search"></i>
										</a>
									</div>
									<div class="col-6 col-sm-6 col-md-6 col-lg-6 text-danger text-right">
										<small>
										<i class="far fa-clock"></i>
										5 min
										</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				<!--Chamados EM ATENDIMENTO -->
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
	<div id="modalAgendamento">
	</div>

	<!-- Bootstrap core JavaScript-->
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <!-- <script src="../vendor/jquery/jquery.min.js"></script> -->
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
	<!-- <script src="../vendor/chart.js/Chart.min.js"></script> -->
	<script src="../assets/js/jquery.shortcuts.js"></script>
	<script src="../assets/js/toastr.min.js"></script>
	<script src="../datatables/datatables.min.js"></script>
	<script src="../datatables/responsive.min.js"></script>
	<script src="../datatables/rowReorder.min.js"></script>
  <script src="../assets/js/date.js"></script>
	<script src="../js/links.js"></script>
	<script src="../js/tabelas/home.js"></script>
</body>
</html>
