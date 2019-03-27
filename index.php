<?php
	if(isset($_COOKIE['sessionID']) && $_COOKIE['sessionID'] != ''){
		session_id($_COOKIE['sessionID']);
		session_start();
		header("Location: pages/home");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head> 
		<title>Controle de Chamados</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html;charset=utf-8" /> 
		<link rel="shortcut icon" href="imagem/favicon.ico" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
		<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
		<link href="assets/css/toastr.css" rel="stylesheet"/>
	</head>
	<body>
		<div class="container">
			<div class="row main">
				<div class="main-login main-center">
					<div class="panel-heading">
						<div class="panel-title text-center">
							<img  class="img-responsive" src="imagem/logo.png" alt="Logo">
						</div>
					</div> 
					<form class="form-horizontal" id="formLogin">
						<div id="errorMsg"></div>
						<div class="form-group" id="divLogin">
							<label for="username" class="cols-sm-2 control-label">Login</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><em class="fa fa-user fa" aria-hidden="true"></em></span>
									<input type="text" class="form-control " name="usuario" id="login"  placeholder="Login"/>
								</div>
								<div id="pLogin" class="input-group hidden">
									<p class="text-center text-danger"><small>Preencha o campo login</small></p>
								</div>
							</div>
						</div>

						<div class="form-group" id="divSenha">
							<label for="password" class="cols-sm-2 control-label">Senha</label>
							<div class="cols-sm-10">
								<div class="input-group ">
									<span class="input-group-addon"><em class="fa fa-lock fa-lg" aria-hidden="true"></em></span>
									<input type="password" class="form-control " name="senha" id="senha"  placeholder="Senha"/>
								</div>
								<div id="pSenha" class="input-group hidden">
									<p class="text-center text-danger"><small>Preencha o campo senha</small></p>
								</div>
							</div>
						</div>

						<div class="form-group">
							<button type="button" class="btn btn-primary btn-lg btn-block login-button" id="entrar">Entrar</button>
						</div>
						<div class="login-register">
							<p class="text-muted text-center">Controle de chamados versão 1.2.0</p>
							<a href="https://github.com/victorMBalves"><em class="fab fa-github fa-2x"></em></a>
				         </div>
					</form>
				</div>
			</div>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>         
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/toastr.min.js"></script>
		<script src="assets/js/date.js"></script>
		<!-- <script src="js/links.js"></script> -->
		<script src="js/menu.js"></script>
	</body>
</html>