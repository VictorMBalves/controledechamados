<!Doctype html>
<html>
  <head> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="imagem/favicon.ico" />
    <meta charset="utf-8" />
    <title>Controle de Chamados
    </title>
    <script src='js/jquery.min.js'>
    </script>
    <script src="js/links.js" >
    </script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js">
    </script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js">
    </script>
    <script src="js/bootstrap.min.js">
    </script>
    <script type="text/javascript">
      function erro(){
        alert('Acesso negado! Redirecinando a pagina principal.');
        window.location.assign("chamadoespera.php");
      }  
      $(function () {
       $('[data-toggle="tooltip"]').tooltip()
        });
        
        </script>   
    </script>
    <style>
      .circle3{
        display:block;
        left:100px;
        width:30px;
        height:10px;
        margin-right:0px;
        margin-left:0px;
        padding: 0px;
        border-radius:50px;
        background-color:#f0ad4e;
        box-shadow: none;
           }

       .bttt{
         width:40px;
         margin-right:0px;
       }    
    </style>
  </head>

  <body>
  <?php
header("Content-type: text/html; charset=utf-8");
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
// Verifica se não há a variável da sessão que identifica o usuário
if($_SESSION['UsuarioNivel'] == 1) {
echo'<script>erro()</script>';
} else {
if (!isset($_SESSION['UsuarioID'])) {
//Destrói a sessão por segurança
session_destroy();
//Redireciona o visitante de volta pro login
header("Location: index.php"); exit;
}}
$email = md5($_SESSION['Email']);
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
<div class="container">
 <div id="tarefas"></div>
  <div class="row">
    <h1>
      <div class="container">
        <div class="row">
          <?php echo "<img src='https://www.gravatar.com/avatar/$email' class='img-thumbnail' alt='Cinque Terre' width='100'>";?>
          <span style="margin-left:15px;">Bem-vindo, 
            <?php echo $_SESSION['UsuarioNome']; ?>
            <div class="col-xs-6 col-md-3 navbar-right">
          <a href="home.php" class="thumbnail teste">
            <img src="imagem/logo.png" >
          </a>
        </div> 
          </span>
        </img>
       
    </h1>
  </div>
   
  <br>
  <div class="row">
    <hr/>
  </div>
   <div class="alert alert-warning" role="alert">
    <center>Chamados aguardando retorno:
    </center>
  </div>
  <br>
  <?php 
include 'include/dbconf.php';
$conn->exec('SET CHARACTER SET utf8');
echo'<div class="table-responsive">';
echo '<table class="table table-hover">';
echo '<tr class="caption">' ;
echo '<th>Status</th>';
echo '<th>Data</th>';
echo '<th>Nº Chamado </th>';
echo '<th>Atendente</th>';
echo '<th>Empresa</th>';
echo '<th>Contato</th>';
echo '<th>Telefone</th>';
echo '<th width="100px"><center><img src="imagem/acao.png"></center></th>
</tr>   
<tbody>';
$enderecado=$_SESSION['UsuarioNome'];
$conn->exec("Content-type: text/html; charset=iso-8859-1");
$sql = $conn->prepare("SELECT id_chamadoespera, usuario, status, empresa, contato, telefone, data FROM chamadoespera WHERE enderecado LIKE '$enderecado' ORDER BY data DESC");
$sql->execute();
$result = $sql->fetchall();
foreach($result as $row){  
if($row["status"] =="Aguardando Retorno" ) {    
echo '<tr>';
echo '<td><div class="circle3" data-toggle="tooltip" data-placement="left" title="Aguardando Retorno"></div></td>';
echo '<td>'.$row["data"].'</td>'; 
echo '<td>'.$row["id_chamadoespera"].'</td>';
echo '<td>'.$row["usuario"].'</td>';
echo '<td>'.$row["empresa"].'</td>';
echo '<td>'.$row["contato"].'</td>';
echo '<td>'.$row["telefone"].'</td>';
echo "<td><a href='consultaespera.php?id_chamadoespera=".$row['id_chamadoespera']."'><button data-toggle='tooltip' data-placement='left' title='Visualizar' class='btn btn-info bttt' type='button'><i class='glyphicon glyphicon-search'></i></button></a> 
<a href='abrechamadoespera.php?id_chamadoespera=".$row['id_chamadoespera']. "'><button data-toggle='tooltip' data-placement='right' title='Atender' class='btn btn-success bttt' type='button'><i class='glyphicon glyphicon-share-alt'></i></button></a></td>";
echo '</tr>'; 
}
}
?>
  </tbody> 
</table>
</div>  
</body>
</html>