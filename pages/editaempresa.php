<?php
	include '../validacoes/verificaSession.php';
	require_once '../include/Database.class.php';
    $db = Database::conexao();
	$epr='';
	$msg='';
	if (isset($_GET['epr'])) {
		$epr=$_GET['epr'];
	}
	if ($epr=='excluir') {
		$id=$_GET['id_empresa'];
		$query = $db ->prepare("DELETE FROM empresa WHERE id_empresa=$id");
		$query->execute();
		echo "<script>
				alert('Cadastro deletado com sucesso!');
				window.location.assign('empresa.php');
			</script>";
	}
	$id=$_GET['id_empresa'];
	$sql = $db->prepare("SELECT * FROM empresa WHERE id_empresa=$id");
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
			<?php include '../include/cabecalho.php';?>
			<div class="alert alert-success" role="alert">
				<center>Editar empresa ID:
					<?php echo $id?>
				</center>
			</div>
			<div class="text-right">
				<div class="form-group">
					<?php echo "<a href='editaempresa.php?id_empresa=".$row['id_empresa']."&epr=excluir'><button type='reset' class='btn btn-danger' data-toggle='tooltip' data-placement='left' title='Excluir cadastro!'><span class='glyphicon glyphicon-trash'></span></button></a>"; ?>
				</div>
			</div>
			<form class="form-horizontal" action="../updates/updateempresa.php" method="POST">
				<input style="display:none;" name='id_empresa' value='<?php echo $id; ?>' readonly/>
				<div class="form-group">
					<label class="col-md-2 control-label">Razão Social:</label>
					<div class="col-sm-4">
						<input value='<?php echo $row['nome'];?>' id="skills" name="empresa" type="text" class="form-control" required="">
					</div>
					<label class="col-md-2 control-label">CNPJ:</label>
					<div class="col-sm-4">
						<input value='<?php echo $row['cnpj'];?>' name="cnpj" data-mask="99.999.999/9999-99" type="text" class="form-control" required="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Telefone:</label>
					<div class="col-sm-4">
						<input value='<?php echo $row['telefone'];?>'name="telefone" data-mask="(99)9999-9999" type="text" class="form-control"
							required="">
					</div>
					<label class="col-md-2 control-label">Celular:</label>
					<div class='col-sm-4'>
						<input value='<?php echo $row['celular'];?>' name="celular" data-mask="(99)99999-9999" type="text" class="form-control"
							required="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Situação:</label>
					<div class="col-sm-4">
						<select name="situacao" class="form-control label1">
							<option>
								<?php echo $row['situacao'];?>
							</option>
							<option>
							</option>
							<option value="ATIVO">Ativo
							</option>
							<option value="BLOQUEADO">Bloqueado
							</option>
							<option value="DESISTENTE">Desistente
							</option>
						</select>
					</div>
					<label class="col-md-2 control-label">Backup:</label>
					<div class="col-sm-4">
						<select name="backup" class="form-control label1 ">
								<?php 
									if ($row['backup'] == 0) {
										echo'<option value="0">Google drive não configurado</option>';
									} else {
										echo'<option value="1">Google drive configurado</option>';
									}
								?>
							<option>
							</option>
							<option value="1">Google drive configurado
							</option>
							<option value="0">Google drive não configurado
							</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Sistema:</label>
					<div class="col-sm-4">
						<input value='<?php echo $row['sistema'];?>'name="sistema" type="text" class="form-control" readonly="">
					</div>
					<label class="col-md-2 control-label">Versão:</label>
					<div class='col-sm-4'>
						<input value='<?php echo $row['versao'];?>' name="versao" type="text" class="form-control" readonly="">
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
					<button id="verModulo" name="verModulos" class="btn btn-info" type="button" data-toggle="collapse" data-target="#abrirModulos"
						aria-expanded="false" aria-controls="collapseExample" data-placement='left' title='Visualizar módulos'>
						<icon class="glyphicon glyphicon-th-list"></icon>&nbspVisualizar módulos</button>
					<button type="submit" id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Alterar</button>
					<button type="reset" class="btn btn-group-lg btn-warning" onclick="cancelar2()">Cancelar</button>
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

			function cancelar() {
				window.location.assign("chamados.php");
			}

			$(function () {
				$('[data-toggle="popover"]').popover()
			});
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			});
		</script>
	</body>
</html>
