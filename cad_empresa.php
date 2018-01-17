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
      $(function() {
    $('input').focusout(function() {
        // Uppercase-ize contents
        this.value = this.value.toLocaleUpperCase();
    });
});
    </script>
    <style>
        input.uppercase { text-transform: uppercase; }

    </style>
  </head>
  <body>
<?php
  header("Content-type: text/html; charset=utf-8");
  // A sessão precisa ser iniciada em cada página diferente
  if (!isset($_SESSION)) {
      session_start();
  }
  // Verifica se não há a variável da sessão que identifica o usuário
  if (!isset($_SESSION['UsuarioID'])) {
      // Destrói a sessão por segurança
      session_destroy();
      // Redireciona o visitante de volta pro login
      header("Location: index.php");
      exit;
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
    <br>
    <div class="row">
      <hr/>
    </div>
    <div class="alert alert-success" role="alert">
      <center>Cadastrar nova empresa:
      </center>
    </div>
    <form class="form-vertical" action="insereempresa.php" method="POST">
      <fieldset>
        <!-- Text input-->
        <div class="form-group form">
          <label class="col-md-4 control-label empresa">Razão Social:
          </label>  
          <input name="empresa" type="text" class="form-control label1 uppercase" required="">
          <br/>
            <label class="col-md-4 control-label empresa">CNPJ:
          </label>  
          <input name="cnpj" data-mask="99.999.999/9999-99" type="text" class="form-control label1" required="">
          <br/>
           <label class="col-md-4 control-label empresa">Telefone:
          </label>  
          <input name="telefone" data-mask="(999)9999-9999" type="text" class="form-control label1" required="">
          <br/>
          <label class="col-md-4 control-label empresa">Celular:
          </label>  
          <input name="celular" data-mask="(999)99999-9999" type="text" class="form-control label1">
          <br/>
          <label class="col-md-4 control-label empresa">Situação:
          </label>
          <select name="situacao" class="form-control label1" required="">
            <option value="ATIVO">Ativo
            </option>
            <option value="BLOQUEADO">Bloqueado
            </option>
            <option value="DESISTENTE">Desistente
            </option>
          </select>
          <label class="col-md-4 control-label empresa">Backup:
          </label>
          <select name="backup" class="form-control label1 ">
            <option value="1">Google drive configurado
            </option>
            <option value="0">Google drive não configurado
            </option>
          </select>
        </div>
        <br/>
        <!-- Button -->
        <div class="col-md-12 text-center">
          <button type="submit" id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Cadastrar</button>
          <button type="reset" class="btn btn-group-lg btn-warning" onclick="cancelar2()">Cancelar</button>
      </div>    
        
         </fieldset>
    </form>
  </div>
  </body>
</html>
