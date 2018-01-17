<!Doctype html>
<html >
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8"/>
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
include('include/menu.php');
?>
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
$id=$_GET['id_plantao'];
$sql = $conn->prepare("SELECT * FROM plantao WHERE id_plantao=$id");
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);
$empresa = $row['empresa'];
$sql2 = $conn->prepare("SELECT backup FROM empresa WHERE nome = '$empresa'");
$sql2->execute();
$row2 = $sql2->fetch(PDO::FETCH_ASSOC);
//header("Content-type: text/html; charset=iso-8859-1");
?> 
    <div class="alert alert-success" role="alert">
      <center>Consulta Plantão Nº: 
        <?php echo $id?> 
      </center>
    </div>
    <form class="form-vertical" action="plantao.php" method="POST">
  
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
          <label class="col-md-4 control-label empresa disabled" >backup:
          </label>  
          <select id="backup" disabled name="backup" class="form-control label2 disabled">
            <option>
              <?php if($row2['backup'] == 0){echo "Google drive não configurado";}else{echo "Google drive configurado";}?>
            </option>
          </select>
          <label class="col-md-4 control-label empresa disabled">Categoria:
          </label>
          <select name="categoria" disabled class="form-control forma disabled">
            <option value="Manager">
              <?php  echo $row['categoria'];?>
            </option>
          </select>
      
          <label class="col-md-4 control-label empresa disabled">Data inicio: 
          </label >
          <input class="form-control label2 disabled" disabled value='<?php if(is_null($row['datainicio'])){ echo $row['data'].' '.$row['horainicio'].':00';} else {echo $row['datainicio'];}?>'> 
          <label class="col-md-4 control-label empresa disabled">Data término: 
          </label>
          <input class="form-control forma disabled" disabled value='<?php if(is_null($row['datafinal'])){ echo $row['data'].' '.$row['horafim'].':00';} else {echo $row['datafinal'];}?>'> 
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
