<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $data = $_GET['dtInicialTempoMedioAtendimento'];
    $sql = "SELECT 
	            empresa,
                datafinal,
                datainicio,
                usuario
            FROM chamado cha
            WHERE date(datafinal) = date('$data')
            AND status = 'Finalizado'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>