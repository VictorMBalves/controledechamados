<?php 
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $week_start =  $_GET['dtInicial1'];
    $week_end = $_GET['dtFinal1'];
    $sql = "SELECT DISTINCT us.nome AS usuario from chamado INNER JOIN usuarios us on chamado.usuario_id = us.id where date(datainicio) BETWEEN '$week_start' and '$week_end' and chamado.status LIKE 'Finalizado' group by us.nome ORDER BY us.nome";

    $query = $db->prepare($sql);
    $query->execute();
    $usuarios = $query->fetchall(PDO::FETCH_ASSOC);

    if(sizeof($usuarios) == 0){
        return;
    }

    $usuariosArray = ['Mês'];
    foreach($usuarios as $usuario){
        array_push($usuariosArray, $usuario['usuario']);
    }
    
    $query = $db->prepare("SELECT DISTINCT date(datainicio) from chamado INNER JOIN usuarios us ON chamado.usuario_id = us.id where date(datainicio) BETWEEN '$week_start' and '$week_end' and chamado.status LIKE 'Finalizado' group by date(datainicio) ORDER BY date(datainicio)");
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
        $query = $db->prepare("SELECT us.nome AS usuario, count(datainicio) from chamado cha INNER JOIN usuarios us on cha.usuario_id = us.id where date(datainicio) = '$datainicio' and cha.status LIKE 'Finalizado'  group by date(datainicio), us.nome ORDER BY us.nome");
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