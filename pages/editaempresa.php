<?php
	include '../validacoes/verificaSessionFinan.php';
	require_once '../include/Database.class.php';
    $db = Database::conexao();
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
		<link href="../assets/css/toastr.css" rel="stylesheet"/>
		<style>
			input.uppercase {
				text-transform: uppercase;
			}
		</style>
	</head>
	<body>
		<?php include '../include/menu.php'; ?>
		<div class="container" style="margin-top:60px; margin-bottom:50px;">
			<?php include '../include/cabecalho.php';?>
			<div class="alert alert-info" role="alert">
				<center>Editar empresa ID:
					<?php echo $id?>
				</center>
			</div>
			<div class="text-right">
				<div class="form-group">
					<button id="delete" type='reset' class='btn btn-danger' data-toggle='tooltip' data-placement='left' title='Excluir cadastro!'><span class='glyphicon glyphicon-trash'></span></button>
				</div>
			</div>
			<div class="form-horizontal">
				<input style="display:none;" id="id" name='id_empresa' value='<?php echo $id; ?>'/>
				<div class="form-group">
					<label class="col-md-2 control-label">Razão Social:</label>
					<div id="empresa-div" class="col-sm-4">
						<input value='<?php echo $row['nome'];?>' id="empresa" name="empresa" type="text" class="uppercase form-control">
					</div>
					<label class="col-md-2 control-label">CNPJ:</label>
					<div id="cnpj-div" class="col-sm-4">
						<input value='<?php echo $row['cnpj'];?>' id="cnpj" name="cnpj" data-mask="99.999.999/9999-99" type="text" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Telefone:</label>
					<div id="telefone-div" class="col-sm-4">
						<input value='<?php echo $row['telefone'];?>' id="telefone" name="telefone" data-mask="(99)9999-9999" type="text" class="form-control">
					</div>
					<label class="col-md-2 control-label">Celular:</label>
					<div id="celular-div" class='col-sm-4'>
						<input value='<?php echo $row['celular'];?>' id="celular" name="celular" data-mask="(99)99999-9999" type="text" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Situação:</label>
					<div id="situacao-div" class="col-sm-4">
						<select name="situacao" id="situacao" class="form-control ">
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
					<div id="backup-div" class="col-sm-4">
						<select id="backup" name="backup" class="form-control  ">
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
					<button type="submit" id="submit" name="singlebutton" class="btn btn-group-lg btn-primary">Alterar</button>
					<button type="reset" id="cancel" class="btn btn-group-lg btn-warning">Cancelar</button>
				</div>
			</div>
		</div>

		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../js/links.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../js/editaEmpresa.js"></script>
		<script src="../js/apiConsulta.js"></script>
	</body>
</html>
