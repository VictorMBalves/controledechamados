<!Doctype html>
<html>
	<head>
		<title>Controle de chamados</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link href="../datatables/datatables.min.css" rel="stylesheet">
    	<link href="../datatables/responsive.dataTables.min.css" rel="stylesheet">
    	<link href="../datatables/rowReorder.dataTables.min.css" rel="stylesheet">
		<link rel="stylesheet" href="../css/utils.css">
	</head>
	<body>
	<?php
		/////////////////////
		include '../validacoes/verificaSession.php';
		include '../include/db.php';
		include '../include/menu.php';
		/////////////////////
	?>
	<div class="container" style="margin-top:60px; margin-bottom:50px;">
		<div id="tarefas"></div>
		<div class="row">
			<div class="col-xs-6 col-md-3">
				<a href="home.php" class="thumbnail">
					<img src="../imagem/logo.png" >
				</a>
			</div>
		</div>
		<div class="row">
			<hr/>
		</div>
		<br>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#home1" class="link"><i class="glyphicon glyphicon-bullhorn"></i>&nbsp&nbspNovo plantão decorrido</a></li>
			<li><a data-toggle="tab" href="#menu1" class="link"><i class="glyphicon glyphicon-user"></i>&nbsp&nbspPlantões</a></li>
			<li><a data-toggle="tab" href="#menu2" class="link"><i class="glyphicon glyphicon-calendar"></i>&nbsp&nbspSobreaviso</a></li>
			<li><a data-toggle="tab" href="#menu3" class="link"><i class="glyphicon glyphicon-transfer"></i>&nbsp&nbspEscala sobreaviso</a></li>
		</ul>
		<div class="tab-content">
			<!-- PLANTAO DECORRIDO -->
			<div id="home1" class="tab-pane fade in active">
				<?php include 'cad_plantao.php'?>
			</div>

			<div id="menu1" class="tab-pane fade">
			<br/>
				<table id="tabela" class="table table-responsive table-hover">
					<thead>
						<tr>
							<th>Status</th>
							<th>Data</th>
							<th>Responsável</th>
							<th>Nº Chamado</th>
							<th>Empresa</th>
							<th>Contato</th>
							<th>Telefone</th>
							<th width="100"><center><img src="../imagem/acao.png"></center></th>
						</tr>
					<tbody id ="tbody">
					</tbody> 
				</table>
					<div class="col-sm-12 text-center" id="loading"></div>
			</div>

			<?php 
			if (array_key_exists('data', $_POST)) {
			$data=$_POST['data'];
			$data2=$_POST['data1'];
			} else {
			$data = date('Y-m').'-01';
			$data2 = date('Y-m-t');
			}
			?>

			<div id="menu2" class="tab-pane fade">
				<br/>
				<form class="navbar-form text-center" method="POST" action="sobreaviso.php">
				<fieldset>
				<legend>Período:
				</legend>
				<label style="padding-left:15px; padding-right:10px;" class="control-label">De:
				</label>
				<input type="date" value="<?php echo $data;?>" name="data1" class="form-control">
				<label style="padding-left:15px; padding-right:10px;" class="control-label">Até:
				</label>
				<input style="padding-right:15px;" type="date" value="<?php echo $data2;?>" name="data2" class="form-control">
				<button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary"><i class="glyphicon glyphicon-print"></i> Gerar</button>
				</fieldset>
				</form> 
			</div>
			<div id="menu3" class="tab-pane fade">
				<?php include 'escalamensalpage.php'?>
			</div>
		</div>
	</div>

	<div id="modalConsulta">
	</div>

	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<script src="../js/md5.js"></script>
	<script src="../js/escalamensal.js"></script>
	<script src="../datatables/datatables.min.js"></script>
	<script src="../datatables/responsive.min.js"></script>
	<script src="../datatables/rowReorder.min.js"></script>
	<script src="../js/tabelas/plantao.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../js/apiConsulta.js"></script>
	<script src="../js/links.js"></script>

</body>
</html>