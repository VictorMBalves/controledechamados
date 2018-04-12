<!Doctype html>
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
		<link href="css/utils.css" rel="stylesheet">
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
					session_destroy();
					header("Location: index.php");
					exit;
				}
			}
			$email = md5($_SESSION['Email']);
			include('include/db.php');
			include('include/menu.php');
		?>
			<div class="container" style="margin-top:60px; margin-bottom:50px;">
				<div id="tarefas"></div>
				<div class="row">
					<div class="col-sm-2">
						<center>
							<?php echo "<img src='https://www.gravatar.com/avatar/$email' class='img-thumbnail' alt='Cinque Terre' width='100'>";?>
						</center>
					</div>
					<div class="col-sm-6">
						<h2><?php echo $_SESSION['UsuarioNome']; ?>, gerencie seus chamados:</h2>
					</div>
					<div class="col-sm-4">
						<a href="home.php" class="thumbnail teste">
							<img src="imagem/logo.png" />
						</a>
					</div> 
				</div>
				<div class="row">
					<hr/>
				</div>
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#home" class="link"><i class="glyphicon glyphicon-bell"></i>&nbsp&nbspChamados direcionados</a></li>
					<li><a data-toggle="tab" href="#menu1" class="link"><i class="glyphicon glyphicon-user"></i>&nbsp&nbspMeus chamados</a></li>
				</ul>

				<div class="tab-content">

					<div id="home" class="tab-pane fade in active">
						<br>
						<table id="tabeladirecionados" class="table table-responsive table-hover">
							<thead>
								<tr>
									<th>Status</th>
									<th>Data</th>
									<th>Nº Chamado</th>
									<th>Encaminhado por</th>
									<th>Empresa</th>
									<th>Contato</th>
									<th>Telefone</th>
									<th width="100"><center><img src="imagem/acao.png"></center></th>
								</tr>
							</thead>
							<tbody id ="tbodydirecionados">
							</tbody> 
						</table>
						<div class="col-sm-12 text-center" id="loadingdirecionados"></div>
					</div>

					<div id="menu1" class="tab-pane fade">
						<br>
						<table id="tabela" class="table table-responsive table-hover">
							<thead>
								<tr>
									<th>Status</th>
									<th>Data</th>
									<th>Responsável</th>
									<th>Nº Chamado</th>
									<th>Empresa</th>
									<th>Contato</th>
									<th>Telefone</th>
									<th width="100"><center><img src="imagem/acao.png"></center></th>
								</tr>
							</thead>
							<tbody id ="tbody">
							</tbody> 
						</table>
						<div class="col-sm-12 text-center" id="loading"></div>
					</div>

				</div>
			</div>
			<script src="//code.jquery.com/jquery-1.10.2.js"></script>
			<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<script src="datatables/datatables.min.js"></script>
			<script src="datatables/responsive.min.js"></script>
			<script src="datatables/rowReorder.min.js"></script>
			<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
			<script src="js/tabelas/meuschamados.js"></script>
			<script src="js/links.js"></script>
	</body>
</html>