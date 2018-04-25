<!DOCTYPE html>
<html> 
   <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" /> 
    <link rel="shortcut icon" href="imagem/favicon.ico" />
    <title>Controle de Chamados</title>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js">
    </script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js">
    </script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js">
    </script>
    <style>
    .link{
        color:#5bc0de;
     
}
    .link:hover{
        color:#5bc0de;
    }
    .bells{
      animation: blinker 1s linear infinite;
}

@keyframes blinker {  
  50% { opacity: 0; }
}

   </style>
</head>
</html>
<?php
        include '../validacoes/verificaSession.php';
        include '../include/dbconf.php';
        $conn->exec('SET CHARACTER SET utf8');
        $enderecado =$_SESSION['UsuarioNome'];
        $status="Aguardando Retorno";
        $sql = $conn->prepare("SELECT COUNT(enderecado) FROM chamadoespera WHERE enderecado like '$enderecado' and status='$status' GROUP BY enderecado");
        $sql->execute();
        $result = $sql->fetchall();
        
        foreach ($result as $row) {
            if ($row > 1) {
                echo '<div class="alert alert-info alert-dismissible" role="alert">';
                // echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                echo '<div class="text-center">';
                echo '<a href="../pages/meuschamados.php" class="link"><i class="glyphicon glyphicon-bell bells"></i>&nbsp<strong>'.$_SESSION["UsuarioNome"].'</strong>, há <strong>'.$row["COUNT(enderecado)"].'</strong>';
                if ($row["COUNT(enderecado)"] > 1) {
                    echo ' notificações';
                } else {
                    echo ' notificação';
                }
                if ($row["COUNT(enderecado)"] > 1) {
                    echo ' direcionadas';
                } else {
                    echo ' direcionada';
                }
                echo ' para você!</a>';
                echo '</div>';
                echo '</div>';
            }
        }
 ?>       

