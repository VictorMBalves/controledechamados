<?php 
    include '../include/dbconf.php';
    
    if (!isset($_SESSION)) {
        session_start();
    }
    $usuario = $_SESSION['UsuarioNome'];

    $sql ="SELECT id_chamadoespera, usuario, status, empresa, contato, telefone,  DATE_FORMAT(data,'%d/%m %h:%i') as data FROM chamadoespera WHERE status in ('Aguardando Retorno','Entrado em contato') AND enderecado LIKE '$usuario' ORDER BY data DESC";
    $query = $conn->prepare($sql);
    $query->execute();
    $resultado = $query->fetchall();
    echo json_encode($resultado);
?>