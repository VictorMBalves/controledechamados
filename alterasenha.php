<!Doctype html>
<html >
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" /> 
    <title>Controle de Chamados</title>
    <link rel="shortcut icon" href="imagem/favicon.ico" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="css/bootstrap.css" rel="stylesheet">
  </head>
  <body>

<?php
  // A sessão precisa ser iniciada em cada página diferente
  if (!isset($_SESSION)) {
      session_start();
  }
  // Verifica se não há a variável da sessão que identifica o usuário
  if (!isset($_SESSION['UsuarioID'])) {
      // Destrói a sessão por segurança
      session_destroy();
      // Redireciona o visitante de volta pro login
      header("Location: index.php");
      exit;
  }
  $email = md5($_SESSION['Email']);
  include('include/menu.php');
?>
<div class="container" style="margin-top:60px; margin-bottom:50px;">
 <div id="tarefas"></div>
  <div class="row">
    <h1>
      <div class="row">
        <div class="col-xs-6 col-md-3">
          <a href="home.php" class="thumbnail">
            <img src="imagem/logo.png" >
          </a>
        </div>
        </h1>
      </div>
    <br>
    <div class="row">
      <hr/>
    </div>
    <div class="alert alert-success" role="alert">
      <center>Alterar senha:
      </center>
    </div>
    <br>
    <form class="form-horizontal" action="updates/updatesenha.php" method="POST">
      <div class="form-group">
        <label class="col-md-2 control-label" for="senha">Nova Senha:</label>
          <div class="col-sm-8">
            <input  name="senha" type="password" class="form-control" required="" style="padding-bottom:15px;">
          </div>
          <div class="col-sm-2">
            <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Alterar</button>
          </div>
      </div>
    </form>
    </div>
  </div>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>         
  <script src="js/links.js" ></script>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script>
    function erro(){
        alert('Acesso negado! Redirecinando a pagina principal.');
        window.location.assign("chamadoespera.php");
      }
      $(function() {
        $( "#skills" ).autocomplete({
          source: 'search.php'
        });
      }
       );
  </script>
</body>
</html>
