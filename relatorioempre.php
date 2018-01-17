<!doctype html>
<html>
  <head> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" /> 
    <link rel="shortcut icon" href="imagem/favicon.ico" />
    <title>Controle de Chamados
    </title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js">
    </script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js">
    </script>         
    <script src="js/links.js" >
    </script>
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js">
    </script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js">
    </script>
    <link href="css/cad.css" rel="stylesheet">
    <script src="js/bootstrap.min.js">
    </script>
    <script>
    function erro(){
        alert('Acesso negado! Redirecinando a pagina principal.');
        window.location.assign("chamadoespera.php");
      }
      $(function() {
        $( "#skills" ).autocomplete({
          source: 'search.php'
        }
                                   );
      }
       );
    </script>
    <style>
      .table1{
        width:80%;
      }
      .circle{
        display:block;
        left:100px;
        width:30px;
        height:10px;
        margin: 0px;
        padding: 0px;
        border-radius:50px;
        background-color:#5CB85C;
        box-shadow: none;
      }
      .circle2{
        display:block;
        left:100px;
        width:30px;
        height:10px;
        border-radius:50px;
        background-color:#E3333A;
        box-shadow: none;
      }
    </style>
  </head>
  <body>
<?php
  header("Content-type: text/html; charset=utf-8");
  if (!isset($_SESSION)) {
      session_start();
  }
  if ($_SESSION['UsuarioNivel'] == 1) {
      echo'<script>erro()</script>';
  } else {
      if (!isset($_SESSION['UsuarioID'])) {
          session_destroy();
          header("Location: index.php");
          exit;
      }
  }
  $email = md5($_SESSION['Email']);
  include('include/menu.php');
?>
<br/>
<br/>
<br/>
<br/>
<br>
<div class="row">
  <hr/>
</div>
<div class="alert alert-success" role="alert">
  <center>Relatório de Nº de chamados por empresa:
  </center>
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
<div class="container">
  <div class="row">
    <h1>
      <div class="row">
        <div class="col-xs-6 col-md-3">
          </a>
      </div>
    </h1>
  </div>
  <form class="navbar-form text-center" method="POST" action="relatorioempre.php">
    <fieldset>
      <legend>Período:
      </legend>
      <label style="padding-left:15px; padding-right:10px;" class="control-label">De:
      </label>
      <input type="date" value="<?php echo $data;?>" name="data" class="form-control">
      <label style="padding-left:15px; padding-right:10px;" class="control-label">Até:
      </label>
      <input style="padding-right:15px;" type="date" value="<?php echo $data2;?>" name="data1" class="form-control">
      <label style="padding-left:15px; padding-right:10px;" class="control-label">Numero de Registros:
      </label>
      <input style="padding-right:15px; width:65px;" type="number" value="10" name="limite" class="form-control">
      <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Buscar
      </button>
    </fieldset>
  </form> 
  <br>
  <div class="row">
    <hr/>
  </div>    
  <?php
include 'include/dbconf.php';
if (array_key_exists('data', $_POST)) {
    $data=$_POST['data'];
    $data2=$_POST['data1'];
    $limite=$_POST['limite'];
} else {
    $data = time('Y-m-d');
    $data2 = time('Y-m-d');
    $limite='10';
}

if (array_key_exists('data', $_POST)) {
    $data=$_POST['data'];
    $data2=$_POST['data1'];
    $limite=$_POST['limite'];
    echo '<div teste table-responsive table-hover">';
    echo '<table class="table table-striped text-center">';
    echo '<thead>';
    echo '<tr class="text-center">';
    echo '<th class="text-center">Nº de Chamados</th>';
    echo '<th class="text-center">Empresa</th>';
    echo '</tr>';
    echo '</thead>';

    echo '<tbody>';
    $conn->exec('SET CHARACTER SET utf8');
    $query = $conn->prepare("SELECT COUNT(empresa), empresa FROM chamado WHERE date(datainicio) BETWEEN '$data' and '$data2' GROUP BY empresa ORDER BY COUNT(empresa) DESC LIMIT $limite");
    $query->execute();
    foreach ($query as $row) {
        echo'<tr>';
        echo'<td >'.$row['COUNT(empresa)'].'</td>';
        echo'<td>'.$row['empresa'].'</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}
?>
  </body>
</html>
