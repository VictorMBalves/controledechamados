<?php
	include '../validacoes/verificaSession.php';
	require_once '../include/Database.class.php';
    $db = Database::conexao();
	$id=$_GET['id_chamadoespera'];
	$sql = $db->prepare("SELECT * FROM chamadoespera WHERE id_chamadoespera=$id");
	$sql->execute();
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	$empresa = $row['empresa'];
	$sql2 = $db->prepare("SELECT backup FROM empresa WHERE nome = '$empresa'");
	$sql2->execute();
	$row2 = $sql2->fetch(PDO::FETCH_ASSOC);

	if($row['status'] == 'Finalizado'){
		header("Location: home.php"); 
		exit();
	}
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
	</head>

	<body>
		<?php include '../include/menu.php' ?>
		<div class="container" style="margin-top:60px; margin-bottom:50px;">
			<?php include '../include/cabecalho.php'?>
			<div id="divMsg" class="alert alert-warning" role="alert">
				<center>Atender chamado em espera Nº: <?php echo $id?> </center>
			</div>
			<br>
			<div class="form-horizontal">
				<input style="display:none;" id="id_chamado"  name='id_chamadoespera' value='<?php echo $id; ?>'/>
				<div class="form-group">
					<label class="col-md-2 control-label" for="empresa">Empresa solicitante:</label> 
					<div class="col-sm-10">
						<input value='<?php echo $row['empresa'];?>'name="empresa" type="text" id="empresa" class="form-control readonly" readonly  >
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="contato">Contato:</label>  
					<div id="contato-div" class="col-sm-10">
						<input value='<?php echo $row['contato'];?>' name="contato" type="text" id="contato" class="form-control"  >
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="formacontato">Forma de contato:</label>  
					<div  id="forma_contato-div" class="col-sm-4">
						<select name="formacontato" type="text" id="forma_contato" class="form-control"  >
							<option></option>
							<option value="Cliente ligou">Cliente ligou</option>
							<option value="Ligado para o cliente">Ligado para o cliente</option>
							<option value="Whatsapp">Whatsapp</option>
							<option value="Team Viewer">Team Viewer</option>
							<option value="Skype">Skype</option>
						</select>
					</div>
					<label class="col-md-2 control-label" for="telefone">Telefone</label>  
					<div id="telefone-div" class="col-sm-4">
						<input value='<?php echo $row['telefone'];?>' name="telefone" id="telefone" type="text" class="form-control" onkeypress="return SomenteNumero(event)"  >
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="sistema">Sistema:</label>  
					<div id="sistema-div" class="col-sm-4">
						<input name="sistema" type="text" value='<?php echo $row['sistema'];?>' id="sistema" class="form-control"  >
					</div>
					<label class="col-md-2 control-label" for="versao">Versão:</label>  
					<div id="versao-div" class="col-sm-4">
						<input name="versao" type="text" value='<?php echo $row['versao'];?>' id="versao" class="form-control"  >
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="backup">Backup:</label>  
					<div id="backup-div" class="col-sm-4">
						<select name="backup" class="form-control" id="backup">
							<?php 
								if ($row2['backup'] == 0) {
									echo '<option value="0">Google drive não configurado</option>';
								} else {
									echo '<option value="1">Google drive configurado</option>';
								}
							?>
							<option></option>
							<option value="1">Google drive configurado</option>
							<option value="0">Google drive não configurado</option>
						</select>
					</div>
					<label class="col-md-2 control-label" for="categoria">Categoria:</label>
					<div id="categoria-div" class="col-sm-4">
						<select name="categoria" type="text" id="categoria" class="form-control"  >
							<option></option>
							<option value="Erro">Erro</option>
							<option value="Duvida">Duvida</option>
							<option value="Atualização sistema">Atualização sistema</option>
							<option value="Sugestão de melhoria">Sugestão de melhoria</option>
							<option value="Outros">Outros</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="descproblema">Descrição do problema:</label> 
						<div id="descricao_proplema-div" class="col-sm-10">
							<textarea name="descproblema" type="text" id="descricao_proplema" class="form-control"  ><?php echo $row['descproblema'];?></textarea>
						</div>
				</div>
				<div class="col-md-12 text-center">
					<button id="submit" class="btn btn-group-lg btn-primary">Atender</button>
					<button id="cancel" class="btn btn-group-lg btn-warning">Cancelar</button>
				</div>
			</div>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>         
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../js/links.js" ></script>
		<script src="../js/atenderChamadoEspera.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
	</body>
</html>