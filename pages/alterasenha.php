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
		<link href="../assets/css/toastr.css" rel="stylesheet"/>
	</head>
	<body>
	<?php
		include '../validacoes/verificaSessionFinan.php';
		include '../include/menu.php';
	?>
		<div class="container" style="margin-top:60px; margin-bottom:50px;">
			<?php include '../include/cabecalho.php' ?>
			<div class="alert alert-success" role="alert">
				<center>Alterar senha:
				</center>
			</div>
			<br>
			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-md-1 control-label" for="senha">Senha:</label>
					<div id="senha-div" class="col-sm-4">
						<input name="senha" id="senha" type="password" class="form-control">
					</div>
					<label class="col-md-1 control-label" for="senha">Confirmar:</label>
					<div id="senhaconfirm-div" class="col-sm-4">
						<input name="senhaconfirm" id="senhaconfirm" type="password" class="form-control">
					</div>
					<div class="col-sm-1">
						<button id="submit" name="singlebutton" class="btn btn-group-lg btn-primary form-control">Alterar</button>
					</div>
				</div>
			</div>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../js/links.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../js/alterSenha.js"></script>
	</body>

</html>
