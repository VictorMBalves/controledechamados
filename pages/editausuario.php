<?php
include '../validacoes/verificaSessionAdmin.php';
require_once '../include/Database.class.php';
$db = Database::conexao();
$id = $_GET['id'];
$sql = $db->prepare("SELECT * FROM usuarios WHERE id=$id");
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);
$epr = "";

if (isset($_GET['epr'])) {
    $epr = $_GET['epr'];
}
if ($epr == 'excluir') {
    $id = $_GET['id'];
    $query = $db->prepare("DELETE FROM usuarios WHERE id=$id");
    $query->execute();
	echo "<script>
			alert('Cadastro deletado com sucesso!');
			  window.location.assign('cad_usuario.php');
		</script>";
}
?>
<!Doctype html>
<html>

	<head>
		<title>Controle de Chamados</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link rel="shortcut icon" href="imagem/favicon.ico" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
	</head>

	<body>
		<?php include '../include/menu.php'; ?>
		<div class="container" style="margin-top:60px; margin-bottom:50px;">
	  		<?php include '../include/cabecalho.php'; ?>
			<div class="alert alert-success" role="alert">
				<center>Editar cadastro de usuário:</center>
			</div>
			<div class="text-right">
				<div class="form-group">
					<?php echo "<a href='editausuario.php?id=".$row['id']."&epr=excluir'><button type='reset' class='btn btn-danger'data-toggle='tooltip' data-placement='left' title='Excluir cadastro!'><span class='glyphicon glyphicon-trash'></span></button></a>"; ?>
				</div>
			</div>
			<form class="form-horizontal" action="../updates/updateusuario.php" method="POST">
				<input style="display:none;" name='id' value='<?php echo $id; ?>' readonly/>
				<div class="form-group">
					<label class="col-md-2 control-label" for="nome">Nome:</label>
					<div class="col-sm-10">
						<input name="nome" type="text" class="form-control label1" value="<?php echo $row['nome']?>" required="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="usuario" id="usuario">Login:</label>
					<div class="col-sm-10">
						<input name="usuario" type="text" class="form-control" value="<?php echo $row['usuario']?>" required="">
						<div id="resultado"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="usuario">E-mail</label>
					<div class="col-sm-10">
						<input name="email" type="email" class="form-control label1" value="<?php echo $row['email']?>" required="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="senha">Senha:</label>
					<div class="col-sm-10">
						<input name="senha" type="password" class="form-control" required="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label empresa">Nivel</label>
					<div class="col-sm-10">
						<select name="nivel" class="form-control label1" required="">
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
					<button type="submit" id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Cadastrar</button>
					<button type="reset" class="btn btn-group-lg btn-warning" onclick="cancelar4()">Cancelar</button>
				</div>
			</form>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="../js/links.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script>
			function erro() {
				alert('Acesso negado! Redirecinando a pagina principal.');
				window.location.assign("home.php");
			}

			function cancelar() {
				window.location.assign("chamados.php");
			}

			$(function () {
				$('[data-toggle="popover"]').popover()
			})
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			})
		</script>
	</body>
</html>