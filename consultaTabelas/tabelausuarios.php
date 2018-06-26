<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();

    $sql = $db->prepare('SELECT id, nome, usuario, email FROM usuarios ORDER BY id desc');
    $sql->execute();
    $result = $sql->fetchall(PDO::FETCH_ASSOC);
    echo json_encode($result);
?>