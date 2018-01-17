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
        window.location.assign("home.php");
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

      $(function(){
        $("input[name='usuario']").on('blur', function(){
          var usuario = $(this).val();
          $.get('verificausuario.php?usuario=' + usuario, function(data){
            $('#resultado').html(data);
          });
        });
      });
      </script>
  </head>
  <body>
<?php
  header("Content-type: text/html; charset=utf-8");
  // A sessão precisa ser iniciada em cada página diferente
  if (!isset($_SESSION)) session_start();
  if(!($_SESSION['UsuarioNivel'] == 3)) {
      echo'<script>erro()</script>';
  }else{
    // Verifica se não há a variável da sessão que identifica o usuário
    if (!isset($_SESSION['UsuarioID'])) {
      // Destrói a sessão por segurança
      session_destroy();
      // Redireciona o visitante de volta pro login
      header("Location: index.php"); exit;
    }
  }
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

<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home" class="link"><i class="glyphicon glyphicon-edit"></i>&nbsp&nbspNovo usuário</a></li>
    <li><a data-toggle="tab" href="#home1" class="link"><i class="glyphicon glyphicon-list"></i>&nbsp&nbspLista de usuários</a></li>
  </ul>

  <div class="tab-content">
      <div id="home" class="tab-pane fade in active">
      <div class="alert alert-success" role="alert">
      <center>Cadastrar novo usuário:
      </center>
    </div>
    <form class="form-vertical" action="insereusuario.php" method="POST">
      <fieldset>
        <!-- Text input-->
        <div class="form-group form">
          <label class="col-md-4 control-label empresa" for="nome">Nome:
          </label>  
          <input name="nome" type="text" class="form-control label1" required="">
          <br/>
            <label class="col-md-4 control-label empresa" for="usuario" id="usuario">Login:
          </label> 
          <input name="usuario" type="text" class="form-control label1" required="">
          <div id="resultado"></div> 
          <label class="col-md-4 control-label empresa" for="usuario">E-mail
          </label>  
          <input name="email" type="email" class="form-control label1" required="">
          <br/>
           <label class="col-md-4 control-label empresa" for="senha">Senha:
          </label>  
          <input name="senha" type="password" class="form-control label1" required="">
          <br/>
          <label class="col-md-4 control-label empresa">Nivel
          </label>
          <select name="nivel" class="form-control label1" required="">
            <option value="3">Suporte Avançado
            </option>
            <option value="2">Help-Desk
            </option>
            <option value="1">Financeiro
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

      <div id="home1" class="tab-pane fade">
        <table class="table table-responsive table-hover">
        <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Login</th>
        <th>Email</th>
        <th><center><img src="imagem/acao.png"></center></th>
        </tr>
        <tbody id="target-content">
        <?php
        include ('include/dbconf.php');
        $sql = $conn->prepare('SELECT id, nome, usuario, email FROM usuarios ORDER BY id desc');
        $sql->execute();
        $result = $sql->fetchall();
        foreach($result as $row){  
        echo '<tr>';            
        echo '<td>'.$row["id"].'</td>';
        echo '<td>'.$row["nome"].'</td>';
        echo '<td>'.$row["usuario"].'</td>';
        echo '<td>'.$row["email"].'</td>';
        echo "<td> <a style='margin-top:2px;' href='editausuario.php?id=".$row['id']."'><button data-toggle='tooltip' data-placement='left' title='Editar cadastro' class='btn btn-warning btn-sm btn-block' type='button'><span class='glyphicon glyphicon-pencil'></span></button></a>";
        }?>
        </tbody> 
        </table>
      </div>     
</br>
</br>
</br>
</div> 
</body>
</html>