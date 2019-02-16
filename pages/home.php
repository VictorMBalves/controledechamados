<!DOCTYPE html>
<html lang="en">

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
            <h1 class="h3 mb-0 text-gray-800">Home</h1>
           	<div id="plantao"></div>
          </div>

			<!-- Content Row -->
			<div class="row animated fadeInRight">
				<!--Chamados pendentes-->
				<div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
					<div id="pendentes"></div>
					<?php //include 'chamadospendentes.php';?>
				</div>
				<!--Chamados pendentes-->

				<!--Chamados AGENDADOS -->
				<div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
					<div id="agendados"></div>
					<?php //include 'chamadosagendados.php'; ?>
				</div>
				<!--Chamados AGENDADOS -->
				
				<!--Chamados ATRASADOS -->
				<div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
					<div id="atrasados"></div>
					<?php //include 'chamadosatrasados.php'; ?>
				<!--Chamados ATRASADOS-->
				</div>

				<!--Chamados EM ATENDIMENTO -->
				<div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
					<div id="andamento"></div>
					<?php //include 'chamadosandamento.php'; ?>
				<!--Chamados EM ATENDIMENTO -->
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
	<div id="modalAgendamento">
	</div>

	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <!-- <script src="../assets/js/jquery-1.8.3.min.js"></script> -->
		<!-- <script src="../assets/js/jquery-ui-1.9.2.custom.min.js"></script> -->
		<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="../assets/js/sb-admin-2.min.js"></script>
  <script src="../assets/js/jquery.flexdatalist.js"></script>	
  <!-- Page level plugins -->
	<!-- <script src="../vendor/chart.js/Chart.min.js"></script> -->
	<script src="../assets/js/jquery.shortcuts.js"></script>
	<script src="../assets/js/toastr.min.js"></script>
  <script src="../assets/js/date.js"></script>
	<script src="../js/links.js"></script>
	<script src="../js/tabelas/home.js"></script>
</body>
</html>
