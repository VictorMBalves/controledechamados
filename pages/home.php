<!Doctype html>
<html>
	<head>
		<title>Controle de chamados</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link href="../datatables/datatables.min.css" rel="stylesheet">
    	<link href="../datatables/responsive.dataTables.min.css" rel="stylesheet">
    	<link href="../datatables/rowReorder.dataTables.min.css" rel="stylesheet">
		<link href="../css/utils.css" rel="stylesheet">
	</head>
	<body>
		<div class="wrapper">
			<?php
				include '../validacoes/verificaSession.php';
				include '../include/menu.php';
			?>
			<div class="content">
				<div class="col-md-8">
					<div id="tarefas"></div><!--Aviso de chamado direcionado-->
					<div class="row">
						<div class="col-md-12">
							<div class="col-xs-2 col-sm-2">
								<?php echo "<img src='https://www.gravatar.com/avatar/$email' class='img-thumbnail' alt='Usuario' width='100'>"; ?>
							</div>
							<div class="col-sm-8">
								<h2>Bem-vindo, <?php echo $_SESSION['UsuarioNome']; ?></h2>
							</div>					
						</div>
					</div>
					<!-- <div class="col-md-4">
						<a href="home.php" class="thumbnail teste">
							<img src="../imagem/logo.png" >
						</a>
					</div> -->
					<br>
					<div class="alert alert-warning" role="alert">
						<center>Chamados aguardando retorno:</center>
					</div>
					<div class="row">
						<hr/>
					</div>
					<table id="tabela" class="table table-responsive table-hover">
						<thead>
							<tr>
								<th>Status</th>
								<th>Data</th>
								<th>Atendente</th>
								<th>Atribuí­do para</th>
								<th>Empresa</th>
								<th>Contato</th>
								<th>Telefone</th>
								<th width="100"><center><img src="../imagem/acao.png"></center></th>
							</tr>
						<tbody id ="tbody">
						</tbody> 
					</table>
					<div class="col-sm-12 text-center" id="loading"></div>
				</div>
				<div class="col-md-4 sidebar-outer">
					<div id="plantao"></div><!--Responsavel pelo plantão -->
					<div id="usuarios"></div><!--Usuários disponiveis -->
					<div id="avisos"></div><!-- Panel de avisos -->
				</div>
			</div>
		</div>

		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="../datatables/datatables.min.js"></script>
		<script src="../datatables/responsive.min.js"></script>
		<script src="../datatables/rowReorder.min.js"></script>
		<script src="../js/links.js"></script>
		<script src="../js/tabelas/home.js"></script>
	</body>
</html>