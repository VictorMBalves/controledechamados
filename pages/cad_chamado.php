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
		<?php include '../include/cabecalho.php'; ?>
			<div id="resultado">
				<div class="alert alert-success" role="alert">
					<center>Novo chamado:</center>
				</div>
			</div>
			<form class="form-horizontal" action="../inserts/insere_chamado.php" method="POST">
				<div class="form-group">
					<label class="col-md-2 control-label" for="empresa">Empresa solicitante:</label>
					<div class="col-sm-10">
						<input name="empresa" type="text" id="skills" class="form-control">
					</div>
				</div>
				<div class=form-group>
					<label class="col-md-2 control-label" for="contato">Contato:</label>
					<div class="col-sm-10">
						<input name="contato" type="text" class="form-control" required="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="formacontato">Forma de contato:</label>
					<div class="col-sm-4">
						<select name="formacontato" type="text" class="form-control" required="">
							<option>
							</option>
							<option value="Cliente ligou">Cliente ligou
							</option>
							<option value="Ligado para o cliente">Ligado para o cliente
							</option>
							<option value="Whatsapp">Whatsapp
							</option>
							<option value="Team Viewer">Team Viewer
							</option>
							<option value="Skype">Skype
							</option>
						</select>
					</div>
					<label class="col-md-2 control-label" for="versao">Versão:</label>
					<div class="col-sm-4">
						<input name="versao" type="text" class="form-control" required="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="telefone">Telefone</label>
					<div class="col-sm-4">
						<input id="telefone" name="telefone" type="text" class="form-control" onkeypress="return SomenteNumero(event)" required="">
					</div>
					<label class="col-md-2 control-label" for="sistema">Sistema:</label>
					<div class="col-sm-4">
						<input name="sistema" type="text" class="form-control" required="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="backup">Backup:</label>
					<div class="col-sm-4">
						<select id="backup" name="backup" type="text" class="form-control" required="">
							<option>
							</option>
							<option value="1">Google drive configurado
							</option>
							<option value="0">Google drive não configurado
							</option>
						</select>
					</div>
					<label class="col-md-2 control-label" for="categoria">Categoria:</label>
					<div class="col-sm-4">
						<select name="categoria" type="text" class="col-md-4 form-control forma" required="">
							<option>
							</option>
							<option value="Erro">Erro
							</option>
							<option value="Duvida">Duvida
							</option>
							<option value="Atualização sistema">Atualização sistema
							</option>
							<option value="Sugestão de melhoria">Sugestão de melhoria
							</option>
							<option value="Outros">Outros
							</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="descproblema">Descrição do problema:</label>
					<div class="col-sm-10">
						<textarea name="descproblema" type="text" class="col-md-4 form-control label1" required=""></textarea>
					</div>
				</div>
				<div class="collapse" id="abrirModulos">
					<div class="form-group">
						<label class="col-md-2 control-label"></label>
						<div class="col-sm-10">
							<div id="modulos">
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 text-center">
					<?php include "../utilsPHP/statusDados.php";?>
					<button id="verModulo" class="btn btn-info" type="button" data-toggle="collapse" data-target="#abrirModulos" aria-expanded="false"
						aria-controls="collapseExample" data-placement='left' title='Visualizar módulos!'>
						<icon class="glyphicon glyphicon-th-list"></icon>&nbspVisualizar módulos</button>
					<button id="salvar" name="singlebutton" class="btn btn-group-lg btn-primary">Gravar</button>
					<button id="voltar" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning" onclick="cancelar()">Cancelar</button>
				</div>
			</form>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../js/links.js"></script>
		<script src="../js/apiConsulta.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			document.getElementById('verModulo').disabled = true;

			function erro() {
				alert('Acesso negado! Redirecinando a pagina principal.');
				window.location.assign("chamadoespera.php");
			}
			$(function () {
				$("#skills").autocomplete({
					source: '../utilsPHP/search.php'
				});
			});
		</script>
	</body>
</html>