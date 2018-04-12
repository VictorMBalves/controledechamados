<!Doctype html>
<html>
    <head> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8" />
        <link rel="shortcut icon" href="imagem/favicon.ico" />
        <title>Controle de Chamados
        </title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="datatables/datatables.min.css" rel="stylesheet">
        <link href="datatables/responsive.dataTables.min.css" rel="stylesheet">
        <link href="datatables/rowReorder.dataTables.min.css" rel="stylesheet">
    </head>
  <body>
<?php
  header("Content-type: text/html; charset=utf-8");
  if (!isset($_SESSION)) {
      session_start();
  }
  if (!isset($_SESSION['UsuarioID'])) {
      session_destroy();
      header("Location: index.php");
      exit;
  }
  $email = md5($_SESSION['Email']);
  include('include/menu.php');
?>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>

<div class="container-fluid">
    <table id="myTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Telefone</th>
                <th>Versão</th>
                <th>Sistema</th>
            </tr>
            <tbody>
                </tbody>
            </thead>
        <div class="col-sm-12 text-center" id="loading"></div>
    </table>
</div>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="js/links.js"></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="datatables/datatables.min.js"></script>
    <script src="datatables/responsive.min.js"></script>
    <script src="datatables/rowReorder.min.js"></script>
    <script src="js/tabelas/dadosempresaapi.js"></script>
</body>
</html> 
