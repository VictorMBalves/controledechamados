<!DOCTYPE html>
<html>
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
    <script src="../js/links.js" >
    </script>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js">
    </script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js">
    </script>
    <link href="../css/cad.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js">
    </script>
    <style>
        table{
            width-auto:600px;

        }

    </style>
    </head>

    <body>
<?php 
if (array_key_exists('data', $_POST)) {
    $data=$_POST['data'];
    $data2=$_POST['data1'];
} else {
    $data = date('Y-m').'-01';
    $data2 = date('Y-m-t');
}
?>
<div width="100%" height="100%">
  <form method="POST" action="imprimerelatorio.php">
      <label style="padding-left:15px; padding-right:10px;">De:
      </label>
      <input type="date" value="<?php echo $data;?>" name="data" >
      <label style="padding-left:15px; padding-right:10px;">Até:
      </label>
      <input style="padding-right:15px;" type="date" value="<?php echo $data2;?>" name="data1">
      <button type="submit" >Buscar
      </button>
  </form> 
  <br>  
  <?php
include 'include/dbconf.php';
if (array_key_exists('data', $_POST)) {
    $data=$_POST['data'];
    $data2=$_POST['data1'];
} else {
    $data = time('Y-m-d');
    $data2 = time('Y-m-d');
}
$conn->exec('SET CHARACTER SET utf8');
$query = $conn->prepare("SELECT DISTINCT usuario from chamado where date(datainicio) BETWEEN '$data' and '$data2' group by date(datainicio), usuario ORDER BY usuario");
$query->execute();
$usuarios = $query->fetchall();
if (array_key_exists('data', $_POST)) {
    $data=$_POST['data'];
    $data2=$_POST['data1'];
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Data</th>';
    foreach ($usuarios as $usuario) {
        echo '<th>'.$usuario['usuario'].'</th>';
        $totalUsuarios[$usuario['usuario']] = 0;
    }
    $total = 0;
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    $query = $conn->prepare("SELECT DISTINCT date(datainicio) from chamado where date(datainicio) BETWEEN '$data' and '$data2' group by date(datainicio), usuario ORDER BY date(datainicio)");
    $query->execute();
    $datas = $query->fetchall();
    foreach ($datas as $data) {
        echo '<tr>';
        echo '<td>'.$data['date(datainicio)'].'</td>';
        $datainicio = $data['date(datainicio)'];
        $query = $conn->prepare("SELECT usuario, count(datainicio) from chamado where date(datainicio) = '$datainicio' group by date(datainicio), usuario ORDER BY date(datainicio), usuario");
        $query->execute();
        $resultados =$query->fetchall();
        $atual=0;
        foreach ($usuarios as $usuario) {
            if ($atual!=sizeof($resultados) && $usuario['usuario']==$resultados[$atual]['usuario']) {
                echo '<td>'.$resultados[$atual]['count(datainicio)'].'</td>';
                $totalUsuarios[$usuario['usuario']] += $resultados[$atual]['count(datainicio)'];
                $total += $resultados[$atual]['count(datainicio)'];
                $atual++;
            } else {
                echo '<td>0</td>';
            }
        }
        echo '</tr>';
    }
    echo '<tr> <td><strong>Total por Atendente</strong></td>';
    foreach ($usuarios as $usuario) {
        echo '<td><strong>'.$totalUsuarios[$usuario['usuario']].'</strong></td>';
    }
    echo '</tr>';
    echo '<tr class="info">';
    echo '<td><strong>Total</strong></td>';
    echo '<td><strong>'.$total.'</strong></td>';
    for ($i = 1; $i < count($usuarios); $i++) {
        echo '<td></td>';
    }
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
}
?>
    </body>
</html>