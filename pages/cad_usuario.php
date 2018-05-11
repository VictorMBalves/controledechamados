<!Doctype html>
<html>
	<head>
		<title>Controle de chamados</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link href="../datatables/datatables.min.css" rel="stylesheet">
    	<link href="../datatables/responsive.dataTables.min.css" rel="stylesheet">
    	<link href="../datatables/rowReorder.dataTables.min.css" rel="stylesheet">
		<link rel="stylesheet" href="../css/utils.css">
	</head>
	<body>
		<?php
			include '../validacoes/verificaSessionAdmin.php';
			include '../include/menu.php';
		?>
		<div class="container" style="margin-top:60px; margin-bottom:50px;"> 
			<?php include '../include/cabecalho.php';?>
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#home" class="link"><i class="glyphicon glyphicon-edit"></i>&nbsp&nbspNovo usuário</a></li>
				<li><a data-toggle="tab" href="#home1" class="link"><i class="glyphicon glyphicon-list"></i>&nbsp&nbspLista de usuários</a></li>
			</ul>

			<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
					<br/>
					<form class="form-horizontal" action="../inserts/insereusuario.php"  onsubmit="return validateForm()" method="POST">
						<div class="form-group">
							<label class="col-sm-1 control-label" for="nome">Nome:</label>
							<div class="col-sm-10">
								<input name="nome" type="text" class="form-control" required="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label" for="usuario" id="usuario">Login:</label>
							<div class="col-sm-10">
								<input name="usuario" type="text" class="form-control" required="">
								<div id="resultado"></div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label" for="usuario">E-mail</label>
							<div class="col-sm-10">
								<input name="email" type="email" class="form-control" required="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label" for="senha">Senha:</label>
							<div class="col-sm-10">
								<input name="senha" type="password" class="form-control label1" required="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label" for="nivel">Nivel</label>
							<div class="col-sm-10">
								<select name="nivel" class="form-control" required="">
									<option value="3">Suporte Avançado
									</option>
									<option value="2">Help-Desk
									</option>
									<option value="1">Financeiro
									</option>
								</select>
							</div>
						</div>
						<!-- Button -->
						<div class="col-md-12 text-center">
							<button type="submit" id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Cadastrar</button>
							<button type="reset" class="btn btn-group-lg btn-warning">Cancelar</button>
						</div>
					</form>
				</div>

				<div id="home1" class="tab-pane fade">
					<br/>
					<table id="tabela" class="table table-responsive table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Nome</th>
								<th>Login</th>
								<th>Email</th>
								<th width="100"><center><img src="../imagem/acao.png"></center></th>
							</tr>
						</thead>
						<tbody id ="tbody">
						</tbody> 
					</table>
					<div class="col-sm-12 text-center" id="loading"></div>
				</div>
			</div>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../datatables/datatables.min.js"></script>
		<script src="../datatables/responsive.min.js"></script>
		<script src="../datatables/rowReorder.min.js"></script>
		<script src="../js/tabelas/usuarios.js"></script>
		<script src="../js/links.js"></script>
		<script>
			function validateForm(){
				div = $("#pValid");
				if(div.hasClass('text-danger')){
					return false;
				}
			}
		</script>
	</body>
</html>