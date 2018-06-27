<?php 
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    
    if (!isset($_SESSION)) {
        session_start();
    }
    $usuario = $_SESSION['UsuarioNome'];

    $sql ="SELECT id_chamadoespera, usuario, status, empresa, contato, telefone,  DATE_FORMAT(data,'%d/%m %H:%i') as data FROM chamadoespera WHERE status in ('Aguardando Retorno','Entrado em contato') AND enderecado LIKE '$usuario' ORDER BY data DESC";
    $query = $db->prepare($sql);
    $query->execute();
    $resultado = $query->fetchall(PDO::FETCH_ASSOC);
    echo json_encode($resultado);
?>