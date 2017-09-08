<!Doctype html>
  <html >
    <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <link rel="shortcut icon" href="imagem/favicon.ico" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
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
                });
              });
           function cancelar(){
            window.location.assign("chamados.php");
              }
        </script>
    </head>
      <body>
    
            <?php
          include 'include/dbconf.php';
          header("Content-type: text/html; charset=utf-8");
          if (!isset($_SESSION)) session_start();
          if($_SESSION['UsuarioNivel'] == 1) {
          echo'<script>erro()</script>';
          }  else {
          if (!isset($_SESSION['UsuarioID'])) {
          session_destroy();
          header("Location: index.php"); exit;
          }}
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

        <label class="col-md-4 control-label empresa" for="versao">Versão:</label>  
              <input value='<?php echo $row['versao'];?>' name="versao" type="text" class="form-control label2" required="">

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
    </body>
  </html>
