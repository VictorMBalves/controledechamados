<?php
    include '../include/dbconf.php';

    if (!isset($_SESSION)) {
        session_start();
    }
    $usuario = $_SESSION['UsuarioNome'];

    $sql = "SELECT id_plantao, usuario, status, empresa, contato, telefone, DATE_FORMAT(data,'%d/%m/%Y') as data FROM plantao WHERE usuario = '$usuario' ORDER BY id_plantao";
    $query = $conn->prepare($sql);
    $query->execute();
    $resultado = $query->fetchall();
    echo json_encode($resultado);

?>