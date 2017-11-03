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
    <script type="text/javascript">
      $(document).ready(function(){
        $("input[name='empresa']").blur(function(){
          var $telefone = $("input[name='telefone']");
          var $celular;

          $telefone.val('Carregando...');

            $.getJSON(
              'gettelefone.php',
              { empresa: $( this ).val() },
              function( json )
              {
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

      function refresh_usuarios() {
        var url="atendentedispo.php";
        jQuery("#usuarios").load(url);
      }
      
      $(function() {
      refresh_usuarios(); //first initialize
        });
        setInterval(function(){
          refresh_usuarios() // this will run after every 5 seconds
        }, 5000);  
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
    </script>
  </head>
  <body>
  <?php
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID'])) {
// Destrói a sessão por segurança
session_destroy();
// Redireciona o visitante de volta pro login
header("Location: index.php"); exit;
}
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
         if($_SESSION['UsuarioNivel'] != 1) {
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
         if($_SESSION['UsuarioNivel'] != 1) {
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
         
         <?php if($_SESSION['UsuarioNivel'] != 1) {
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
            
         </ul>
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
          
           <?php
               if($_SESSION['UsuarioNivel'] == 3){
           
                 echo ' <li role="separator" class="divider">
                         </li>         
                         <li>
                         <a href="cad_usuario.php">Cadastrar usuário
                         </a>
                       </li>';
                        }
           ?>
           <li role="separator" class="divider">
           </li>
           <li>
             <a href="alterasenha.php">Alterar senha
             </a>
           </li>
            <li role="separator" class="divider">
           </li>
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
<div id="usuarios" class="col-xs-6 col-md-3 navbar-right" style="margin-right:20px;">
</div>
<div class="container">
 <div id="tarefas"></div>
  <div class="row">
    <h1>
      <div class="row">
        <div class="col-xs-6 col-md-3">
          <a href="home.php" class="thumbnail">
            <img src="imagem/logo.png" >
            </img>
          </a>
      </div>
    </h1>
  </div>
  <br>
  <div class="row">
    <hr/>
  </div>
  <div class="alert alert-success" role="alert">
    <center>Novo chamado em espera:
    </center>
  </div>
  <br>
  <form class="form-vertical" action="inserechamadoespera.php" method="POST">
    <fieldset>
      <!-- Text input-->
      <div class="form-group form">
        <label class="col-md-4 control-label empresa" for="skills">Empresa solicitante:
        </label>  
        <input id="skills" name="empresa" type="text" class="form-control label1" required="">
        <br/>
         <label class="col-md-4 control-label empresa" for="skills">Atribuir para:
        </label>  
        <select name="enderecado" type="text" class="form-control label1">
          <option value=""></option>       
        <?php 
        include 'include/dbconf.php';
        $conn->exec('SET CHARACTER SET utf8'); 
        $sql = $conn->prepare('SELECT nome, nivel, disponivel FROM usuarios');
        $sql->execute();
        $result = $sql->fetchall();
        foreach($result as $row){  
        if($row["nivel"] != 1 ) {    
        echo '<option>'.$row['nome'].'</option>'; 
        }}        
        ?>
        </select>
        <br/>
        <label class="col-md-4 control-label empresa" for="contato">Contato:
        </label>  
        <input id="skills" name="contato" type="text" class="form-control label2" required="">
        <label class="col-md-4 control-label empresa" for="telefone">Telefone:
        </label>  
        <input name="telefone" type="text" class="form-control forma" onkeypress="return SomenteNumero(event)" required="">
       <label class="col-md-4 control-label empresa" for="descproblema">Descrição do problema:</label>  
      <textarea name="descproblema" class="form-control label1" required=""></textarea>
    </div>
    <!-- Button -->
    <div class="col-md-12 text-center">
      <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Salvar
      </button>
    </div>
    </fieldset>
  </form>
</div>
<br/>
<br/>
</body>
</html>
