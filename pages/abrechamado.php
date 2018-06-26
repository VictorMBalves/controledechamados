<?php
	include '../validacoes/verificaSession.php';
	require_once '../include/Database.class.php';
    $db = Database::conexao();
	$id=$_GET['id_chamado'];
	$sql = $db->prepare("SELECT * FROM chamado WHERE id_chamado = :id");
	$sql->bindParam(":id", $id, PDO::PARAM_INT);
	$sql->execute();
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	if($row['status'] == 'Finalizado'){
		echo 'Não localizado';
		return;
	}
	$empresa = $row['empresa'];
	$sql2 = $db->prepare("SELECT backup FROM empresa WHERE nome = '$empresa'");
	$sql2->execute();
	$row2 = $sql2->fetch(PDO::FETCH_ASSOC);
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
		<?php include '../include/menu.php'?>
		<div class="container" style="margin-top:60px; margin-bottom:10px;">
			<?php include '../include/cabecalho.php'?>
			<div class="alert alert-info" role="alert">
				<center>Finalizar Chamado Nº: <?php echo $id?></center>
			</div>
			<div class="form-horizontal">
				<input style="display:none;" id='id_chamado' name='id_chamado' value='<?php echo $id; ?>'/>
				<div class="form-group">
					<label for="empresa" class="col-sm-2 control-label">Empresa solicitante:</label>  
					<div class="col-sm-10">
						<input value='<?php echo $row['empresa'];?>'name="empresa" type="text" class="form-control disabled" readonly>
					</div>
				</div>  
				<div class="form-group">
					<label for="contato" class="col-sm-2 control-label">Contato:</label> 
					<div class="col-sm-10">
						<input value='<?php echo $row['contato'];?>' name="contato" type="text" class="form-control disabled" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="formacontato" class="col-sm-2 control-label">Forma de contato:</label> 
					<div class="col-sm-4"> 
						<input name="formacontato"  value='<?php echo $row['formacontato'];?>' type="text" class="form-control disabled" readonly>
					</div>
					<label for="versao" class="col-sm-2 control-label">Versão:</label>
					<div class="col-sm-4">
						<input value="<?php echo $row['versao']?>" type="text" class="form-control disabled" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="telefone" class="col-sm-2 control-label">Telefone:</label>  
					<div class="col-sm-4">
						<input value='<?php echo $row['telefone'];?>' name="telefone" type="text" class="form-control disabled" readonly>
					</div>
					<label for="sistema" class="col-sm-2 control-label">Sistema:</label>
					<div class="col-sm-4">  
						<input value='<?php echo $row['sistema'];?>' name="sistema" type="text" class="form-control disabled" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="backup" class="col-sm-2 control-label">Backup:</label>  
					<div class="col-sm-4">  
						<input name="backup" value="<?php 
														if ($row2['backup'] == 0) {
															echo "Google drive não configurado";
														} else {
															echo "Google drive configurado";
														}
								?>" class="form-control disabled" readonly>
					</div>
					<label for="categoria" class="col-sm-2 control-label">Categoria:</label>
					<div class="col-sm-4">  
						<input name="categoria" value="<?php echo $row['categoria'];?>" type="text" class="form-control disabled" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="descproblema" class="col-sm-2 control-label">Descrição do problema:</label>
						<div class="col-sm-10">  
							<textarea name="descproblema" type="text" class="form-control disabled" readonly><?php echo $row['descproblema'];?></textarea>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="descsolucao">Solução:</label>  
					<div id="descsolucao-div"class="col-sm-10">
						<textarea name="descsolucao" id="descsolucao" type="text" class="form-control" required=""><?php echo $row['descsolucao'];?></textarea>
					</div>
				</div>
				<div class="text-center">
					<button id="submit" name="singlebutton" class="btn btn-group-lg btn-primary">Finalizar</button>
					<button id="cancel" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning">Cancelar</button>
				</div>
			</div>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>         
		<script src="../js/links.js" ></script> 
		<script src="../assets/js/toastr.min.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../js/finalizaChamado.js" ></script> 
		<script>
			function Erro(){
				notificationError('Acesso restrito');
			}
		</script>
	</body>
</html>
