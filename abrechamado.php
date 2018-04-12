<!Doctype html>
<html>
    <head>
      <title>Controle de Chamados</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta charset="utf-8"/>
      <link rel="shortcut icon" href="imagem/favicon.ico" />  
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <link href="css/bootstrap.css" rel="stylesheet">
    </head>

  <body>
    <?php
      include 'include/dbconf.php';
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
      $conn->exec('SET CHARACTER SET utf8');
      $id=$_GET['id_chamado'];
      $sql = $conn->prepare("SELECT * FROM chamado WHERE id_chamado = :id");
      $sql->bindParam(":id", $id, PDO::PARAM_INT);
      $sql->execute();
      $row = $sql->fetch(PDO::FETCH_ASSOC);
      $empresa = $row['empresa'];
      $sql2 = $conn->prepare("SELECT backup FROM empresa WHERE nome = '$empresa'");
      $sql2->execute();
      $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
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
          <div class="row">
            <hr/>
          </div>
          <div class="alert alert-success" role="alert">
            <center>Finalizar Chamado Nº: 
              <?php echo $id?>
            </center>
          </div>
          <form class="form-horizontal" action="altera_chamado.php" method="POST">
            <input style="display:none;"  name='id_chamado' value='<?php echo $id; ?>'/>
            <div class="form-group">
              <label for="empresa" class="col-sm-2 control-label">Empresa solicitante:</label>  
                <div class="col-sm-10">
                  <input value='<?php echo $row['empresa'];?>'name="empresa" type="text" class="form-control disabled" readonly required="">
                </div>
            </div>  
            <div class="form-group">
              <label for="contato" class="col-sm-2 control-label">Contato:</label> 
                <div class="col-sm-10">
                  <input value='<?php echo $row['contato'];?>' name="contato" type="text" class="form-control" required="">
                </div>
            </div>
            <div class="form-group">
              <label for="formacontato" class="col-sm-2 control-label">Forma de contato:</label> 
                <div class="col-sm-4"> 
                  <select name="formacontato" type="text" class="form-control" required="">
                    <option>
                      <?php echo $row['formacontato'];?>
                    </option>
                  </select>
                </div>
              <label for="versao" class="col-sm-2 control-label">Versão:</label>
                <div class="col-sm-4">
                  <input class="form-control" value="<?php echo $row['versao']?>" type="text" required="">
                </div>
            </div>
            <div class="form-group">
              <label for="telefone" class="col-sm-2 control-label">Telefone:</label>  
                <div class="col-sm-4">
                  <input value='<?php echo $row['telefone'];?>' data-mask="(999)9999-9999" name="telefone" type="text" class="form-control" onkeypress="return SomenteNumero(event)" required="">
                </div>
              <label for="sistema" class="col-sm-2 control-label">Sistema:</label>
                <div class="col-sm-4">  
                  <select name="sistema" type="text" class="form-control" required="">
                    <option>
                      <?php echo $row['sistema'];?>
                    </option>
                  </select>
                </div>
            </div>
            <div class="form-group">
              <label for="backup" class="col-sm-2 control-label">Backup:</label>  
                <div class="col-sm-4">  
                  <select name="backup" class="form-control">
                    <option>
                      <?php 
                        if ($row2['backup'] == 0) {
                            echo "Google drive não configurado";
                        } else {
                            echo "Google drive configurado";
                        }
                      ?>
                    </option>
                  </select>
                </div>
              <label for="categoria" class="col-sm-2 control-label">Categoria:</label>
                <div class="col-sm-4">  
                  <select name="categoria" type="text" class="form-control" required="">
                    <option>
                      <?php echo $row['categoria'];?>
                    </option>
                  </select>
                </div>
            </div>
            <div class="form-group">
              <label for="descproblema" class="col-sm-2 control-label">Descrição do problema:</label>
                <div class="col-sm-10">  
                  <textarea name="descproblema" type="text" class="form-control" required=""><?php echo $row['descproblema'];?></textarea>
                </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="descsolucao">Solução:</label>  
                <div class="col-sm-10">
                  <textarea name="descsolucao" type="text" class="form-control" required=""><?php echo $row['descsolucao'];?></textarea>
                </div>
            </div>
            <div class="text-center">
                <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Finalizar</button>
                <button id="singlebutton" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning" onclick="cancelar()">Cancelar</button>
            </div>
          </form>
          </div>
    </br>
    </br>
    
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
      function cancelar(){
        window.location.assign("chamados.php");
      }
    </script>
  </body>
</html>
