<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();

    if (!isset($_SESSION)) {
        session_start();
    }

    $usuario = $_SESSION['UsuarioNome'];

    $sql = "SELECT id_chamado,usuario, status, empresa, contato, telefone, DATE_FORMAT(datainicio,'%d/%m/%Y') as data  FROM chamado where usuario='$usuario' ORDER BY id_chamado DESC";
    $query = $db->prepare($sql);
    $query->execute();
    $resultado = $query->fetchall(PDO::FETCH_ASSOC);
    echo json_encode($resultado);
?>