<?php
	include '../validacoes/verificaSessionFinan.php';
	require_once '../include/Database.class.php';
    $db = Database::conexao();
	$sql = $db->prepare('SELECT nome, nivel, disponivel FROM usuarios');
	$sql->execute();
	$result = $sql->fetchall(PDO::FETCH_ASSOC);
?> 
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
		<?php include '../include/menu.php'; ?>
		<div class="container" style="margin-top:60px; margin-bottom:50px;">
			<div id="usuarios" class="col-xl-4 navbar-right"></div>
			<?php include '../include/cabecalho.php'?>
			<div id="resultado">
				<div id="div-msg" class="alert alert-info" role="alert">
					<center>Novo chamado em espera:</center>
				</div>
			</div>
			<!--Inicio formulario-->
			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-md-2 control-label" for="empresa">Empresa solicitante:</label>
					<div id="empresa-div" class="col-sm-10">
						<input id="empresa" name="empresa" type="text" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="enderecado">Atribuir para:</label>
					<div id="enderecado-div" class="col-sm-10">
						<select id="enderecado" name="enderecado" type="text" class="form-control">
							<option value=""></option>
							<?php 
								foreach ($result as $row) {
									if ($row["nivel"] != 1) {
										echo '<option>'.$row['nome'].'</option>';
									}
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="contato">Contato:</label>
					<div id="contato-div" class="col-sm-4">
						<input name="contato" id="contato" type="text" class="form-control">
					</div>
					<label class="col-md-2 control-label" for="telefone">Telefone:</label>
					<div id="telefone-div" class="col-sm-4">
						<input name="telefone" type="text" id="telefone" class="form-control" onkeypress="return SomenteNumero(event)">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="versao">Versão</label>
					<div id="versao-div" class="col-sm-4">
						<input id="versao" name="versao" type="text" class="form-control">
					</div>
					<label class="col-md-2 control-label" for="sistema">Sistema:</label>
					<div id="sistema-div" class="col-sm-4">
						<input id="sistema" name="sistema" type="text" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="descproblema">Descrição do problema:</label>
					<div id="desc_problema-div" class="col-sm-10">
						<textarea name="descproblema" id="desc_problema" class="form-control"></textarea>
					</div>
				</div>
				<!-- Button -->
				<div class="col-md-12 text-center">
					<?php include "../utilsPHP/statusDados.php";?>
					<button id="submit" class="btn btn-group-lg btn-primary">Salvar</button>
					<button id="cancel" class="btn btn-group-lg btn-warning">Cancelar</button>
				</div>
			</div>
			<!--Fim formulario-->
		</div>
		<br/>
		<br/>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="../js/links.js"></script>
		<script src="../js/apiConsulta.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../js/cadChamadoEspera.js"></script>
	</body>
</html>