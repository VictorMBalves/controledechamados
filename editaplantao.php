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
    </script>
  </head>
  <body>
<?php
  header("Content-type: text/html; charset=utf-8");
  // A sessão precisa ser iniciada em cada página diferente
  if (!isset($_SESSION)) session_start();
  // Verifica se não há a variável da sessão que identifica o usuário
  if($_SESSION['UsuarioNivel'] == 1) {
  echo'<script>erro()</script>';
  }  else {
  if (!isset($_SESSION['UsuarioID'])) {
  // Destrói a sessão por segurança
  session_destroy();
  // Redireciona o visitante de volta pro login
  header("Location: index.php"); exit;
  }}
  $email = md5( $_SESSION['Email']);
  include('include/menu.php');
?>
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
$id=$_GET['id_plantao'];
$sql = $conn->prepare("SELECT * FROM plantao WHERE id_plantao=$id");
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);
$empresa = $row['empresa'];
$sql2 = $conn->prepare("SELECT backup FROM empresa WHERE nome = '$empresa'");
$sql2->execute();
$row2 = $sql2->fetch(PDO::FETCH_ASSOC);
?>
    </div>
    <div class="alert alert-success" role="alert">
      <center>Editar plantão Nº: 
        <?php echo $id?>
      </center>
    </div>
    <form class="form-vertical" action="updateplantao.php" method="POST">
      <fieldset>
        <!-- Text input-->
        <div class="form-group form">
           <input style="display:none;"  name='id_plantao' value='<?php echo $id; ?>'/>

        <label class="col-md-4 control-label empresa" for="empresa">Empresa solicitante:</label>  
              <input value='<?php echo $row['empresa'];?>'name="empresa" type="text" class="form-control label1 disabled" disabled required="">
            
        <label class="col-md-4 control-label empresa" for="contato">Contato:</label>  
              <input value='<?php echo $row['contato'];?>' name="contato" type="text" class="form-control label2" required="">
            
        <label class="col-md-4 control-label empresa" for="formacontato">Forma de contato:</label>  
              <select name="formacontato" type="text" class="form-control forma" required="">
                  <option>
                  <?php echo $row['formacontato'];?>
                  </option>
                  <option value="Cliente ligou">Cliente ligou
                  </option>
                  <option value="Ligado para o cliente">Ligado para o cliente
                  </option>
                  <option value="Whatsapp">Whatsapp
                  </option>
                  <option value="Team Viewer">Team Viewer
                  </option>
                  <option value="Skype">Skype
                  </option>
              </select>

        <label class="col-md-4 control-label empresa" for="telefone">Telefone</label>  
              <input value='<?php echo $row['telefone'];?>' name="telefone" type="text" class="form-control label2" onkeypress="return SomenteNumero(event)" required="">

        <label class="col-md-4 control-label empresa" for="modulo">Módulo:</label>  
              <select name="modulo" type="text" class="form-control forma" required="">
                  <option>
                  <?php echo $row['modulo'];?>
                  </option>
                  <option value="Manager">Manager
                  </option>
                  <option value="Light">Light
                  </option>
                  <option value="Gourmet">Gourmet
                  </option>
                  <option value="Fiscal">Fiscal
                  </option>
                  <option value="Folha">Folha
                  </option>
              </select>

              <label class="col-md-4 control-label empresa" for="backup">Backup:</label>  
              <select name="backup" class="form-control label2">
                <option>
                    <?php if($row2['backup'] == 0){echo "Google drive não configurado";}else{echo "Google drive configurado";}?>
                </option>
                <option>
                  </option>
                  <option value="1">Google drive configurado
                  </option>
                  <option value="0">Google drive não configurado
                  </option>
              </select>

        <label class="col-md-4 control-label empresa" for="categoria">Categoria:</label>  
              <select name="categoria" type="text" class="form-control forma" required="">
                  <option>
                   <?php echo $row['categoria'];?>
                  </option>
                  <option value="Erro">Erro
                  </option>
                  <option value="Duvida">Duvida
                  </option>
                  <option value="Atualização sistema">Atualização sistema
                  </option>
                  <option value="Sugestão de melhoria">Sugestão de melhoria
                  </option>
                  <option value="Outros">Outros
                  </option>
              </select>

        <label class="col-md-4 control-label empresa" for="descproblema">Descrição do problema:</label>  
              <textarea name="descproblema" type="text" class="form-control label1" required=""><?php echo $row['descproblema'];?></textarea>
        <div class="col-md-12 text-center">

            <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Alterar</button>
            
            <button id="singlebutton" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning" onclick="cancelar3()">Cancelar</button>
        </div>
        
         </fieldset>
    </form>
  </div>
  </body>
  <br/>
  <br/>
</html>
