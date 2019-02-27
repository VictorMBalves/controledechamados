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
				include '../validacoes/verificaSessionFinan.php'; 
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
							<h1 class="h3 mb-0 text-gray-800">Perfil</h1>
							<div id="plantao"></div>
						</div>
						<div  class="card" style="background-color:#f4f4f4;">
							<div class="card-body animated fadeInRight">
								<div class="row">
									<div class="col-12 col-4 col-sm-4 col-md-4 col-lg-4">
										<div class="col-12 text-center">
											<img class="img-profile rounded-circle" src="<?php echo 'https://www.gravatar.com/avatar/'.$email.'?s=150'?>" style="border:1px solid withe;" ><br/>
										</div>
										<div class="col-12 text-center">
											<span class="mr-2 d-none d-lg-inline text-gray-600 small"><h3><?php echo $_SESSION['UsuarioNome']?></h3></span>
										</div>
									</div>
									<div class="col-12 col-8 col-sm-8 col-md-8 col-lg-8">
										<div class="form-group">
											<label for="nome">Nome</label>
											<input name="nome" id="nome" type="text" value="<?php echo $_SESSION['UsuarioNome']?>" class="form-control">
										</div>
										<div class="form-group">
											<label for="senha">Senha</label>
											<input name="senha" id="senha" type="password" class="form-control">
										</div>
										<div class="form-group">
											<label for="senhaconfirm">Senha confirmação</label>
											<input name="senhaconfirm" id="senhaconfirm" type="password" class="form-control">
										</div>
										<div class="form-group text-center">
											<button id="submit" name="singlebutton" class="btn btn-group-lg btn-primary">Alterar</button>
										</div>
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

		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>

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
		<script src="../js/alterSenha.js"></script>
	</body>

</html>
