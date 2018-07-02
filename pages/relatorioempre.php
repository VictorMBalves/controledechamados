<?php
	include '../validacoes/verificaSession.php';
	include '../include/menu.php';
	if (array_key_exists('data', $_POST)) {
		$data = $_POST['data'];
		$data2 = $_POST['data1'];
	} else {
		$data = date('Y-m') . '-01';
		$data2 = date('Y-m-t');
	}
?>
<!doctype html>
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
		<div class="container" style="margin-top:60px; margin-bottom:50px;">
			<?php include '../include/cabecalho.php'; ?>
			<div class="alert alert-success" role="alert">
				<center>Relatório de Nº de chamados por empresa:</center>
			</div>
			<form class="navbar-form text-center" method="POST" action="relatorioempre">
				<fieldset>
					<legend>Período:
					</legend>
					<label style="padding-left:15px; padding-right:10px;" class="control-label">De:
					</label>
					<input type="date" value="<?php echo $data; ?>" name="data" class="form-control">
					<label style="padding-left:15px; padding-right:10px;" class="control-label">Até:
					</label>
					<input style="padding-right:15px;" type="date" value="<?php echo $data2; ?>" name="data1" class="form-control">
					<label style="padding-left:15px; padding-right:10px;" class="control-label">Numero de Registros:
					</label>
					<input style="padding-right:15px; width:65px;" type="number" value="10" name="limite" class="form-control">
					<button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Buscar
					</button>
				</fieldset>
			</form>
			<br>
			<hr/>
			<?php
				require_once '../include/Database.class.php';
				$db = Database::conexao();

				if (array_key_exists('data', $_POST)) {
					$data = $_POST['data'];
					$data2 = $_POST['data1'];
					$limite = $_POST['limite'];
				} else {
					$data = time('Y-m-d');
					$data2 = time('Y-m-d');
					$limite = '10';
				}

				if (array_key_exists('data', $_POST)) {
					$data = $_POST['data'];
					$data2 = $_POST['data1'];
					$limite = $_POST['limite'];
					echo '<div teste table-responsive table-hover">';
					echo '<table class="table table-striped text-center">';
					echo '<thead>';
					echo '<tr class="text-center">';
					echo '<th class="text-center">Nº de Chamados</th>';
					echo '<th class="text-center">Empresa</th>';
					echo '</tr>';
					echo '</thead>';

					echo '<tbody>';
					$query = $db->prepare("SELECT COUNT(empresa), empresa FROM chamado WHERE date(datainicio) BETWEEN '$data' and '$data2' GROUP BY empresa ORDER BY COUNT(empresa) DESC LIMIT $limite");
					$query->execute();
					$result = $query->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result as $row) {
						echo '<tr>';
						echo '<td >' . $row['COUNT(empresa)'] . '</td>';
						echo '<td>' . $row['empresa'] . '</td>';
						echo '</tr>';
					}
					echo '</tbody>';
					echo '</table>';
				}
			?>
		</div>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>         
        <script src="../js/links.js" ></script> 
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
	</body>
</html>
