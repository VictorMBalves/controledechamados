<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();

    if (!isset($_SESSION)) {
        session_start();
    }
    $usuario = $_SESSION['UsuarioNome'];

    $sql = "SELECT id_plantao, usuario, status, empresa, contato, telefone, DATE_FORMAT(data,'%d/%m/%Y') as data FROM plantao WHERE usuario = '$usuario' ORDER BY id_plantao DESC";
    $query = $db->prepare($sql);
    $query->execute();
    $resultado = $query->fetchall(PDO::FETCH_ASSOC);
    echo json_encode($resultado);

?>