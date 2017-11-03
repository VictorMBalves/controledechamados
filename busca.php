<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="shortcut icon" href="imagem/favicon.ico" />
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
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
       $(function () {
  $('[data-toggle="popover"]').popover()
})
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
</script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<!--<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>-->
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="dist/simplePagination.css" />
<script src="dist/jquery.simplePagination.js"></script>
<title></title>
</head>
  <style>
      .circle{
        display:block;
        left:100px;
        width:30px;
        height:10px;
        margin-right:0px;
        margin-left:0px;
        padding: 0px;
        border-radius:50px;
        background-color:#5bc0de;
        box-shadow: none;
      }
      .circle2{
        display:block;
        left:100px;
        width:30px;
        margin-right:0px;
        margin-left:0px;
        height:10px;
        border-radius:50px;
        background-color:#f0ad4e;
        box-shadow: none;
      }
      .teste12{
        margin-bottom:3px;
        margin-right:0px;
        width:40px;
        heigth:24px;
      }
    </style>
  </head>
  <body>
  <?php
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
// Verifica se não há a variável da sessão que identifica o usuário
if($_SESSION['UsuarioNivel'] == 1) {
echo'<script>erro()</script>';
} else {
if (!isset($_SESSION['UsuarioID'])) {
// Destrói a sessão por segurança
session_destroy();
// Redireciona o visitante de volta pro login
header("Location: index.php"); exit;
}}
$email = md5( $_SESSION['Email']);
include('include/db.php');
//for total count data
header('SET CHARACTER SET utf8');
$countSql = "SELECT COUNT(id_chamado) FROM chamado";  
$tot_result = mysqli_query($conn, $countSql);   
$row = mysqli_fetch_row($tot_result);  
$total_records = $row[0];  
$total_pages = ceil($total_records / $limit);

//for first time load data
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  
$sql = "SELECT id_chamado,usuario, status, empresa, contato, telefone, date(datainicio) FROM chamado ORDER BY id_chamado DESC LIMIT $start_from, $limit";  
$rs_result = mysqli_query($conn, $sql); 
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
      <div class="row">
        <div class="col-xs-6 col-md-3">
          <a href="#" class="thumbnail">
            <img src="imagem/logo.png" >
          </a>
        </div>
        </h1>
      </div>
    <br>
    <div class="row">
      <hr/>
    </div>
    <div class="alert alert-warning" role="alert">
      <center>Lista de chamados:
      </center>
    </div>
    <br>
    <form class="navbar-form  col-md-12 text-center" method="POST" action="busca.php">
      <label class="control-label">Empresa Solicitante:
      </label>
      <input name="palavra" type="text" class="form-control" placeholder="Empresa" id="skills">
      <label style="padding-left:15px;" class="control-label">Status:
      </label>
      <select name="status" class="form-control modulo">
        <option value="">
        </option>
        <option value="Aberto">Aberto
        </option>
        <option value="Finalizado">Finalizado
        </option>
      </select>
      <label style="padding-left:15px;" class="control-label">Responsável:
      </label>
     <select name="usuario" class="form-control modulo">
        <option></option>       
        <?php 
        include 'include/dbconf.php';
        $conn->exec('SET CHARACTER SET utf8'); 
        $sql = $conn->prepare('SELECT nome, nivel FROM usuarios');
        $sql->execute();
        $result = $sql->fetchall();
        foreach($result as $row){  
        if($row["nivel"] != 1 ) {    
        echo '<option>'.$row['nome'].'</option>'; 
        }}        
        ?>
        </select>
      <label style="padding-left:15px;" class="control-label">Data:
      </label>
      <input type="date" name="data" class="form-control">
      <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Buscar
      </button>
    </form> 
    <br>
    <br>
    <br> 
    <div class="row">
      <hr/>
    </div>       




<div class="teste table-responsive ">
<table class="table table-responsive table-hover">
<tr>
<th>Status</th>
<th width="100px">Data</th>
<th>Responsável</th>
<th>Nº Chamado </th>
<th>Empresa</th>
<th>Contato</th>
<th>Telefone</th>
<th width="100px"><center><img src="imagem/acao.png"></center></th>
</tr>
<tbody id="target-content">
<?php
include('include/db.php');
$status = $_POST['status'];
$palavra = $_POST['palavra'];
$usuario = $_POST['usuario'];
$data = $_POST['data'];
$_SESSION['status'] = $_POST['status'];
$_SESSION['palavra'] = $_POST['palavra'];
$_SESSION['usuario'] = $_POST['usuario'];
$_SESSION['data'] = $_POST['data'];
$query = "SELECT id_chamado, usuario, status, empresa, contato, telefone, date(datainicio) FROM chamado ";
if ($status != null) {                                        
$query = " $query WHERE status LIKE '$status' ";
}               
if ($palavra != null) {
if ($status != null) {
$query = " $query AND empresa LIKE '%".$palavra."%' ";
} else {
$query = " $query WHERE empresa LIKE '%".$palavra."%' ";
}
}
if ($usuario != null) {
if ($status != null || $palavra != null) {
$query = " $query AND usuario LIKE '$usuario' ";
} else {
$query = " $query WHERE usuario LIKE '$usuario' ";
}
}
if ($data != null) {
if ($status != null || $palavra != null || $usuario != null) {
$query = " $query AND datainicio LIKE '%".$data."%' ";
} else {
$query = " $query WHERE datainicio LIKE '%".$data."%'  ";
}
}
$query = " $query ORDER BY datainicio desc limit $limit";
$rs_result = mysqli_query($conn, $query); 
while ($row = mysqli_fetch_assoc($rs_result)) {
echo '<tr>';            
echo '<td>';if($row['status']!="Finalizado"){echo'<div class="circle2" data-toggle="tooltip" data-placement="left" title="Status: Aberto"></div>';} else {echo'<div class="circle" data-toggle="tooltip" data-placement="left" title="Status: Finalizado"></div> '; } 
echo'</td>';
echo '<td>'.$row["date(datainicio)"].'</td>'; 
echo '<td>'.$row["usuario"].'</td>';
echo '<td>'.$row["id_chamado"].'</td>';
echo '<td>'.$row["empresa"].'</td>';
echo '<td>'.$row["contato"].'</td>';
echo '<td>'.$row["telefone"].'</td>';
echo '<td>';
if ($row["status"]!="Finalizado") {
echo "
<a style='margin-top:2px;' href='editachamado.php?id_chamado=".$row['id_chamado']."'><button data-toggle='tooltip' data-placement='left' title='Editar chamado' class='btn btn-warning teste12' type='button'><span class='glyphicon glyphicon-pencil'></span></button></a>
<a href='abrechamado.php?id_chamado=".$row['id_chamado']."'><button data-toggle='tooltip' data-placement='left' title='Finalizar chamado' class='btn btn-success teste12' type='button'><span class='glyphicon glyphicon-ok'></span></button></a>";
}
else{
echo "<a href='consulta.php?id_chamado=".$row['id_chamado']. "'><button class='btn btn-info btn-sm btn-block' type='button'>Consultar</button></a> </td>";
echo '</tr>';
}  
}
?>
</tbody> 
</table>
<div class="col-md-12 text-center">
<center><ul class="pagination">
<?php if(!empty($total_pages)):for($i=1; $i<=$total_pages; $i++):  
            if($i == 1):?>
            <li class='active'  id="<?php echo $i;?>"><a href='pagination.php?page=<?php echo $i;?>'><?php echo $i;?></a></li> 
            <?php else:?>
            <li id="<?php echo $i;?>"><a href='pagination.php?page=<?php echo $i;?>'><?php echo $i;?></a></li>
        <?php endif;?>          
<?php endfor;endif;?>
</ul>
</center>
</div>
</div>
</body>
<script type="text/javascript">
$(document).ready(function(){
$('.pagination').pagination({
        items: <?php echo $total_records;?>,
        itemsOnPage: <?php echo $limit;?>,
        cssStyle: 'light-theme',
		currentPage : 1,
		onPageClick : function(pageNumber) {
			jQuery("#target-content").html('loading...');
			jQuery("#target-content").load("pagination.php?page=" + pageNumber);
		}
    });
});
</script>
</br>
</br>
</br>
</br>
</br>
</br>