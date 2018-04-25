<?php
	include '../validacoes/verificaSession.php';
	include '../include/dbconf.php';
	$conn->exec('SET CHARACTER SET utf8');
	$id=$_GET['id_chamadoespera'];
	$sql = $conn->prepare("SELECT * FROM chamadoespera WHERE id_chamadoespera=$id");
	$sql->execute();
	$row = $sql->fetch(PDO::FETCH_ASSOC);
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
			<?php include '../include/cabecalho.php'; ?>
			<div class="alert alert-warning" role="alert">
				<center>Consulta chamado em espera Nº:
					<?php echo $id?>
				</center>
			</div>
			<br>
			<form class="form-horizontal" action="../updates/updateconsulta.php" method="POST">
				<input style="display:none;" name="id_chamadoespera" value="<?php echo $id?>">
				<div class="form-group">
					<label class="col-md-2 control-label">Empresa Solicitante:</label>
					<div class="col-sm-10">
						<input name="empresa" type="text" class="form-control disabled" disabled value="<?php echo $row['empresa'];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Contato:</label>
					<div class="col-sm-4">
						<input name="contato" value="<?php echo $row['contato'];?>" type="text" class="form-control disabled" disabled>
					</div>
					<label class="col-md-2 control-label">Telefone:</label>
					<div class="col-sm-4">
						<input name="telefone" value="<?php echo $row['telefone'];?>" type="text" class="form-control disabled" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Usuário Solicitante:</label>
					<div class="col-sm-4">
						<input name="usuario" value="<?php echo $row['usuario'];?>" type="text" class="form-control disabled" disabled>
					</div>
					<label class="col-md-2 control-label empresa">Data:</label>
					<div class="col-sm-4">
						<input name="usuario" value="<?php echo $row['data'];?>" type="text" class="form-control disabled" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="versao">Versão</label>
					<div class="col-sm-4">
						<input id="versao" name="versao" type="text" class="form-control disabled" value="<?php echo $row['versao']?>" disabled>
					</div>
					<label class="col-md-2 control-label" for="sistema">Sistema:</label>
					<div class="col-sm-4">
						<input name="sistema" type="text" class="form-control disabled" value="<?php echo $row['sistema']?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="descproblema">Descrição do problema:</label>
					<div class="col-sm-10">
						<textarea name="descproblema" class="form-control disabled" disabled required=""><?php echo $row['descproblema'];?></textarea>
					</div>
				</div>
					<?php 
						if (!(is_null($row['historico']))) {
							echo '<div class="form-group">
										<label class="col-md-2 control-label" for="descproblema">Histórico de contato:</label> 
									<div class="col-sm-10">
										<textarea name="historico" class="form-control label1 disabled" disabled>'.$row['historico'].'</textarea> 
									</div>
								</div>';
						}
					?>
				<div class="collapse" id="abrirHistorico">
					<div class="form-group">
						<label class="col-md-2 control-label" for="descproblema">Histórico de contato:</label>
						<div class="col-sm-10">
							<textarea name="historico" class="form-control label1 "></textarea>
						</div>
						<div class="col-md-12 text-center">
							<button type="submit" class="btn btn-group-lg btn-success">Salvar</button>
						</div>
					</div>
				</div>
				<div class="col-md-12 text-center">
					<button type="reset" class="btn btn-group-lg btn-warning" onclick="home()">Retornar</button>
					<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#abrirHistorico" aria-expanded="false" aria-controls="collapseExample"
						data-placement='left' title='Adicionar histórico de contato!'>Adcionar Histórico de contato</button>
				</div>
			</form>
		</div>
		</br>
		</br>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="../js/links.js"></script>
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
				window.location.assign("../pages/home.php");
			}
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			});
		</script>
	</body>
</html>