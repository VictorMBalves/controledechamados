<!Doctype html>
<html >
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <title>Controle de Chamados</title>
  <link rel="shortcut icon" href="imagem/favicon.ico" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
  <link href="css/bootstrap.css" rel="stylesheet">
</head>
    <body>

    <?php
        // A sessão precisa ser iniciada em cada página diferente
        if (!isset($_SESSION)) {
            session_start();
        }
        // Verifica se não há a variável da sessão que identifica o usuário
        if (!isset($_SESSION['UsuarioID'])) {
            // Destrói a sessão por segurança
            session_destroy();
            // Redireciona o visitante de volta pro login
            header("Location: index.php");
            exit;
        }
        $email = md5($_SESSION['Email']);
        include 'include/menu.php';
    ?>
        <br/>
        <br/>
        <br/>
        <br/>
        <div class="container">
            <div id="tarefas"></div>
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <a href="home.php" class="thumbnail">
                        <img src="imagem/logo.png" >
                    </a>
                </div>
            </div>
            <br>
            <div class="row">
                <hr/>
            </div>
            <div class="alert alert-success" role="alert">
                <center>Relatório escala mensal Sobreaviso</center>
            </div>
            <br>
            <form id="formAviso" class="form-horizontal">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="titulo" class="control-label col-sm-2">Mês</label>
                            <div class="col-sm-10">
                                <select name="mes" type="text" class="form-control" title="Selecione um mês" id="mes">
                                    <option value="01">Janeiro</option>
                                    <option value="02">Fevereiro</option>
                                    <option value="03">Março</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Maio</option>
                                    <option value="06">Junho</option>
                                    <option value="07">Julho</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Setembro</option>
                                    <option value="10">Outubro</option>
                                    <option value="11">Novembro</option>
                                    <option value="12">Dezembro</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="titulo" class="control-label col-sm-2">Usuário</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="usuarios" placeholder="Usuário ...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" id="adc"><i class="glyphicon glyphicon-plus"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Usuários</h3>
                            </div>
                            <div class="panel-body">
                                <div id="lista" class="list-group">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info" id="gerar">Gerar relatório</button>
                    </div>
                </div>
            </form>
        </div>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="js/links.js"></script>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
        <script src="js/md5.js"></script>
        <script type="text/javascript">
            function erro(){
                alert('Acesso negado! Redirecinando a pagina principal.');
                window.location.assign("chamadoespera.php");
            }
            $(function() {
                $("#usuarios").autocomplete({
                    source: 'searchusers.php'
                });
            });

            $("#adc").on("click", function(){
                adcusuario();
            });

            $(document).keypress(function(e){
                if (e.which == 13){
                    var usuario = $("#usuarios").val();
                    var hash = '"'+md5(usuario)+'"';
                    if(usuario == "" || usuario == null){
                        alert("Nenhum usuário selecionado");
                        return;
                    }else{
                        $( "#lista" ).append("<a href='#' class='list-group-item' id="+hash+">"+usuario+"<button class='btn btn-xs glyphicon glyphicon-remove pull-right' onclick='remover("+hash+")'></button></a>");
                        $("#usuarios").val("");
                    }
                }
            });
            function adcusuario(){
                var usuario = $("#usuarios").val();
                var hash = '"'+md5(usuario)+'"';
                if(usuario == "" || usuario == null){
                    alert("Nenhum usuário selecionado");
                    return;
                }else{
                    $( "#lista" ).append("<a href='#' class='list-group-item' id="+hash+">"+usuario+"<button class='btn btn-xs glyphicon glyphicon-remove pull-right' onclick='remover("+hash+")'></button></a>");
                    $("#usuarios").val("");
                }
            }
            function remover(id){
               $("#"+id).remove();
            }

            $("#gerar").on("click", function(){
                var users = [];
                var mes = $("#mes").val();
                
                $( "#lista" ).each(function() {
                    $(this).find("a").each(function() {
                        users.push($( this ).html());
                    });
                });
                
                if (users === undefined || users.length == 0) {
                    return alert("Nenhum usuário selecionado");
                }


                var data = [];
                data.push({name: 'usuarios', value: users});
                data.push({name: 'mes', value: mes});
                
                $.ajax({
                    type: "POST",
                    url: "escalamensal.php",
                    data:data,
                    success: function(data){
                       window.location = 'downloadpdf.php';
                    }
                });
            });
        </script>
</body>
</html>
