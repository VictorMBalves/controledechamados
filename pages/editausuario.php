<?php
include '../validacoes/verificaSessionAdmin.php';
require_once '../include/Database.class.php';
$db = Database::conexao();
$id = $_GET['id'];
$sql = $db->prepare("SELECT * FROM usuarios WHERE id=$id");
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
	</head>

	<body>
		<?php include '../include/menu.php'; ?>
		<div class="container" style="margin-top:60px; margin-bottom:50px;">
	  		<?php include '../include/cabecalho.php'; ?>
			<div class="alert alert-success text-center" role="alert">
				Editar cadastro de usuário:
			</div>
			<div class="text-right">
				<div class="form-group">
					<button type='reset' id="delete" class='btn btn-danger'data-toggle='tooltip' data-placement='left' title='Excluir cadastro!'><span class='glyphicon glyphicon-trash'></span></button>
				</div>
			</div>
			<div class="form-horizontal">
				<input style="display:none;" id="id" name='id' value='<?php echo $id; ?>' readonly/>
				<div id="nome-div" class="form-group">
					<label class="col-md-2 control-label" for="nome">Nome:</label>
					<div class="col-sm-10">
						<input id="nome" name="nome" type="text" class="form-control label1" value="<?php echo $row['nome']?>">
					</div>
				</div>
				<div id="usuario-div" class="form-group">
					<label class="col-md-2 control-label" for="usuario">Login:</label>
					<div class="col-sm-10">
						<input name="usuario" id="usuario" type="text" class="form-control" value="<?php echo $row['usuario']?>">
					</div>
				</div>
				<div id="email-div" class="form-group">
					<label class="col-md-2 control-label" for="usuario">E-mail</label>
					<div class="col-sm-10">
						<input name="email" id="email" type="email" class="form-control label1" value="<?php echo $row['email']?>">
					</div>
				</div>
				<div id="senha-div" class="form-group">
					<label class="col-md-2 control-label" for="senha">Senha:</label>
					<div class="col-sm-10">
						<input name="senha" type="password" id="senha" class="form-control" >
					</div>
				</div>
				<div id="senhaconfirm-div" class="form-group">
					<label class="col-sm-2 control-label" for="senha">Confir. Senha:</label>
					<div class="col-sm-10">
						<input name="senhaconfirm" id="senhaconfirm" type="password" class="form-control label1" >
					</div>
				</div>
				<div id="nivel-div" class="form-group">
					<label class="col-md-2 control-label empresa">Nivel</label>
					<div class="col-sm-10">
						<select name="nivel" id="nivel" class="form-control label1" >
							<option value="3">Suporte Avançado
							</option>
							<option value="2">Help-Desk
							</option>
							<option value="1">Financeiro
							</option>
						</select>
					</div>
				</div>
				<div class="col-md-12 text-center">
					<button type="submit" id="submit" name="singlebutton" class="btn btn-group-lg btn-primary">Cadastrar</button>
					<button type="reset" id="cancel" class="btn btn-group-lg btn-warning" onclick="cancelar4()">Cancelar</button>
				</div>
			</div>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../js/links.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../js/editaUsuario.js"></script>
	</body>
</html>