<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $data = $_GET['dtInicialPorHora'];
    $sql = "SELECT 
	            count(cha.id_chamado) as numChamados,
                HOUR(datafinal) as hora
            FROM chamado cha
            WHERE date(datafinal) = date('$data')
            GROUP BY HOUR(datafinal)";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    $dataTable = [];
    $header = ['Hora', 'Nº Chamados'];
    array_push($dataTable, $header);

    foreach($resultado as $usuario) {
        $usuarioArray = [];
        array_push($usuarioArray, date($usuario['hora'].':00:00'));
        array_push($usuarioArray, intval($usuario['numChamados']));
        array_push($dataTable, $usuarioArray);
    }

    echo json_encode($dataTable, JSON_UNESCAPED_UNICODE);
?>