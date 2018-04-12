<!DOCTYPE html>
<html>
	<head>
		<title>Controle de chamados</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="shortcut icon" href="imagem/favicon.ico" />
		<link href="datatables/datatables.min.css" rel="stylesheet">
    	<link href="datatables/responsive.dataTables.min.css" rel="stylesheet">
    	<link href="datatables/rowReorder.dataTables.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/utils.css">
	</head>
	<body>
	<?php
		if (!isset($_SESSION)) {
			session_start();
		}
		if ($_SESSION['UsuarioNivel'] == 1) {
			echo'<script>erro()</script>';
		} else {
			if (!isset($_SESSION['UsuarioID'])) {
				// Destrói a sessão por segurança
				session_destroy();
				// Redireciona o visitante de volta pro login
				header("Location: index.php");
				exit;
			}
		}
		$email = md5($_SESSION['Email']);
		include 'include/db.php';
		include 'include/menu.php';
	?>
		<div class="container" style="margin-top:60px; margin-bottom:50px;">
			<div id="tarefas"></div>
			<div class="row">
				<div class="col-xs-6 col-md-3">
					<a href="#" class="thumbnail">
						<img src="imagem/logo.png" >
					</a>
				</div>
			</div>
			<br/>
			<div class="alert alert-warning" role="alert">
				<center>Chamados</center>
			</div>
			<div class="text-center">
				<?php include 'filtros/filtroChamados.php';?> 
			</div>
			<div class="row">
				<hr>
			</div>       
			<table id="tabela" class="table table-responsive table-hover">
				<thead>
					<tr>
						<th>Status</th>
						<th width="100px">Data</th>
						<th>Responsável</th>
						<th>Nº</th>
						<th>Empresa</th>
						<th>Contato</th>
						<th>Telefone</th>
						<th width="100"><center><img src="imagem/acao.png"></center></th>
					</tr>
				<tbody id ="tbody">
				</tbody> 
				<div class="col-sm-12 text-center" id="loading"></div>
			</table>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="datatables/datatables.min.js"></script>
		<script src="datatables/responsive.min.js"></script>
		<script src="datatables/rowReorder.min.js"></script>
		<script src="js/tabelas/chamados.js"></script>
		<script src="js/links.js"></script>
	</body>
</html>