<!doctype html>
<html>
    <head>
		<title>Controle de Chamados</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
	</head> 
    <body>
    <?php
        include '../validacoes/verificaSession.php';
        include '../include/menu.php';

        if (array_key_exists('data', $_POST)) {
            $data = $_POST['data'];
            $data2 = $_POST['data1'];
        } else {
            $data = date('Y-m') . '-01';
            $data2 = date('Y-m-t');
        }
    ?>
        <div class="container" style="margin-top:60px; margin-bottom:50px;">
            <?php include '../include/cabecalho.php';?>
            <div class="alert alert-success" role="alert">
                <center>Relatório de chamados:</center>
            </div>
            <form class="navbar-form text-center" method="POST" action="relatorio">
                <fieldset>
                    <legend>Período:</legend>
                    <label style="padding-left:15px; padding-right:10px;" class="control-label">De:
                    </label>
                    <input type="date" value="<?php echo $data;?>" name="data" class="form-control">
                    <label style="padding-left:15px; padding-right:10px;" class="control-label">Até:
                    </label>
                    <input style="padding-right:15px;" type="date" value="<?php echo $data2;?>" name="data1" class="form-control">
                    <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Buscar
                    </button>
                </fieldset>
                <hr>
            </form>
            <br>
    <?php
        require_once '../include/Database.class.php';
        $db = Database::conexao();
        if (array_key_exists('data', $_POST)) {
            $data = $_POST['data'];
            $data2 = $_POST['data1'];
        } else {
            $data = time('Y-m-d');
            $data2 = time('Y-m-d');
        }
        $query = $db->prepare("SELECT DISTINCT chamado.usuario from chamado INNER JOIN usuarios us on chamado.usuario = us.nome where date(datainicio) BETWEEN '$data' and '$data2' group by date(datainicio), chamado.usuario ORDER BY usuario");
        $query->execute();
        $usuarios = $query->fetchall(PDO::FETCH_ASSOC);
        if (array_key_exists('data', $_POST)) {
            $data = $_POST['data'];
            $data2 = $_POST['data1'];
            echo '<div teste table-responsive table-hover">';
            echo '<table class="table table-striped text-center">';
            echo '<thead>';
            echo '<tr class="text-center">';
            echo '<th class="text-center">Data</th>';
            foreach ($usuarios as $usuario) {
                echo '<th class="text-center">' . $usuario['usuario'] . '</th>';
                $totalUsuarios[$usuario['usuario']] = 0;
            }
            $total = 0;
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            $query = $db->prepare("SELECT DISTINCT date(datainicio) from chamado inner JOIN usuarios us ON us.nome = chamado.usuario where date(datainicio) BETWEEN '$data' and '$data2' group by date(datainicio), chamado.usuario ORDER BY date(datainicio)");
            $query->execute();
            $datas = $query->fetchall(PDO::FETCH_ASSOC);
            foreach ($datas as $data) {
                echo '<tr>';
                $datainicio = date_create($data['date(datainicio)']);
                $dataFormatada = date_format($datainicio, 'd/m/Y');
                echo '<td>' . $dataFormatada . '</td>';
                $datainicio = $data['date(datainicio)'];
                $query = $db->prepare("SELECT cha.usuario, count(datainicio) from chamado cha INNER JOIN usuarios us ON us.nome = cha.usuario where date(datainicio) = '$datainicio'  group by date(datainicio), usuario ORDER BY usuario");
                $query->execute();
                $resultados = $query->fetchall(PDO::FETCH_ASSOC);
                $atual = 0;
                foreach ($usuarios as $usuario) {
                    if ($atual == sizeof($resultados) || $usuario['usuario'] == $resultados[$atual]['usuario']) {
                        if ($atual < sizeof($resultados)) {
                            if ($usuario['usuario'] == $resultados[$atual]['usuario']) {
                                echo '<td>' . $resultados[$atual]['count(datainicio)'] . '</td>';
                                $totalUsuarios[$usuario['usuario']] += $resultados[$atual]['count(datainicio)'];
                                $total += $resultados[$atual]['count(datainicio)'];
                                $atual++;
                            }
                        } else {
                            echo '<td>0</td>';
                        }
                    } else {
                        echo '<td>0</td>';
                    }
                }
                echo '</tr>';
            }
            echo '<tr> <td><strong>Total por Atendente</strong></td>';
            foreach ($usuarios as $usuario) {
                echo '<td><strong>' . $totalUsuarios[$usuario['usuario']] . '</strong></td>';
            }
            echo '</tr>';
            echo '<tr class="info">';
            echo '<td><strong>Total</strong></td>';
            echo '<td><strong>' . $total . '</strong></td>';
            for ($i = 1; $i < count($usuarios); $i++) {
                echo '<td></td>';
            }
            echo '</tr>';
            echo '</tbody>';
            echo '</table>';
        }
    ?>
        </div>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
        <script src="../assets/js/date.js"></script>        
        <script src="../js/links.js" ></script> 
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
    </body>
</html>
