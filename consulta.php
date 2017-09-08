<!Doctype html>
<html >
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="imagem/favicon.ico" />
    <meta charset="utf-8"/>
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
  </head>
  <body>
  <?php
header('Content-Type: text/html; charset=UTF-8');
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
// Verifica se não há  variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID'])) {
// Destrói a sessão por segurança
session_destroy();
// Redireciona o visitante de volta pro login
header("Location: index.php"); exit;
}
$email = md5( $_SESSION['Email']);
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation
            </span>
            <span class="icon-bar">
            </span>
            <span class="icon-bar">
            </span>
            <span class="icon-bar">
            </span>
          </button>
          <a class="navbar-brand" href="#">German Tech Controle de chamados
          </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
          <?php 
          if($_SESSION['UsuarioNivel'] == 2) {
           echo '<li>
               <a href="home.php"><span class="glyphicon glyphicon-home"></span>&nbsp&nbspHome
              </a>
            </li>';}
            ?>
            <li>
              <a href="empresa.php"><span class="glyphicon glyphicon-folder-open"></span>&nbsp&nbspClientes
              </a>
            </li>
          </ul>
          
           <ul class="nav navbar-nav">
            <li class="dropdown">
             <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list"></span>&nbsp&nbspChamados 
                <span class="caret">
                </span>
              </a>
              <ul class="dropdown-menu">
               <?php 
          if($_SESSION['UsuarioNivel'] == 2) {
               echo '<li>
                  <a href="chamados.php">Atendimentos
                  </a>
                </li>
                <li role="separator" class="divider">
                </li>
                <li>
                  <a href="cad_chamado.php">Novo Chamado
                  </a>
                </li>
                <li role="separator" class="divider">
                </li>';}?>
                <li>
                  <a href="chamadoespera.php">Novo Chamado Em Espera
                  </a>
                </li>
            </ul>
          </ul>
            <ul class="nav navbar-nav navbar-right">
              <li>
              <a href="plantao.php"><span class="glyphicon glyphicon-plus"></span>&nbsp&nbspPlantão</a>
            </li>
          <?php if($_SESSION['UsuarioNivel'] == 2) {
            echo '<ul class="nav navbar-nav">
          <li class="dropdown">
             <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-tasks"></span>&nbsp&nbspRelatórios 
                <span class="caret">
                </span>
              </a>
              <ul class="dropdown-menu">
            <li>
              <a href="relatorio.php">Chamados por atendente
              </a>
            </li>
            <li role="separator" class="divider">
            </li>
            <li>
              <a href="relatorioempre.php">Empresas Solicitantes 
              </a>
            </li>
            <li role="separator" class="divider">
            </li>
          </ul>
          </ul>';}?>
           <ul class="nav navbar-nav">
            <li class="dropdown">
             <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span> 
                <span class="caret">
                </span>
              </a>
              <ul class="dropdown-menu">
              <li>
              <a style="padding-left:10px;" href="meuschamados.php"><?php echo "<img src='https://www.gravatar.com/avatar/$email' width='25px'>";?>
                <?php echo $_SESSION['UsuarioNome']; ?> 
                <span class="sr-only">(current)
                </span>
              </a>
            </li>
            <li role="separator" class="divider">
            </li>
            <li>
              <a href="alterasenha.php">Alterar senha
              </a>
            </li>
            <li role="separator" class="divider"></li>

            <li><a href="logout.php">Sair</a></li>
            <li role="separator" class="divider"></li>
          </ul>
          </li>
          </ul>
          </ul>
      </div>
    <!-- /.navbar-collapse -->
    </div>
  <!-- /.container-fluid -->
  </nav>
<br/>
<br/>
<br/>
<br/>
<div class="container">
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
    <?php 
include 'include/dbconf.php';
$conn->exec('SET CHARACTER SET utf8');
$id=$_GET['id_chamado'];
$sql = $conn->prepare("SELECT * FROM chamado WHERE id_chamado=$id");
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);
//header("Content-type: text/html; charset=iso-8859-1");
?> 
    <div class="alert alert-success" role="alert">
      <center>Consulta Chamado Nº: 
        <?php echo $id?> 
      </center>
    </div>
    <form class="form-vertical" action="chamados.php" method="POST">
  
        <div class="form-group form">
          <label class="col-md-4 control-label empresa disabled">Empresa solicitante:
          </label>  
            <input value='<?php echo $row['empresa'];?>'name="empresa" type="text" disabled class="form-control label1 disabled" required/>
          <label class="col-md-4 control-label empresa disabled" for="nome">Contato:
          </label>  
          <input value='<?php echo $row['contato'];?>' id="nome" name="contato" type="text" disabled class="form-control label2 disabled" required/>
          <label class="col-md-4 control-label empresa disabled">Forma de contato:
          </label>
          <select name="formacontato" class="form-control forma disabled" disabled>
            <option>
              <?php echo $row['formacontato'];?>
            </option>
          </select>
    
          <label class="col-md-4 control-label empresa disabled" for="cep">Telefone:
          </label>  
          <input value='<?php echo $row['telefone'];?>' disabled name="telefone" type="text" class="form-control label2 disabled" onkeypress="return SomenteNumero(event)">
          <label class="col-md-4 control-label empresa disabled">Módulo:
          </label>
          <select name="modulo" class="form-control forma disabled" disabled>
            <option>
              <?php  echo $row['modulo'];?>
            </option>
          </select>
          <label class="col-md-4 control-label empresa disabled" >Versão:
          </label>  
          <input value='<?php  echo $row['versao'];?>' disabled name="versao" type="text" class="form-control label2 disabled" onkeypress="return SomenteNumero(event)">
          <label class="col-md-4 control-label empresa disabled">Categoria:
          </label>
          <select name="categoria" disabled class="form-control forma disabled">
            <option value="Manager">
              <?php  echo $row['categoria'];?>
            </option>
          </select>
      
          <label class="col-md-4 control-label empresa disabled">Data inicio: 
          </label >
          <input class="form-control label2 disabled" disabled value='<?php echo $row['datainicio']?>'> 
          <label class="col-md-4 control-label empresa disabled">Data término: 
          </label>
          <input class="form-control forma disabled" disabled value='<?php echo $row['datafinal']?>'> 
          <label class="col-md-4 control-label empresa disabled">Responsavel: 
          </label>
          <input class="form-control label1 disabled" disabled value='<?php echo $row['usuario']?>'> 
      
          <label class="col-md-4 control-label empresa">Descrição do problema:
          </label>
          <textarea name="descproblema" class="form-control label1 disabled" disabled ><?php echo $row['descproblema'];?></textarea>
   
          <label class="col-md-4 control-label empresa">Solução:
          </label>
          <textarea name="descsolucao" class="form-control label1 disabled" disabled ><?php echo $row['descsolucao'];?></textarea>
          </div>
        <!-- Button -->
        <div class="col-md-12 text-center">
          <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Retornar
          </button>
        </div>
    </form>
  </div>
  <br/>
  <br/>
  </body>
</html>
