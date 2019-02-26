<?php
include '../validacoes/verificaSessionAdmin.php';
require_once '../include/Database.class.php';
$db = Database::conexao();
$id = $_GET['id'];
$sql = $db->prepare("SELECT * FROM usuarios WHERE id=$id");
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);
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
		<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
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
							<h1 class="h3 mb-0 text-gray-800">Editar cadastro de usuário</h1>
							<div id="plantao"></div>
						</div>
						<div  class="card" style="background-color:#f4f4f4;">
							<div class="card-body animated fadeInRight">
							<div class="container-fluid">
								<input style="display:none;" id="id" name='id' value='<?php echo $id; ?>' readonly/>
								<div class="form-group">
									<label for="nome">Nome:</label>
									<input id="nome" name="nome" type="text" class="form-control label1" value="<?php echo $row['nome']?>">
								</div>
								<div class="form-group">
									<label for="usuario">Login:</label>
									<input name="usuario" id="usuario" type="text" class="form-control" value="<?php echo $row['usuario']?>">
								</div>
								<div class="form-group">
									<label for="usuario">E-mail</label>
									<input name="email" id="email" type="email" class="form-control label1" value="<?php echo $row['email']?>">
								</div>
								<div class="form-group">
									<label for="senha">Senha:</label>
									<input name="senha" type="password" id="senha" class="form-control" >
								</div>
								<div class="form-group">
									<label for="senha">Confir. Senha:</label>
									<input name="senhaconfirm" id="senhaconfirm" type="password" class="form-control label1" >
								</div>
								<div class="form-group">
									<label for="nivel">Nivel</label>
									<select name="nivel" id="nivel" class="form-control label1" >
										<?php echo '<option class="success" value="'.$row['nivel'].'">';
												if($row['nivel'] == 1)
													echo 'Financeiro';
												else if($row['nivel'] == 2)
													echo 'Help-Desk';
												else if($row['nivel'] == 3)
													echo 'Suporte Avançado';
												else
													echo 'Acompanhamento';
											echo'</option>'?>
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
								<div  class="form-group">
									<label for="">Enviar notificação por e-mail</label>
									<select name="enviarEmail" id="enviarEmail" class="form-control" required="">
										<?php if($row['enviarEmail']){
												echo '<option value="1">Sim
												</option>';
										}else{
											echo' <option value="0">Não
										</option>';
										}?>
										<option value="1">Sim
										</option>
										<option value="0">Não
										</option>
									</select>
								</div>
								<div class="col-md-12 text-center">
									<button type="submit" id="submit" name="singlebutton" class="btn btn-group-lg btn-primary">Cadastrar</button>
									<a id="cancel" class="btn btn-group-lg btn-warning" href="cad_usuario.php">Cancelar</a>
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
		<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
		<script src="../assets/js/sb-admin-2.min.js"></script>
		<script src="../assets/js/jquery.flexdatalist.js"></script>	
		<script src="../assets/js/jquery.shortcuts.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../js/links.js"></script>					
		<script src="../js/editaUsuario.js"></script>
	</body>
</html>