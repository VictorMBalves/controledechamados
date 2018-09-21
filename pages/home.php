<!Doctype html>
<html>
	<head>
		<title>Controle de chamados</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link href="../css/utils.css" rel="stylesheet">
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link rel="stylesheet" href="../assets/css/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link href="../datatables/datatables.min.css" rel="stylesheet">
    	<link href="../datatables/responsive.dataTables.min.css" rel="stylesheet">
    	<link href="../datatables/rowReorder.dataTables.min.css" rel="stylesheet">
		<link href="../assets/css/toastr.css" rel="stylesheet"/>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	</head>
	<body>
		<div class="wrapper">
			<?php
				include '../validacoes/verificaSession.php';
				include '../include/menu.php';
			?>
			<div class="content col-lg-12">
				<div class="col-md-4 sidebar-outer">
					<div id="plantao"></div><!--Responsavel pelo plantão -->
					<div id="usuarios"></div><!--Usuários disponiveis -->
					<div id="avisos"></div><!-- Panel de avisos -->
				</div>
				<div class="col-md-8">
					<div id="tarefas"></div><!--Aviso de chamado direcionado-->
					<div class="row">
						<div class="col-md-12">
							<div class="col-xs-2 col-sm-2">
								<?php echo "<img src='https://www.gravatar.com/avatar/$email' class='img-thumbnail' alt='Usuario' width='100'>"; ?>
							</div>
							<div class="col-sm-6">
								<h2>Bem-vindo, <?php echo $_SESSION['UsuarioNome']; ?></h2>
							</div>
							<div class="col-sm-4">
								<a id="adcChamado" class="float" data-toggle="tooltip" data-placement="left" title="Adicionar chamado (Alt + C)"><i class="glyphicon glyphicon-earphone my-float rotate"></i></a>
							</div>					
						</div>
					</div>
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
			</div>
		</div>
		<div id="modalConsulta">
		</div>
		<div id="modalCadastro">
		</div>

		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
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