<?php 
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $data = date('2018-10-01');
    $data2 = date('2018-11-30');
    $sql = "SELECT DISTINCT chamado.usuario from chamado INNER JOIN usuarios us on chamado.usuario = us.nome where date(datainicio) BETWEEN '$data' and '$data2' group by date(datainicio), chamado.usuario ORDER BY usuario";

    $query = $db->prepare($sql);
    $query->execute();
    $usuarios = $query->fetchall(PDO::FETCH_ASSOC);

    $usuariosArray = ['Mês'];
    foreach($usuarios as $usuario){
        array_push($usuariosArray, $usuario['usuario']);
    }
    
    $query = $db->prepare("SELECT DISTINCT date(datainicio) from chamado inner JOIN usuarios us ON us.nome = chamado.usuario where date(datainicio) BETWEEN '$data' and '$data2' group by date(datainicio), chamado.usuario ORDER BY date(datainicio)");
    $query->execute();
    $datas = $query->fetchall(PDO::FETCH_ASSOC);
    
    $dataTable = [];
    array_push($dataTable, $usuariosArray);

    foreach ($datas as $data) {
        $datasArray = [];
        $datainicio = date_create($data['date(datainicio)']);
        $dataFormatada = date_format($datainicio, 'd/m/Y');

        array_push($datasArray, $dataFormatada);

        $datainicio = $data['date(datainicio)'];
        $query = $db->prepare("SELECT cha.usuario, count(datainicio) from chamado cha INNER JOIN usuarios us ON us.nome = cha.usuario where date(datainicio) = '$datainicio'  group by date(datainicio), usuario ORDER BY usuario");
        $query->execute();
        $resultados = $query->fetchall(PDO::FETCH_ASSOC);
        $atual = 0;
        foreach ($usuarios as $usuario) {
            if ($atual == sizeof($resultados) || $usuario['usuario'] == $resultados[$atual]['usuario']) {
                if ($atual < sizeof($resultados)) {
                    if ($usuario['usuario'] == $resultados[$atual]['usuario']) {
                        array_push($datasArray, intval($resultados[$atual]['count(datainicio)']));
                        $totalUsuarios[$usuario['usuario']] += $resultados[$atual]['count(datainicio)'];
                        $total += $resultados[$atual]['count(datainicio)'];
                        $atual++;
                    }
                } else {
                    array_push($datasArray, 0);
                }
            } else {
                array_push($datasArray, 0);
            }
        }
        array_push($dataTable, $datasArray);
    }

    echo json_encode($dataTable, JSON_UNESCAPED_UNICODE);
?>