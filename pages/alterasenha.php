<!Doctype html>
<html>

	<head>
		<title>Controle de Chamados</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html;charset=utf-8" /> 
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
	</head>

	<body>

	<?php
		include '../validacoes/verificaSession.php';
		include '../include/menu.php';
	?>
		<div class="container" style="margin-top:60px; margin-bottom:50px;">
			<?php include '../include/cabecalho.php' ?>
			<div class="alert alert-success" role="alert">
				<center>Alterar senha:
				</center>
			</div>
			<br>
			<form class="form-horizontal" action="../updates/updatesenha.php" method="POST">
				<div class="form-group">
					<label class="col-md-2 control-label" for="senha">Nova Senha:</label>
					<div class="col-sm-8">
						<input name="senha" type="password" class="form-control" required="" style="padding-bottom:15px;">
					</div>
					<div class="col-sm-2">
						<button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Alterar</button>
					</div>
				</div>
			</form>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../js/links.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script>
			function erro() {
				alert('Acesso negado! Redirecinando a pagina principal.');
				window.location.assign("chamadoespera.php");
			}
		</script>
	</body>

</html>
