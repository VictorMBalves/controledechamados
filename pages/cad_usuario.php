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
		<link href="../assets/css/toastr.css" rel="stylesheet"/>
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
					<div class="form-horizontal">
						<div id="nome-div" class="form-group">
							<label class="col-sm-2 control-label" for="nome">Nome:</label>
							<div class="col-sm-10">
								<input name="nome" id="nome" type="text" class="form-control" required="">
							</div>
						</div>
						<div id="usuario-div" class="form-group">
							<label class="col-sm-2 control-label" for="usuario">Login:</label>
							<div class="col-sm-10">
								<input name="usuario" type="text" id="usuario" class="form-control" required="">
							</div>
						</div>
						<div id="email-div" class="form-group">
							<label class="col-sm-2 control-label" for="email">E-mail</label>
							<div class="col-sm-10">
								<input name="email" id="email" type="email" class="form-control" required="">
							</div>
						</div>
						<div id="senha-div" class="form-group">
							<label class="col-sm-2 control-label" for="senha">Senha:</label>
							<div class="col-sm-10">
								<input name="senha" id="senha" type="password" class="form-control label1" required="">
							</div>
						</div>
						<div id="senhaconfirm-div" class="form-group">
							<label class="col-sm-2 control-label" for="senha">Confir. Senha:</label>
							<div class="col-sm-10">
								<input name="senhaconfirm" id="senhaconfirm" type="password" class="form-control label1" required="">
							</div>
						</div>
						<div id="nivel-div" class="form-group">
							<label class="col-sm-2 control-label" for="nivel">Nivel</label>
							<div class="col-sm-10">
								<select name="nivel" id="nivel" class="form-control" required="">
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
							<button type="submit" id="submit" name="singlebutton" class="btn btn-group-lg btn-primary">Cadastrar</button>
							<button type="reset" id="cancel" class="btn btn-group-lg btn-warning">Cancelar</button>
						</div>
					</div>
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
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../js/links.js"></script>
		<script src="../js/cadUsuario.js"></script>
	</body>
</html>