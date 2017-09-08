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
    <link rel="stylesheet" href="dist/simplePagination.css" />
    <script src="dist/jquery.simplePagination.js"></script>
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
        $(function() {
        $( "#skills2" ).autocomplete({
          source: 'search.php'
        }
                                   );
      }
       );
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

include('include/db.php');
//for total count data
header('SET CHARACTER SET utf8');
$usuario=$_SESSION['UsuarioNome'];
$countSql = "SELECT COUNT(id_plantao) FROM plantao WHERE usuario = '$usuario'";  
$tot_result = mysqli_query($conn, $countSql);   
$row = mysqli_fetch_row($tot_result);  
$total_records = $row[0];  
$total_pages = ceil($total_records / $limit);

//for first time load data
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  
$sql = "SELECT id_plantao, usuario, status, empresa, contato, telefone, date(datainicio), data FROM plantao WHERE usuario = '$usuario' ORDER BY id_plantao DESC LIMIT $start_from, $limit";  
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
          if($_SESSION['UsuarioNivel'] == 2) {
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
          if($_SESSION['UsuarioNivel'] == 2) {
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
          <?php if($_SESSION['UsuarioNivel'] == 2) {
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
            <li role="separator" class="divider">
            </li>
            <li>
              <a href="alterasenha.php">Alterar senha
              </a>
            </li>
            <li role="separator" class="divider"></li>

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
          <a href="home.php" class="thumbnail">
            <img src="imagem/logo.png" >
          </a>
        </div>
        </h1>
      </div>
    <div class="row">
      <hr/>
    </div>
<br>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home" class="link"><i class="glyphicon glyphicon-bell"></i>&nbsp&nbspNovo plantão</a></li>
    <li><a data-toggle="tab" href="#home1" class="link"><i class="glyphicon glyphicon-sunglasses"></i>&nbsp&nbspNovo plantão decorrido</a></li>
    <li><a data-toggle="tab" href="#menu1" class="link"><i class="glyphicon glyphicon-user"></i>&nbsp&nbspMeus chamados</a></li>
    <li><a data-toggle="tab" href="#menu2" class="link"><i class="glyphicon glyphicon-calendar"></i>&nbsp&nbspSobreaviso</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <br/>
        <div class="alert alert-success" role="alert">
          <center>Novo atendimento plantão:</center>
        </div>
          <form class="form-vertical" action="insere_plantao.php" method="POST">
            <fieldset>
              <div class="form-group form">
      
                    <label class="col-md-4 control-label empresa" for="empresa">Empresa solicitante:</label>  
                          <input name="empresa" type="text" id="skills" class="form-control label1" required="">
                        
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
                          </select>

                    <label class="col-md-4 control-label empresa" for="telefone">Telefone</label>  
                          <input data-mask="(999)9999-9999" name="telefone" type="text" class="col-md-4 form-control label2" onkeypress="return SomenteNumero(event)" required="">

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

                    <label class="col-md-4 control-label empresa" for="versao">Versão:</label>  
                          <input name="versao" type="text" class="col-md-4 form-control label2" data-mask="9.99.9" required="">

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
                    </div>
                 </fieldset>
          </form>
          </br>
</br>
</br>
    </div>

     <div id="home1" class="tab-pane fade">
       <?php 
          $time = date("Y-m-d");
       ?>
      <br/>
        <div class="alert alert-success" role="alert">
          <center>Novo atendimento plantão:</center>
        </div>
          <form class="form-vertical" action="insere_plantao2.php" method="POST">
            <fieldset>
              <div class="form-group form">
      
                    <label class="col-md-4 control-label empresa" for="empresa">Empresa solicitante:</label>  
                          <input name="empresa" type="text" id="skills2" class="form-control label1" required="">

                    <label class="col-md-4 control-label empresa" for="data">Data:</label>  
                          <input name="data" type="date" value="<?php echo $time?>"class=" col-md-4 form-control label3" required="">

                    <label class="col-md-4 control-label empresa1" for="contato">Horario de ínicio:</label>  
                          <input name="horainicio" type="time" class="col-md-4 form-control forma1" required="">

                    <label class="col-md-4 control-label empresa1" for="contato">Horario de término:</label>  
                        <input name="horafim" type="time" class="col-md-4 form-control forma1" required="">      
                        
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
                          </select>

                    <label class="col-md-4 control-label empresa" for="telefone">Telefone</label>  
                          <input data-mask="(999)9999-9999" name="telefone" type="text" class="col-md-4 form-control label2" onkeypress="return SomenteNumero(event)" required="">

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

                    <label class="col-md-4 control-label empresa" for="versao">Versão:</label>  
                          <input name="versao" type="text" class="col-md-4 form-control label2" data-mask="9.99.9" required="">

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
                     <label class="col-md-4 control-label empresa" for="descsolucao">Descrição da solução:</label>  
                          <textarea name="descsolucao" type="text" class="col-md-4 form-control label1" required=""></textarea>      
                    <div class="col-md-12 text-center">
                    <!-- Button -->
                      <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Gravar
                      </button>
                      <button id="singlebutton" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning" onclick="cancelar()">Cancelar
                      </button>
         
                    </div>
                    </div>
                 </fieldset>
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
        echo '<td>';if($row['status']!="Finalizado"){echo'<div class="circle2" data-toggle="tooltip" data-placement="left" title="Status: Aberto"></div>';} else {echo'<div class="circle" data-toggle="tooltip" data-placement="left" title="Status: Finalizado"></div> '; } 
        echo'</td>';
        echo '<td>';if($row['date(datainicio)'] === NULL ){ echo $row['data'];} else{echo $row['date(datainicio)'];}echo'</td>';
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
        }
        else{
        echo "<a href='consultaplantao.php?id_plantao=".$row['id_plantao']. "'><button class='btn btn-info btn-sm btn-block' type='button'>Consultar</button></a> </td>";
        echo '</tr>';
        }  
        }
        echo '</tbody> 
        </table>';
        ?>
        <div class="col-md-12 text-center">
        <center><ul class="pagination">
        <?php if(!empty($total_pages)):for($i=1; $i<=$total_pages; $i++):  
                    if($i == 1):?>
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