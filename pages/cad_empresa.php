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
		<style>
			input.uppercase {
				text-transform: uppercase;
			}
		</style>
	</head>
	<body>
		<?php
			include '../validacoes/verificaSession.php';
			include '../include/menu.php';
		?>
		<div class="container" style="margin-top:60px; margin-bottom:50px;">
			<?php include '../include/cabecalho.php';?>
			<div class="alert alert-success" role="alert">
				<center>Cadastrar nova empresa:</center>
			</div>
			<form class="form-horizontal" action="../inserts/insereempresa.php" method="POST">
				<div class="text-center">
					<div class="form-group">
						<label class="col-md-2 control-label" for="empresa">Razão Social:</label>
						<div class="col-sm-4">
							<input name="empresa" type="text" class="form-control uppercase" required="">
						</div>
						<label class="col-md-2 control-label" for="cnpj">CNPJ:</label>
						<div class="col-sm-4">
							<input name="cnpj" id="cnpj" data-mask="99.999.999/9999-99" type="text" class="form-control" required="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="telefone">Telefone:</label>
						<div class="col-sm-4">
							<input name="telefone" data-mask="(999)9999-9999" type="text" class="form-control" required="">
						</div>
						<label class="col-md-2 control-label" for="celular">Celular:</label>
						<div class="col-sm-4">
							<input name="celular" data-mask="(999)99999-9999" type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="situacao">Situação:</label>
						<div class="col-sm-4">
							<select name="situacao" class="form-control" required="">
								<option value="ATIVO">Ativo
								</option>
								<option value="BLOQUEADO">Bloqueado
								</option>
								<option value="DESISTENTE">Desistente
								</option>
							</select>
						</div>
						<label class="col-md-2 control-label" for="backup">Backup:</label>
						<div class="col-sm-4">
							<select name="backup" class="form-control">
								<option value="1">Google drive configurado
								</option>
								<option value="0">Google drive não configurado
								</option>
							</select>
						</div>
					</div>
					<div class="col-md-12 text-center">
						<button type="submit" id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Cadastrar</button>
						<button type="reset" class="btn btn-group-lg btn-warning" onclick="cancelar2()">Cancelar</button>
					</div>
				</div>
			</form>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="../js/links.js"></script>
		<script src="../js/apiConsulta.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script>
			function erro() {
				alert('Acesso negado! Redirecinando a pagina principal.');
				window.location.assign("chamadoespera.php");
			}
			$(function () {
				$("#skills").autocomplete({
					source: '../utilsPHP/search.php'
				});
			});

			function cancelar() {
				window.location.assign("chamados.php");
			}
			$(function () {
				$('input').focusout(function () {
					// Uppercase-ize contents
					this.value = this.value.toLocaleUpperCase();
				});
			});
		</script>
	</body>
</html>