<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $dataInicio = $_GET['dtInicialTempoMedioAtendimento'];
    $datafinal = $_GET['dtFinalTempoMedioAtendimento'];
    $sql = "SELECT 
                id_chamado,
	            empresa,
                datafinal,
                datainicio,
                usuario
            FROM chamado cha
            WHERE date(datafinal) BETWEEN date('$dataInicio') AND date('$datafinal')
            AND status = 'Finalizado'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>