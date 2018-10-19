<?php
  include '../validacoes/verificaSession.php';
  require_once '../include/Database.class.php';
  require_once '../include/Permissao.class.php';
  $db = Database::conexao();
  $id=$_GET['id_chamado'];
  $sql = $db->prepare("SELECT * FROM chamado WHERE id_chamado=$id");
  $sql->execute();
  $row = $sql->fetch(PDO::FETCH_ASSOC);
  if($row['status'] == 'Finalizado'){
		echo "<h1>Chamado Nº{$id} já encerrado<h1>";
	return;
  }
  $empresa = $row['empresa'];
  $sql2 = $db->prepare("SELECT backup FROM empresa WHERE nome = '$empresa'");
  $sql2->execute();
  $row2 = $sql2->fetch(PDO::FETCH_ASSOC);

  $permissaoSelect = new Permissao($db);
  $permissao = $permissaoSelect->load_by_id(1);
  if($permissao->permitirLancarCadastro)
	  echo "Pode lançar";
	else
  		echo "Não pode lançar";
  return;

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
		<?php  include '../include/menu.php';?>
		<div class="container" style="margin-top:60px; margin-bottom:50px;">
		<?php include '../include/cabecalho.php';?>
			<div class="alert alert-info text-center" role="alert">
				Editar Chamado Nº <?php echo $id?>
			</div>
			<div class="form-horizontal">
				<input style="display:none;" name="id_chamado" id="id_chamado" value="<?php echo $id; ?>"/>
				<div class="form-group">
					<label class="col-md-2 control-label" for="empresa">Empresa solicitante:</label>
					<div id="empresa-div" class="col-sm-10">
						<input value='<?php echo $row['empresa'];?>' id="empresa" name="empresa" type="text" class="form-control disabled" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="contato">Contato:</label>
					<div id="contato-div" class="col-sm-10">
						<input value='<?php echo $row['contato'];?>' id="contato" name="contato" type="text" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="formacontato">Forma de contato:</label>
					<div id="formaContato-div" class="col-sm-4">
						<select name="formacontato" type="text" id="formaContato" class="form-control">
							<option>
								<?php echo $row['formacontato'];?>
							</option>
							<option></option>
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
					<div id="versao-div" class="col-sm-4">
						<input type="text" id="versao" name="versao" class="form-control" required="" value="<?php echo $row['versao'] ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="telefone">Telefone</label>
					<div id="telefone-div" class="col-sm-4">
						<input value='<?php echo $row['telefone'];?>' id="telefone" data-mask="(999)9999-9999" name="telefone" type="text" class="form-control label2"
							onkeypress="return SomenteNumero(event)" required="">
					</div>
					<label class="col-md-2 control-label" for="sistema">Sistema:</label>
					<div id="sistema-div" class="col-sm-4">
						<select name="sistema" type="text" id="sistema" class="form-control" required="">
							<option>
								<?php echo $row['sistema'];?>
							</option>
							<option></option>
							<option value="Manager">Manager
							</option>
							<option value="Light">Light
							</option>
							<option value="Gourmet">Gourmet
							</option>
							<option value="Fiscal">Fiscal
							</option>
							<option value="Folha">Folha
							</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="backup">Backup:</label>
					<div id="backup-div" class="col-sm-4">
						<select id="backup" name="backup" class="form-control" required="">
								<?php 
									if ($row2['backup'] == 0) {
										echo "<option value='0'>Google drive não configurado</option>";
									} else {
										echo "<option value='1'>Google drive configurado</option>";
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
					<label class="col-md-2 control-label" for="categoria">Categoria:</label>
					<div id="categoria-div" class="col-sm-4">
						<select name="categoria" id="categoria" type="text" class="form-control forma" required="">
							<option>
								<?php echo $row['categoria'];?>
							</option>
							<option></option>
							<option value="Erro">Erro
							</option>
							<option value="Duvida">Duvida
							</option>
							<option value="Atualização sistema">Atualização sistema
							</option>
							<option value="Sugestão de melhoria">Sugestão de melhoria
							</option>
							<option value="Retorno">Retorno</option>
							<option value="Outros">Outros
							</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="descproblema">Descrição do problema:</label>
					<div id="descproblema-div" class="col-sm-10">
						<textarea name="descproblema" id="descproblema" type="text" class="form-control label1" required=""><?php echo $row['descproblema'];?></textarea>
					</div>
				</div>
				<div class="col-md-12 text-center">
					<button id="submit" name="singlebutton" class="btn btn-group-lg btn-primary">Alterar</button>
					<button id="cancel" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning">Cancelar</button>
				</div>
			</div>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../js/links.js"></script>
		<script src="../js/editaChamado.js"></script>
	</body>

</html>
