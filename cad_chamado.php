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
    <script src="js/gettelefone.js" >
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
    <script type="text/javascript">
      $(document).ready(function(){
        $("input[name='empresa']").blur(function(){
          var $telefone = $("input[name='telefone']");
          var $backup = $("input[name='backup']");
          var select = document.getElementById('backup');
          var $celular;

          $telefone.val('Carregando...');

            $.getJSON(
              'gettelefone.php',
              { empresa: $( this ).val() },
              function( json )
              {
                if (json.backup == 0){
                  $(select).val("0");
                }else{
                  $(select).val("1");
                }
                if( json.telefone == "(000)0000-0000" ){
                $telefone.val( json.celular );
                }
                else{
                  $telefone.val( json.telefone );
                }
              }
            );
        });
      });
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
    </div>
    <div class="alert alert-success" role="alert">
      <center>Novo chamado:
      </center>
    </div>
    <form class="form-vertical" action="insere_chamado.php" method="POST">
     
        <!-- Text input-->
        <fieldset>
         <div class="form-group form">
      
        <label class="col-md-4 control-label empresa" for="empresa">Empresa solicitante:</label>  
              <input name="empresa" type="text" id="skills" class="form-control label1">
            
        <label class="col-md-4 control-label empresa" for="contato">Contato:</label>  
              <input name="contato" type="text" class=" col-md-4 form-control label2" required="">
            
        <label class="col-md-4 control-label empresa" for="formacontato">Forma de contato:</label>  
              <select name="formacontato" type="text" class="col-md-4 form-control forma" required="">
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
              <input id="telefone" name="telefone" type="text" class="col-md-4 form-control label2" onkeypress="return SomenteNumero(event)" required="">

        <label class="col-md-4 control-label empresa" for="modulo">Módulo:</label>  
              <select name="modulo" type="text" class="col-md-4 form-control forma" required="">
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
              <select id="backup" name="backup" type="text" class="col-md-4 form-control label2" required="">
                  <option>
                  </option>
                  <option value="1">Google drive configurado
                  </option>
                  <option value="0">Google drive não configurado
                  </option>
                </select>

        <label class="col-md-4 control-label empresa" for="categoria">Categoria:</label>  
              <select name="categoria" type="text" class="col-md-4 form-control forma" required="">
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
              <textarea name="descproblema" type="text" class="col-md-4 form-control label1" required=""></textarea>
        <div class="col-md-12 text-center">
        <!-- Button -->
          <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Gravar
          </button>
          <button id="singlebutton" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning" onclick="cancelar()">Cancelar
          </button>
         
        </div>
      </fieldset>
    </form>
  </div>
  <br/>
  <br/>
  </body>
</html>
