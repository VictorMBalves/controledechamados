<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    
    $sql = "SELECT 
                id_chamadoespera, 
                usuario, 
                status, 
                empresa, 
                contato, 
                telefone, 
                data as databanco,
                DATE_FORMAT(data,'%d/%m/%Y %H:%i') as dataFormatada,
                enderecado, 
                historico, 
                notification, 
                descproblema,
                dataagendamento,
                DATE_FORMAT(dataagendamento,'%d/%m/%Y %H:%i') as dataagendamentoformat
            FROM chamadoespera 
            WHERE status <> 'Finalizado' 
            AND data < DATE_ADD(NOW(), INTERVAL -10 MINUTE) AND (dataagendamento IS NULL OR dataagendamento < DATE_ADD(NOW(), INTERVAL -10 MINUTE))
            ORDER BY status, data DESC";
    $query = $db->prepare($sql);
    $query->execute();
    $resultado = $query->fetchall(PDO::FETCH_ASSOC);
    echo json_encode($resultado);
?>