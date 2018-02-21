<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="shortcut icon" href="imagem/favicon.ico" />
    <link rel="stylesheet" href="dist/simplePagination.css" />
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/cad.css">
  </head>
  <body>
    <?php
      if (!isset($_SESSION)) {
          session_start();
      }
      if (!isset($_SESSION['UsuarioID'])) {
          session_destroy();
          header("Location: index.php");
          exit;
      }
      $email = md5($_SESSION['Email']);
      include('include/db.php');
      header('SET CHARACTER SET utf8');
      $countSql = "SELECT COUNT(id_empresa) FROM empresa";
      $tot_result = mysqli_query($conn, $countSql);
      $row = mysqli_fetch_row($tot_result);
      $total_records = $row[0];
      $total_pages = ceil($total_records / $limit);

      //for first time load data
      if (isset($_GET["page"])) {
          $page  = $_GET["page"];
      } else {
          $page=1;
      };
      $start_from = ($page-1) * $limit;
      $sql = "SELECT * FROM empresa ORDER BY id_empresa ASC LIMIT $start_from, $limit";
      $rs_result = mysqli_query($conn, $sql);
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
              <a href="#" class="thumbnail">
                <img src="imagem/logo.png" >
              </a>
            </div>
          </div>
        </h1>
        <br>
        <div class="row">
          <hr/>
        </div>
        <div class="alert alert-warning" role="alert">
          <center>Lista de clientes:</center>
        </div>
        <div class="text-center">
          <?php include('include/formEmpresa.php');?>
        </div>
        </br>
        <div class="row">
          <hr/>
        </div>                    

      <div class="teste  ">
      <table class="table table-responsive table-hover">
      <tr>
      <th>ID</th>
      <th>Empresa</th>
      <th>Situação</th>
      <th>CNPJ</th>
      <th>Sistema</th>
      <th>Versão</th>
      <th><center><img src="imagem/acao.png"></center></th>
      </tr>     
      <tbody id="target-content">
      <?php
      if (isset($_POST['situacao'])) {
          $situacao = $_POST['situacao'];
          $_SESSION['situacao'] = $_POST['situacao'];
      }
      if (isset($_POST['palavra'])){
        $palavra = $_POST['palavra'];
        $_SESSION['palavra'] = $_POST['palavra'];
      }
      if (isset($_POST['negaVersao'])) {
          $versaoDiferente = $_POST['negaVersao'];
          $_SESSION['negaVersao'] = $_POST['negaVersao'];
      }
      if (isset($_POST['sistema'])) {
          $sistema = $_POST['sistema'];
          $_SESSION['sistema'] = $_POST['sistema'];
      }
      if (isset($_POST['versao'])) {
          $versao = $_POST['versao'];
          $_SESSION['versao'] = $_POST['versao'];
      }

      $query = "SELECT * FROM empresa";
      if ($situacao != null) {
          $query = " $query WHERE situacao LIKE '$situacao' ";
      }
      if ($palavra != null) {
          if ($situacao != null) {
              $query = " $query AND nome LIKE '%".$palavra."%' ";
          } else {
              $query = " $query WHERE nome LIKE '%".$palavra."%' ";
          }
      }
      if ($sistema != null) {
          if ($situacao != null || $palavra != null) {
              $query = " $query AND sistema LIKE '$sistema'";
          } else {
              $query = " $query WHERE sistema LIKE '$sistema'";
          }
      }
      if ($versao != null) {
          if (isset($versaoDiferente)) {
              if ($situacao != null || $palavra != null || $sistema != null) {
                  $query = " $query AND versao <> '$versao'";
              } else {
                  $query = " $query WHERE versao <> '$versao'";
              }
          } else {
              if ($situacao != null || $palavra != null || $sistema != null) {
                  $query = " $query AND versao LIKE '$versao'";
              } else {
                  $query = " $query WHERE versao LIKE '$versao'";
              }
          }
      }
      //pega quantidade de registros
      $sql = " $query ORDER BY id_empresa asc";
      $num = mysqli_query($conn, $sql);
      $total_records = mysqli_num_rows($num);
      $total_pages = ceil($total_records / $limit);

      $sql = " $query ORDER BY id_empresa asc limit $limit";
      $rs_result = mysqli_query($conn, $sql);
    
      while ($row = mysqli_fetch_assoc($rs_result)) {
          echo '<tr>';
          echo '<td>'.$row["id_empresa"].'</td>';
          echo '<td>'.$row["nome"].'</td>';
          echo '<td>'.$row["situacao"].'</td>';
          echo '<td>'.$row["cnpj"].'</td>';
          echo '<td>'.$row["sistema"].'</td>';
          echo '<td>'.$row["versao"].'</td>';
          echo "<td> <a style='margin-top:2px;' href='editaempresa.php?id_empresa=".$row['id_empresa']."'><button data-toggle='tooltip' data-placement='left' title='Editar cadastro' class='btn btn-warning btn-sm btn-block' type='button'><span class='glyphicon glyphicon-pencil'></span></button></a>";
      }?>
      </tbody> 
      </table>
      <div class="col-md-12 text-center">
      <center><ul class="pagination">
      <?php if (!empty($total_pages)): for ($i=1; $i<=$total_pages; $i++):
                if ($i == 1):?>
                <li class='active'  id="<?php echo $i;?>"><a href='paginationempre.php?page=<?php echo $i;?>'><?php echo $i;?></a></li> 
                <?php else:?>
                <li id="<?php echo $i;?>"><a href='paginationempre.php?page=<?php echo $i;?>'><?php echo $i;?></a></li>
            <?php endif;?>          
      <?php endfor;endif;?>
      </ul>
      </center>
      </div>
    </div>
      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
      <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <script src="dist/jquery.simplePagination.js"></script>
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
        $(function () {
          $('[data-toggle="popover"]').popover()
        });
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        });
        $(document).ready(function(){
          $('.pagination').pagination({
                  items: <?php echo $total_records;?>,
                  itemsOnPage: <?php echo $limit;?>,
                  cssStyle: 'light-theme',
              currentPage : 1,
              onPageClick : function(pageNumber) {
                jQuery("#target-content").html('loading...');
                jQuery("#target-content").load("paginationempre.php?page=" + pageNumber);
              }
              });
          });
      </script>
</body>
</br>
</br>
</br>
</br>
</br>
</br>
</html>
