<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $data = $_GET['dtInicialRank'];
    $sql = "SELECT 
	            user.nome as nome,
	            count(cha.id_chamado) as numChamados
            FROM chamado cha
            INNER JOIN usuarios user ON user.id = cha.usuario_id
            WHERE cha.status LIKE 'Finalizado' AND date(datainicio) = date('$data')
            GROUP BY user.nome";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    $dataTable = [];
    $header = ['Atendente', 'Nº Chamados'];
    array_push($dataTable, $header);

    foreach($resultado as $usuario) {
        $usuarioArray = [];
        array_push($usuarioArray, $usuario['nome']);
        array_push($usuarioArray, intval($usuario['numChamados']));
        array_push($dataTable, $usuarioArray);
    }

    echo json_encode($dataTable, JSON_UNESCAPED_UNICODE);
?>