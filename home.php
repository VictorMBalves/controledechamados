<!Doctype html>
<html>
  <head> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="imagem/favicon.ico" />
    <title>Controle de Chamados
    </title>
    <script src='js/jquery.min.js'>
    </script>
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js">
    </script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js">
    </script>
    <script src="js/bootstrap.min.js">
    </script>
     <script src="js/links.js" >
    </script>
    <script type="text/javascript">  
      $(function () {
       $('[data-toggle="tooltip"]').tooltip()
        });
   
      function erro(){
        alert('Acesso negado! Redirecinando a pagina principal.');
        window.location.assign("chamadoespera.php");
      }
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

        .circle4{
        display:block;
        left:100px;
        width:30px;
        height:10px;
        margin-right:0px;
        margin-left:0px;
        padding: 0px;
        border-radius:50px;
        background-color:#5cb85c;
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
  if (!isset($_SESSION)) {
      session_start();
  }
  if (!isset($_SESSION['UsuarioID'])) {
      session_destroy();
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
<div id="usuarios" class="col-xs-6 col-md-3">
</div>
<div class="col-xs-12 col-sm-6 col-md-8">
 <div id="tarefas"></div>
  <div class="row">
    <h1>
          <?php echo "<img src='https://www.gravatar.com/avatar/$email' class='img-thumbnail' alt='Cinque Terre' width='100'>";?>
          <span style="margin-left:15px;">Bem-vindo, <?php echo $_SESSION['UsuarioNome']; ?>
            <div class="col-xs-6 col-sm-4 navbar-right">
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
echo'<div class="table-responsive">';
echo '<table class="table table-hover">';
echo '<tr class="caption">' ;
echo '<th>Status</th>';
echo '<th>Entrado em contato</th>';
echo '<th>Data</th>';
echo '<th>Atendente</th>';
echo '<th>Atribuído para</th>';
echo '<th>Empresa</th>';
echo '<th>Contato</th>';
echo '<th>Telefone</th>';
echo '<th width="100px"><center><img src="imagem/acao.png"></center></th>
</tr>   
<tbody>';
$sql = $conn->prepare('SELECT id_chamadoespera, usuario, status, empresa, contato, telefone, data, enderecado, historico FROM chamadoespera ORDER BY data desc');
$sql->execute();
$result = $sql->fetchall();
foreach ($result as $row) {
    if (!($row["status"] == "Finalizado")) {
        echo '<tr>';
        echo '<td>';
        if ($row['status']=="Aguardando Retorno") {
            echo '<div class="circle3" data-toggle="tooltip" data-placement="left" title="Aguardando Retorno"></div>';
        } else {
            echo '<div class="circle4" data-toggle="tooltip" data-placement="left" title="Entrado em contato"></div>';
        }
        echo '</td>';
        echo '<td>';
        if (is_null($row['historico'])) {
            echo 'Não';
        } else {
            echo 'Sim';
        }
        echo '</td>';
        echo '<td>'.$row["data"].'</td>';
        echo '<td>'.$row["usuario"].'</td>';
        echo '<td>';
        if ($row["enderecado"] == null) {
            echo"Ninguém";
        } else {
            echo $row['enderecado'];
        }
        echo'</td>';
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