<!Doctype html>
<html >
  <head>
    <title>Controle de Chamados</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" /> 
    <link rel="shortcut icon" href="imagem/favicon.ico" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/cad.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
  </head>

  <body>
    <?php
      include 'include/dbconf.php';
      header("Content-type: text/html; charset=utf-8");
      // A sessão precisa ser iniciada em cada página diferente
      if (!isset($_SESSION)) session_start();
      // Verifica se não há a variável da sessão que identifica o usuário
      if($_SESSION['UsuarioNivel'] == 1) {
        echo'<script>erro()</script>';
        }  
      else {
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
    </div>
    <?php 
      $conn->exec('SET CHARACTER SET utf8');
      $id=$_GET['id_chamadoespera'];
      $sql = $conn->prepare("SELECT * FROM chamadoespera WHERE id_chamadoespera=$id");
      $sql->execute();
      $row = $sql->fetch(PDO::FETCH_ASSOC);
      $empresa = $row['empresa'];
      $sql2 = $conn->prepare("SELECT backup FROM empresa WHERE nome = '$empresa'");
      $sql2->execute();
      $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
    ?> 
    <div class="alert alert-warning" role="alert">
      <center>Atender chamado em espera Nº:
        <?php echo $id?> 
      </center>
    </div>
    <br>
    <form class="form-vertical" action="insere_chamado2.php" method="POST">
      <input style="display:none;"  name='id_chamadoespera' value='<?php echo $id; ?>'/>

        <label class="col-md-4 control-label empresa" for="empresa">Empresa solicitante:</label>  
              <input value='<?php echo $row['empresa'];?>'name="empresa" type="text" class="form-control label1" required="">
            
        <label class="col-md-4 control-label empresa" for="contato">Contato:</label>  
              <input value='<?php echo $row['contato'];?>' name="contato" type="text" class="form-control label2" required="">
            
        <label class="col-md-4 control-label empresa" for="formacontato">Forma de contato:</label>  
              <select name="formacontato" type="text" class="form-control forma" required="">
                  <option>
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

            <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Atender</button>
            
            <button id="singlebutton" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning" onclick="cancelar()">Cancelar</button>
        </div>
          
      </fieldset>
    </form>
  </div>
  <br/>
  <br/>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>         
    <script src="js/links.js" ></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    <script>
      $(function() {
        $( "#skills" ).autocomplete({
          source: 'search.php'
        }
                                   );
      }
       );
      function cancelar(){
        window.location.assign("home.php");
      }
      function atualizarTarefas() {
           // aqui voce passa o id do usuario
           var url="notifica.php";
            jQuery("#tarefas").load(url);
        }
        setInterval("atualizarTarefas()",1000);
        
        function erro(){
        alert('Acesso negado! Redirecinando a pagina principal.');
        window.location.assign("chamadoespera.php");
      }
    </script>
  </body>
</html>