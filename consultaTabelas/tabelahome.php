<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    
    $sql = "SELECT id_chamadoespera, usuario, status, empresa, contato, telefone, DATE_FORMAT(data,'%d/%m %H:%i') as data, data as databanco, enderecado, historico FROM chamadoespera WHERE status <> 'Finalizado' ORDER BY status, data DESC";
    $query = $db->prepare($sql);
    $query->execute();
    $resultado = $query->fetchall(PDO::FETCH_ASSOC);
    echo json_encode($resultado);
?>