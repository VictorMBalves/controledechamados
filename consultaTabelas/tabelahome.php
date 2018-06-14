<?php
    include '../include/dbconf.php';
    $sql = "SELECT id_chamadoespera, usuario, status, empresa, contato, telefone, DATE_FORMAT(data,'%d/%m %h:%i') as data, enderecado, historico FROM chamadoespera WHERE status <> 'Finalizado' ORDER BY data desc";
    $query = $conn->prepare($sql);
    $query->execute();
    $resultado = $query->fetchall();
    echo json_encode($resultado);
?>