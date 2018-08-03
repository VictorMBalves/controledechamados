<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    
    $sql = "SELECT id_chamadoespera, usuario, status, empresa, contato, telefone, DATE_FORMAT(data,'%d/%m %H:%i') as data, enderecado, historico FROM chamadoespera WHERE status <> 'Finalizado' ORDER BY status desc, data";
    $query = $db->prepare($sql);
    $query->execute();
    $resultado = $query->fetchall(PDO::FETCH_ASSOC);
    echo json_encode($resultado);
?>