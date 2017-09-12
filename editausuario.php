<!Doctype html>
<html >
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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js">
    </script>
    <script>
     function erro(){
        alert('Acesso negado! Redirecinando a pagina principal.');
        window.location.assign("home.php");
      }
       function cancelar(){
        window.location.assign("chamados.php");
      } 

      function deletado(){
        alert('Cadastro deletado com sucesso!');
        window.location.assign("cad_usuario.php");
      }

       $(function () {
  $('[data-toggle="popover"]').popover()
})
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
function atualizarTarefas() {
           // aqui voce passa o id do usuario
           var url="notifica.php";
            jQuery("#tarefas").load(url);
        }
        setInterval("atualizarTarefas()",1000);
      </script>
  </head>
  <body>
  <?php
header("Content-type: text/html; charset=utf-8");
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
if(!($_SESSION['UsuarioNivel'] == 3)) {
  echo'<script>erro()</script>';
  }  else {
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID'])) {
// Destrói a sessão por segurança
session_destroy();
// Redireciona o visitante de volta pro login
header("Location: index.php"); exit;
}
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
          if($_SESSION['UsuarioNivel'] == 2 || 3) {
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
          if($_SESSION['UsuarioNivel'] == 2 || 3) {
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
          <?php if($_SESSION['UsuarioNivel'] == 2 || 3) {
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
                <!--adsdad-->
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
      <center>Editar cadastro de usuário:
      </center>
    </div>
    <?php 
include 'include/dbconf.php';
$conn->exec('SET CHARACTER SET utf8');
$id=$_GET['id'];
$sql = $conn->prepare("SELECT * FROM usuarios WHERE id=$id");
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);
$epr = "";

if(isset($_GET['epr'])) {
    $epr=$_GET['epr'];
  }
  if($epr=='excluir'){
      $id=$_GET['id'];
      $query = $conn ->prepare("DELETE FROM usuarios WHERE id=$id");
      $query->execute();
       echo "<script>deletado()</script>";  
  }

?>
    <div class="text-right">
     <?php echo "<a href='editausuario.php?id=".$row['id']."&epr=excluir'><button type='reset' class='btn btn-danger'data-toggle='tooltip' data-placement='left' title='Excluir cadastro!'><span class='glyphicon glyphicon-trash'></span></button></a>"; ?>
    </div>
    <form class="form-vertical" action="updateusuario.php" method="POST">
      <fieldset>
        <!-- Text input-->
        <div class="form-group form">
          <input style="display:none;"  name='id' value='<?php echo $id; ?>'readonly/>  
          <label class="col-md-4 control-label empresa" for="nome">Nome:
          </label>  
          <input name="nome" type="text" class="form-control label1" value="<?php echo $row['nome']?>" required="">
          <br/>
            <label class="col-md-4 control-label empresa" for="usuario" id="usuario">Login:
          </label> 
          <input name="usuario" type="text" class="form-control label1" value="<?php echo $row['usuario']?>" required="">
          <div id="resultado"></div> 
          <label class="col-md-4 control-label empresa" for="usuario">E-mail
          </label>  
          <input name="email" type="email" class="form-control label1" value="<?php echo $row['email']?>" required="">
          <br/>
           <label class="col-md-4 control-label empresa" for="senha">Senha:
          </label>  
          <input name="senha" type="password" class="form-control label1" required="">
          <br/>
          <label class="col-md-4 control-label empresa">Nivel
          </label>
          <select name="nivel" class="form-control label1" required="">
            <option value="3">Suporte Avançado
            </option>
            <option value="2">Help-Desk
            </option>
            <option value="1">Financeiro
            </option>
          </select>
        </div>
        <br/>
        <!-- Button -->
        <div class="col-md-12 text-center">
          <button type="submit" id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Cadastrar</button>
          <button type="reset" class="btn btn-group-lg btn-warning" onclick="cancelar4()">Cancelar</button>
      </div>    
        
         </fieldset>
    </form>
      </div>
</br>
</br>
</br>
</body>
</html>