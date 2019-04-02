<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $dataInicio = $_GET['dtInicialTempoMedioAtendimento'];
    $datafinal = $_GET['dtFinalTempoMedioAtendimento'];
    $sql = "SELECT 
                cha.id_chamado,
	            cha.empresa,
                cha.datafinal,
                cha.datainicio,
                us.nome AS usuario
            FROM chamado cha
            INNER JOIN usuarios us ON us.id = cha.usuario_id
            WHERE date(cha.datafinal) BETWEEN date('$dataInicio') AND date('$datafinal')
            AND status = 'Finalizado'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>