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
		<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
		<link href="../datatables/datatables.min.css" rel="stylesheet">
    	<link href="../datatables/responsive.dataTables.min.css" rel="stylesheet">
    	<link href="../datatables/rowReorder.dataTables.min.css" rel="stylesheet">
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
							<h1 class="h3 mb-0 text-gray-800"><?php echo $_SESSION['UsuarioNome']?>, gerencie seus chamados</h1>
							<div id="plantao"></div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#home" class="link"><i class="glyphicon glyphicon-edit"></i>&nbsp&nbspNovo usuário</a></li>
									<li><a data-toggle="tab" href="#home1" class="link"><i class="glyphicon glyphicon-list"></i>&nbsp&nbspLista de usuários</a></li>
								</ul>

								<div class="tab-content">
									<div id="home" class="tab-pane fade in active">
										<br/>
										<div class="form-horizontal">
											<div id="nome-div" class="form-group">
												<label class="col-sm-2 control-label" for="nome">Nome:</label>
												<div class="col-sm-10">
													<input name="nome" id="nome" type="text" class="form-control" required="">
												</div>
											</div>
											<div id="usuario-div" class="form-group">
												<label class="col-sm-2 control-label" for="usuario">Login:</label>
												<div class="col-sm-10">
													<input name="usuario" type="text" id="usuario" class="form-control" required="">
												</div>
											</div>
											<div id="email-div" class="form-group">
												<label class="col-sm-2 control-label" for="email">E-mail</label>
												<div class="col-sm-10">
													<input name="email" id="email" type="email" class="form-control" required="">
												</div>
											</div>
											<div id="senha-div" class="form-group">
												<label class="col-sm-2 control-label" for="senha">Senha:</label>
												<div class="col-sm-10">
													<input name="senha" id="senha" type="password" class="form-control label1" required="">
												</div>
											</div>
											<div id="senhaconfirm-div" class="form-group">
												<label class="col-sm-2 control-label" for="senha">Confir. Senha:</label>
												<div class="col-sm-10">
													<input name="senhaconfirm" id="senhaconfirm" type="password" class="form-control label1" required="">
												</div>
											</div>
											<div id="nivel-div" class="form-group">
												<label class="col-sm-2 control-label" for="nivel">Nivel</label>
												<div class="col-sm-10">
													<select name="nivel" id="nivel" class="form-control" required="">
														<option value="3">Suporte Avançado
														</option>
														<option value="2">Help-Desk
														</option>
														<option value="1">Financeiro
														</option>
														<option value="4">Acompanhamento
														</option>
													</select>
												</div>
											</div>
											<!-- Button -->
											<div class="col-md-12 text-center">
												<button type="submit" id="submit" name="singlebutton" class="btn btn-group-lg btn-primary">Cadastrar</button>
												<button type="reset" id="cancel" class="btn btn-group-lg btn-warning">Cancelar</button>
											</div>
										</div>
									</div>

									<div id="home1" class="tab-pane fade">
										<br/>
										<table id="tabela" class="table table-responsive table-hover">
											<thead>
												<tr>
													<th>ID</th>
													<th>Nome</th>
													<th>Login</th>
													<th>Email</th>
													<th width="100" class="text-center"><img src="../imagem/acao.png"></th>
												</tr>
											</thead>
											<tbody id ="tbody">
											</tbody> 
										</table>
										<div class="col-sm-12 text-center" id="loading"></div>
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
		<script src="../js/cadUsuario.js"></script>
	</body>
</html>