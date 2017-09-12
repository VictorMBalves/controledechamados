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
        window.location.assign("chamadoespera.php");
      }  
      $(function() {
        $( "#skills" ).autocomplete({
          source: 'search.php'
        }
                                   );
      }
       );
       function cancelar(){
        window.location.assign("chamados.php");
      }
      function deletado(){
        alert('Cadastro deletado com sucesso!');
        window.location.assign("empresa.php");
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
    
    </script>
  </head>
  <body>
  <?php
header("Content-type: text/html; charset=utf-8");
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID'])) {
// Destrói a sessão por segurança
session_destroy();
// Redireciona o visitante de volta pro login
header("Location: index.php"); exit;
}
include 'include/dbconf.php';
$conn->exec('SET CHARACTER SET utf8');
$epr='';
$msg='';

if(isset($_GET['epr'])) {
  $epr=$_GET['epr'];
}
if($epr=='excluir'){
    $id=$_GET['id_empresa'];
    $query = $conn ->prepare("DELETE FROM empresa WHERE id_empresa=$id");
    $query->execute();
     echo "<script>deletado()</script>";  
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
            
         </ul>
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
          
           <?php
               if($_SESSION['UsuarioNivel'] == 3){
           
                 echo ' <li role="separator" class="divider">
                         </li>         
                         <li>
                         <a href="cad_usuario.php">Cadastrar usuário
                         </a>
                       </li>';
                        }
           ?>
           <li role="separator" class="divider">
           </li>
           <li>
             <a href="alterasenha.php">Alterar senha
             </a>
           </li>
            <li role="separator" class="divider">
           </li>
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
      <?php 
include 'include/dbconf.php';
$conn->exec('SET CHARACTER SET utf8');
$id=$_GET['id_empresa'];
$sql = $conn->prepare("SELECT * FROM empresa WHERE id_empresa=$id");
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);
?>
    </div>
    <div class="alert alert-success" role="alert">
      <center>Editar empresa ID: 
        <?php echo $id?>
      </center>
    </div>
    <div class="text-right">
     <?php echo "<a href='editaempresa.php?id_empresa=".$row['id_empresa']."&epr=excluir'><button type='reset' class='btn btn-danger'data-toggle='tooltip' data-placement='left' title='Excluir cadastro!'><span class='glyphicon glyphicon-trash'></span></button></a>"; ?>
    </div>
    <form class="form-vertical" action="updateempresa.php" method="POST">
      <fieldset>
        <!-- Text input-->
       
        <br />
        
        <div class="form-group form">
          <input style="display:none;"  name='id_empresa' value='<?php echo $id; ?>'readonly/>
          <label class="col-md-4 control-label empresa">Razão Social:
          </label>  
          <input value='<?php echo $row['nome'];?>'name="empresa" type="text" class="form-control label1" required="">
          <br/>
            <label class="col-md-4 control-label empresa">CNPJ:
          </label>  
          <input value='<?php echo $row['cnpj'];?>'name="cnpj" data-mask="99.999.999/9999-99" type="text" class="form-control label1" required="">
          <br/>
           <label class="col-md-4 control-label empresa">Telefone:
          </label>  
          <input value='<?php echo $row['telefone'];?>'name="telefone" data-mask="(999)9999-9999" type="text" class="form-control label1" required="">
          <br/>
           <label class="col-md-4 control-label empresa">Celular:
          </label>  
          <input value='<?php echo $row['celular'];?>' name="celular" data-mask="(999)99999-9999" type="text" class="form-control label1" required="">
          <br/>
          <label class="col-md-4 control-label empresa">Situação:
          </label>
          <select name="situacao" class="form-control label1">
            <option>
            <?php echo $row['situacao'];?>
            </option>
             <option>
            </option>
            <option value="ATIVO">Ativo
            </option>
            <option value="BLOQUEADO">Bloqueado
            </option>
            <option value="DESISTENTE">Desistente
            </option>
          </select>
        </div>
        <br/>
        <!-- Button -->
        <div class="col-md-12 text-center">
          <button type="submit" id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Alterar</button>
          <button type="reset" class="btn btn-group-lg btn-warning" onclick="cancelar2()">Cancelar</button>
          
      </div>    
        
         </fieldset>
    </form>
  </div>
  </body>
</html>
