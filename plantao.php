<!Doctype html>
<html >
  <head>
    <title>Controle de Chamados</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" /> 
    <link rel="shortcut icon" href="imagem/favicon.ico" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="dist/simplePagination.css" />
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>         
    <script src="js/links.js" ></script>
    <script src="js/apiConsulta.js" ></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    <script src="dist/jquery.simplePagination.js"></script>
    <script type="text/javascript">
      function erro(){
          alert('Acesso negado! Redirecinando a pagina principal.');
          window.location.assign("chamadoespera.php");
        }
        $(function() {
          $( "#skills" ).autocomplete({
            source: 'search.php'
          });
        });
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
      .link{
        color:#333;        
      }
      .link:hover{
        color:#5bc0de;
      }
    </style>
  </head>
  <body>
    <?php
      if (!isset($_SESSION)) {
          session_start();
      }
      if ($_SESSION['UsuarioNivel'] == 1) {
          echo'<script>erro()</script>';
      } else {
          if (!isset($_SESSION['UsuarioID'])) {
              session_destroy();
              header("Location: index.php");
              exit;
          }
      }
      $email = md5($_SESSION['Email']);
      /////////////////////
      include('include/db.php');
      include('include/menu.php');
      /////////////////////
      $usuario=$_SESSION['UsuarioNome'];
      $countSql = "SELECT COUNT(id_plantao) FROM plantao WHERE usuario = '$usuario'";
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
      $sql = "SELECT id_plantao, usuario, status, empresa, contato, telefone, date(datainicio), data FROM plantao WHERE usuario = '$usuario' ORDER BY id_plantao DESC LIMIT $start_from, $limit";
      $rs_result = mysqli_query($conn, $sql);
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
          </div>
        </h1>
        <div class="row">
          <hr/>
        </div>
        <br>
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#home1" class="link"><i class="glyphicon glyphicon-sunglasses"></i>&nbsp&nbspNovo plantão decorrido</a></li>
          <li><a data-toggle="tab" href="#menu1" class="link"><i class="glyphicon glyphicon-user"></i>&nbsp&nbspMeus chamados</a></li>
          <li><a data-toggle="tab" href="#menu2" class="link"><i class="glyphicon glyphicon-calendar"></i>&nbsp&nbspSobreaviso</a></li>
        </ul>
        <div class="tab-content">
          <!-- PLANTAO DECORRIDO -->
          <div id="home1" class="tab-pane fade in active">
            <?php $time = date("Y-m-d");?>
            <br/>
            <div class="alert alert-success" role="alert">
              <center>Novo atendimento plantão:</center>
            </div>
            <form class="form-horizontal" action="insere_plantao2.php" method="POST">
              <div class="form-group">
                <label class="col-md-2 control-label" for="empresa">Empresa solicitante:</label>  
                  <div class="col-sm-10">      
                    <input name="empresa" type="text" id="skills" class="form-control" required="">
                  </div>
              </div>
              <div class="form-group">               
                <label class="col-md-2 control-label" for="contato">Contato:</label>
                  <div class="col-sm-10">  
                    <input name="contato" type="text" class="form-control" required="">
                  </div>
              </div>
              <div class="form-group">                
                <label class="col-md-2 control-label" for="formacontato">Forma de contato:</label>  
                  <div class="col-sm-4">
                    <select name="formacontato" type="text" class="form-control" required="">
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
                  </div>
                <label class="col-md-2 control-label" for="telefone">Telefone</label>  
                  <div class="col-sm-4">
                    <input name="telefone" type="text" class="form-control" required="">
                  </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label" for="data">Data:</label>  
                  <div class="col-sm-2">
                    <input name="data" type="date" value="<?php echo $time?>"class="form-control" required="">
                  </div>
                <label class="col-md-2 control-label" for="horainicio">Horario de ínicio:</label>  
                  <div class="col-sm-2">
                    <input name="horainicio" type="time" class="form-control" required="">
                  </div>
                <label class="col-md-2 control-label" for="horafim">Horario de término:</label>  
                  <div class="col-sm-2">
                    <input name="horafim" type="time" class="form-control" required="">      
                  </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label" for="sistema">Sistema:</label>  
                  <div class="col-sm-2">
                    <select name="sistema" type="text" class="form-control" required="">
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
                  </div>
                <label class="col-md-2 control-label" for="backup2">Backup:</label>  
                  <div class="col-sm-2">
                    <select id="backup2" name="backup2" type="text" class="form-control" required="">
                      <option>
                      </option>
                      <option value="1">Google drive configurado
                      </option>
                      <option value="0">Google drive não configurado
                      </option>
                    </select>
                  </div>
                <label class="col-md-2 control-label" for="categoria">Categoria:</label>  
                  <div class="col-sm-2">
                    <select name="categoria" type="text" class="form-control" required="">
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
                  </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label" for="descproblema">Descrição do problema:</label>  
                  <div class="col-sm-10">
                    <textarea name="descproblema" type="text" class="form-control" required=""></textarea>
                  </div>
              </div> 
              <div class="form-group">
                <label class="col-md-2 control-label" for="descsolucao">Descrição da solução:</label>  
                  <div class="col-sm-10">
                    <textarea name="descsolucao" type="text" class="form-control" required=""></textarea>      
                  </div>
              </div>  
              <div class="col-md-12 text-center">
                <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Gravar</button>
                <button id="singlebutton" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning" onclick="cancelar()">Cancelar</button>
              </div>
            </form>
            </br>
            </br>
            </br>
          </div>

          <div id="menu1" class="tab-pane fade">
                    <br/>
                    <table class="table table-responsive table-hover">
                    <tr>
                    <th>Status</th>
                    <th width="100px">Data</th>
                    <th>Responsável</th>
                    <th>Nº</th>
                    <th>Empresa</th>
                    <th>Contato</th>
                    <th>Telefone</th>
                    <th width="100px"><center><img src="imagem/acao.png"></center></th>
                    </tr>
                    <tbody id="target-content">
                    <?php 
                    while ($row = mysqli_fetch_assoc($rs_result)) {
                        echo '<tr>';
                        echo '<td>';
                        if ($row['status']!="Finalizado") {
                            echo'<div class="circle2" data-toggle="tooltip" data-placement="left" title="Status: Aberto"></div>';
                        } else {
                            echo'<div class="circle" data-toggle="tooltip" data-placement="left" title="Status: Finalizado"></div> ';
                        }
                        echo'</td>';
                        echo '<td>';
                        if ($row['date(datainicio)'] === null) {
                            echo $row['data'];
                        } else {
                            echo $row['date(datainicio)'];
                        }
                        echo'</td>';
                        echo '<td>'.$row["usuario"].'</td>';
                        echo '<td>'.$row["id_plantao"].'</td>';
                        echo '<td>'.$row["empresa"].'</td>';
                        echo '<td>'.$row["contato"].'</td>';
                        echo '<td>'.$row["telefone"].'</td>';
                        echo '<td>';
                        if ($row["status"]!="Finalizado") {
                            echo "
                    <a style='margin-top:2px;' href='editaplantao.php?id_plantao=".$row['id_plantao']."'><button data-toggle='tooltip' data-placement='left' title='Editar chamado' class='btn btn-warning teste12' type='button'><span class='glyphicon glyphicon-pencil'></span></button></a>
                    <a href='abreplantao.php?id_plantao=".$row['id_plantao']."'><button data-toggle='tooltip' data-placement='left' title='Finalizar chamado' class='btn btn-success teste12' type='button'><span class='glyphicon glyphicon-ok'></span></button></a>";
                        } else {
                            echo "<a href='consultaplantao.php?id_plantao=".$row['id_plantao']. "'><button class='btn btn-info btn-sm btn-block' type='button'>Consultar</button></a> </td>";
                            echo '</tr>';
                        }
                    }
                    echo '</tbody> 
                    </table>';
                    ?>
                    <div class="col-md-12 text-center">
                    <center><ul class="pagination">
                    <?php if (!empty($total_pages)): for ($i=1; $i<=$total_pages; $i++):
                                if ($i == 1):?>
                                <li class='active'  id="<?php echo $i;?>"><a href='paginationplantao.php?page=<?php echo $i;?>'><?php echo $i;?></a></li> 
                                <?php else:?>
                                <li id="<?php echo $i;?>"><a href='paginationplantao.php?page=<?php echo $i;?>'><?php echo $i;?></a></li>
                            <?php endif;?>          
                    <?php endfor;endif;?>
                      </ul></center>
                  </div>
            <script type="text/javascript">
            $(document).ready(function(){
            $('.pagination').pagination({
                    items: <?php echo $total_records;?>,
                    itemsOnPage: <?php echo $limit;?>,
                    cssStyle: 'light-theme',
                currentPage : 1,
                onPageClick : function(pageNumber) {
                  jQuery("#target-content").html('loading...');
                  jQuery("#target-content").load("paginationplantao.php?page=" + pageNumber);
                }
                });
            });
            </script>
            </br>
            </br>
            </br>
            </div>
    
    <?php 
if (array_key_exists('data', $_POST)) {
    $data=$_POST['data'];
    $data2=$_POST['data1'];
} else {
    $data = date('Y-m').'-01';
    $data2 = date('Y-m-t');
}
?>
    
  <div id="menu2" class="tab-pane fade">
      <br/>
   <form class="navbar-form text-center" method="POST" action="sobreaviso.php">
    <fieldset>
      <legend>Período:
      </legend>
      <label style="padding-left:15px; padding-right:10px;" class="control-label">De:
      </label>
      <input type="date" value="<?php echo $data;?>" name="data1" class="form-control">
      <label style="padding-left:15px; padding-right:10px;" class="control-label">Até:
      </label>
      <input style="padding-right:15px;" type="date" value="<?php echo $data2;?>" name="data2" class="form-control">
      <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary"><i class="glyphicon glyphicon-print"></i> Gerar</button>
    </fieldset>
  </form> 

</div>
    
  
</body>
</html>