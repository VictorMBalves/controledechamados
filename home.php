<!Doctype html>
<html>
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="imagem/favicon.ico" />
    <title>Controle de Chamados</title>
    <script src='js/jquery.min.js'></script>
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="js/links.js"></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    <script type="text/javascript">
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
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

        $( document ).ready(function() {
            $.ajax({
              type: "POST",
              url: "tabelaHome.php",
              success:function(data){
                $("#tabela").html(data);
              }
          });
          $.ajax({
              type: "POST",
              url: "avisos.php",
              success:function(data){
                $("#avisos").html(data);
              }
          });
          $.ajax({
              type: "POST",
              url: "responsavelsemana.php",
              success:function(data){
                $("#plantao").html(data);
              }
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
       .wrapper {
          display: flex;
          align-items: stretch;
      }
      .content {
        float: right;
        padding: 0px;
        min-height: 100vh;
        transition: all 0.3s;
        margin-top: 90px;
      }
      .sidebar-outer {
        position: relative;
      }
      @media (min-width: 768px) {
      .sidebar {
        position: fixed;
      }
      }
      .error{
      border-color: rgba(255, 1, 1, 0.623);
      box-shadow: 2px 2px rgba(255, 1, 1, 0.486);
      }

      .error:active {
      color: rgba(255, 1, 1, 0.623);
      }
      .plus{
        color: white;
      }
    .plus:hover{
      color: white;
    }

    </style>
  </head>

  <body>
    <div class="wrapper">
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
      include 'include/menu.php';
    ?>
      <div class="content">
        <div class="col-md-4 sidebar-outer" style="height: 100%;">
          <div id="plantao">
          </div>
          <div id="usuarios">
          </div>
          <div id="avisos">
          </div>
        </div>

        <div class="col-md-8">
            <div id="tarefas"></div>
                <div class="col-md-8">
                    <div class="col-sm-3">
                        <?php echo "<img src='https://www.gravatar.com/avatar/$email' class='img-thumbnail' alt='Usuario' width='100'>"; ?>
                    </div>
                    <div class="col-md-8">
                        <h2>
                            <span style="margin-left:15px;">Bem-vindo, <?php echo $_SESSION['UsuarioNome']; ?> </span>
                        </h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <a href="home.php" class="thumbnail teste">
                        <img src="imagem/logo.png" >
                    </a>
                </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="row">
              <hr>
            </div>
            <div class="alert alert-warning" role="alert">
              <center>Chamados aguardando retorno:
              </center>
            </div>
              <div id="tabela">
              </div>
            </tbody>
          </table>
          </div>
          </div>
    </div>

</body>


</html>