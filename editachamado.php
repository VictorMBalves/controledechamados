<!Doctype html>
<html >
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
      header("Content-type: text/html; charset=utf-8");
      if (!isset($_SESSION)) {
        session_start();
      }
      if ($_SESSION['UsuarioNivel'] == 1) {
        echo'<script>erro()</script>';
      }else{
        if (!isset($_SESSION['UsuarioID'])) {
          session_destroy();
          header("Location: index.php");
          exit;
        }
      }
      include('include/dbconf.php');
      $conn->exec('SET CHARACTER SET utf8');
      $id=$_GET['id_chamado'];
      $sql = $conn->prepare("SELECT * FROM chamado WHERE id_chamado=$id");
      $sql->execute();
      $row = $sql->fetch(PDO::FETCH_ASSOC);
      $empresa = $row['empresa'];
      $sql2 = $conn->prepare("SELECT backup FROM empresa WHERE nome = '$empresa'");
      $sql2->execute();
      $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
      $email = md5($_SESSION['Email']);
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
          </div>
        </h1>
        <br>
        <div class="row">
          <hr/>
        </div>
        <div class="alert alert-success" role="alert">
          <center>Editar Chamado Nº: <?php echo $id?></center>
        </div>
        <form class="form-horizontal" action="updatechamado.php" method="POST">
          <input style="display:none;"  name='id_chamado' value='<?php echo $id; ?>'/>
          <div class="form-group">
            <label class="col-md-2 control-label" for="empresa">Empresa solicitante:</label> 
              <div class="col-sm-10"> 
                  <input value='<?php echo $row['empresa'];?>'name="empresa" type="text" class="form-control readonly" readonly>
              </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="contato">Contato:</label>  
              <div class="col-sm-10">
                <input value='<?php echo $row['contato'];?>' name="contato" type="text" class="form-control" required="">
              </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="formacontato">Forma de contato:</label>  
              <div class="col-sm-4">
                <select name="formacontato" type="text" class="form-control forma" required="">
                  <option>
                  <?php echo $row['formacontato'];?>
                  </option>
                  <option></option>
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
              </div>
            <label class="col-md-2 control-label" for="versao">Versão:</label>
              <div class="col-sm-4">
                <input type="text" name="versao" class="form-control" required="" value="<?php echo $row['versao'] ?>">
              </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="telefone">Telefone</label>  
              <div class="col-sm-4">
                <input value='<?php echo $row['telefone'];?>' data-mask="(999)9999-9999" name="telefone" type="text" class="form-control label2" onkeypress="return SomenteNumero(event)" required="">
              </div>
            <label class="col-md-2 control-label" for="sistema">Sistema:</label>  
              <div class="col-sm-4">
                <select name="sistema" type="text" class="form-control" required="">
                  <option>
                  <?php echo $row['sistema'];?>
                  </option>
                  <option></option>
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
              </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="backup">Backup:</label> 
              <div class="col-sm-4"> 
                <select name="backup" class="form-control" required="">
                  <?php 
                    if ($row2['backup'] == 0) {
                      echo "<option value='0'>Google drive não configurado</option>";
                    } else {
                      echo "<option value='1'>Google drive configurado</option>";
                    }
                  ?>
                  <option>
                  </option>
                  <option value="1">Google drive configurado
                  </option>
                  <option value="0">Google drive não configurado
                  </option>
                </select>
              </div>
            <label class="col-md-2 control-label" for="categoria">Categoria:</label>  
              <div class="col-sm-4">
                <select name="categoria" type="text" class="form-control forma" required="">
                  <option>
                  <?php echo $row['categoria'];?>
                  </option>
                  <option></option>
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
              </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="descproblema">Descrição do problema:</label>
              <div class="col-sm-10">
                <textarea name="descproblema" type="text" class="form-control label1" required=""><?php echo $row['descproblema'];?></textarea>
              </div>
          </div>
          <div class="col-md-12 text-center">
            <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Alterar</button>
            <button id="singlebutton" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning" onclick="cancelar()">Cancelar</button>
          </div>
        </form>
      </div>
      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
      <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>         
      <script src="js/links.js" ></script>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
      <script>
        function erro(){
          alert('Acesso negado! Redirecinando a pagina principal.');
          window.location.assign("chamadoespera.php");
        }
        $(function() {
          $( "#skills" ).autocomplete({
            source: 'search.php'
          });
        });
        function cancelar(){
          window.location.assign("chamados.php");
        }
      </script>

    </body>
</html>
