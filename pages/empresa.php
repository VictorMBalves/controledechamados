<!DOCTYPE html>
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
	</head>
	<body>
	<?php
		include '../validacoes/verificaSessionFinan.php';
		include '../include/menu.php';
	?>
		<div class="container" style="margin-top:60px; margin-bottom:50px;">
			<?php include '../include/cabecalho.php';?>
			<div class="alert alert-warning text-center" role="alert">
				Clientes
			</div>
			<div class="text-center">
				<?php include '../filtros/filtroEmpresa.php';?> 
			</div>
			<div class="row">
				<hr>
			</div>       
			<table id="tabela" class="table table-responsive table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Empresa</th>
						<th>Situação</th>
						<th>CNPJ</th>
						<th>Sistema</th>
						<th>Versão</th>
						<th class="text-center"><img src="../imagem/acao.png"></th>
					</tr>
				</thead>
				<tbody id ="tbody">
				</tbody> 
				<div class="col-sm-12 text-center" id="loading"></div>
			</table>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../datatables/datatables.min.js"></script>
		<script src="../datatables/responsive.min.js"></script>
		<script src="../datatables/rowReorder.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="../js/tabelas/empresas.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../js/links.js"></script>
	</body>
</html>
