<!Doctype html>
<html>
  <head>
    <title>Controle de Chamados</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="shortcut icon" href="imagem/favicon.ico" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <link href="css/bootstrap.css" rel="stylesheet">
  </head>
  <body>
    <?php
      if (!isset($_SESSION)) {
         session_start();
      }
      if (!isset($_SESSION['UsuarioID'])) {
        session_destroy();
        header("Location: index.php");
        exit;
      }
      include('include/dbconf.php');
      $conn->exec('SET CHARACTER SET utf8');
      $sql = $conn->prepare('SELECT nome, nivel, disponivel FROM usuarios');
      $sql->execute();
      $result = $sql->fetchall();
      $email = md5($_SESSION['Email']);
      include('include/menu.php');
    ?>
    <br/>
    <br/>
    <br/>
    <br/>
    <div id="usuarios" class="col-xs-6 col-md-3 navbar-right" style="margin-right:20px;"></div>
    <div class="container">
      <div id="tarefas"></div>
      <div class="row">
        <h1>
          <div class="row">
            <div class="col-xs-6 col-md-3">
              <a href="home.php" class="thumbnail">
                <img src="imagem/logo.png" ></img>
              </a>
            </div>
          </div>
        </h1>
        <br>
        <div class="row">
          <hr/>
        </div>
        <div id="resultado">
          <div class="alert alert-success" role="alert">
            <center>Novo chamado em espera:</center>
          </div>
        </div>
        <form class="form-horizontal" action="inserechamadoespera.php" method="POST">
          <div class="form-group">
            <label class="col-md-2 control-label" for="skills">Empresa solicitante:</label>
              <div class="col-sm-10">
                <input id="skills" name="empresa" type="text" class="form-control" required="">
              </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="enderecado">Atribuir para:</label>
              <div class="col-sm-10">
                <select name="enderecado" type="text" class="form-control">
                  <option value=""></option>       
                  <?php 
                    foreach ($result as $row) {
                      if ($row["nivel"] != 1) {
                        echo '<option>'.$row['nome'].'</option>';
                      }
                    }
                  ?>
                </select>
              </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="contato">Contato:</label>
              <div class="col-sm-4">
                <input name="contato" type="text" class="form-control label2" required="">
              </div>
            <label class="col-md-2 control-label" for="telefone">Telefone:</label>
              <div class="col-sm-4">
                <input name="telefone" type="text" class="form-control forma" onkeypress="return SomenteNumero(event)" required="">
              </div>
          </div>
          <div class="form-group">
              <label class="col-md-2 control-label" for="versao">Versão</label>
                <div class="col-sm-4">
                  <input id="versao" name="versao" type="text" class="form-control" required="">
                </div>
              <label class="col-md-2 control-label" for="sistema">Sistema:</label>
                <div class="col-sm-4">
                  <input name="sistema" type="text" class="form-control" required="">
                </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="descproblema">Descrição do problema:</label>
              <div class="col-sm-10">
                <textarea name="descproblema" class="form-control label1" required=""></textarea>
              </div>
          </div>
            <!-- Button -->
            <div class="col-md-12 text-center">
              <?php include("statusDados.php");?>
              <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Salvar</button>
            </div>
        </form>
      </div>
      <br/>
      <br/>
      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
      <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <script src="js/links.js"></script>
      <script src="js/apiConsulta.js"></script>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
      <script type="text/javascript">
        function refresh_usuarios() {
          var url = "atendentedispo.php";
          jQuery("#usuarios").load(url);
        }

        $(function() {
          refresh_usuarios(); //first initialize
        });
        setInterval(function() {
          refresh_usuarios() // this will run after every 5 seconds
        }, 5000);
        function erro() {
          alert('Acesso negado! Redirecinando a pagina principal.');
          window.location.assign("home.php");
        }
        $(function() {
          $("#skills").autocomplete({
            source: 'search.php'
          });
        });
      </script>
</body>
</html>