<!Doctype html>
  <html >
    <head>
      <title>Controle de Chamados</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
      <meta name="viewport" content="width=device-width, initial-scale=1"/>
      <meta charset="utf-8"/>
      <link rel="shortcut icon" href="imagem/favicon.ico" />
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <link href="css/bootstrap.css" rel="stylesheet">
      <link href="css/cad.css" rel="stylesheet">
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
      <div class="row">
        <hr/>
        <?php 
  $conn->exec('SET CHARACTER SET utf8');
  $id=$_GET['id_plantao'];
  $sql = $conn->prepare("SELECT * FROM plantao WHERE id_plantao = :id");
  $sql->bindParam(":id", $id, PDO::PARAM_INT);
  $sql->execute();
  $row = $sql->fetch(PDO::FETCH_ASSOC);
  ?>
      </div>
      <div class="alert alert-success" role="alert">
        <center>Finalizar Chamado Nº: 
          <?php echo $id?>
        </center>
      </div>
      <form class="form-vertical" action="altera_plantao.php" method="POST">

        <input style="display:none;"  name='id_plantao' value='<?php echo $id; ?>'/>

        <label class="col-md-4 control-label empresa" for="empresa">Empresa solicitante:</label>  
              <input value='<?php echo $row['empresa'];?>'name="empresa" type="text" class="form-control label1" required="">
            
        <label class="col-md-4 control-label empresa" for="contato">Contato:</label>  
              <input value='<?php echo $row['contato'];?>' name="contato" type="text" class="form-control label2" required="">
            
        <label class="col-md-4 control-label empresa" for="formacontato">Forma de contato:</label>  
              <select name="formacontato" type="text" class="form-control forma" required="">
                  <option>
                    <?php echo $row['formacontato'];?>
                  </option>
              </select>

        <label class="col-md-4 control-label empresa" for="telefone">Telefone</label>  
              <input value='<?php echo $row['telefone'];?>' name="telefone" type="text" class="form-control label2" onkeypress="return SomenteNumero(event)" required="">

        <label class="col-md-4 control-label empresa" for="modulo">Módulo:</label>  
              <select name="modulo" type="text" class="form-control forma" required="">
                  <option>
                    <?php echo $row['modulo'];?>
                  </option>
              </select>

              <label class="col-md-4 control-label empresa" for="backup">Backup:</label>  
              <select name="backup" class="form-control label2">
                <option>
                    <?php if ($row2['backup'] == 0) {
      echo "Google drive não configurado";
  } else {
      echo "Google drive configurado";
  }?>
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
              </select>

        <label class="col-md-4 control-label empresa" for="descproblema">Descrição do problema:</label>  
              <textarea name="descproblema" type="text" class="form-control label1" required=""><?php echo $row['descproblema'];?></textarea>

        <label class="col-md-4 control-label empresa" for="descsolucao">Solução:</label>  
              <textarea name="descsolucao" type="text" class="form-control label1" required=""><?php echo $row['descsolucao'];?></textarea>
        
        <div class="col-md-12 text-center">

            <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Finalizar</button>
            
            <button id="singlebutton" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning" onclick="cancelar3()">Cancelar</button>
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
