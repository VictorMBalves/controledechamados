<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $data = $_GET['dtInicialTempoMedioAtendimento'];
    $sql = "SELECT 
	            SEC_TO_TIME((SUM(TIMESTAMPDIFF(SECOND,datainicio,datafinal)) / COUNT(id_chamado))) as tempo,
                COUNT(id_chamado) as numeroChamados,
                (SELECT
     		        COUNT(id_chamado)
                FROM chamado cha1
     			INNER JOIN chamadoespera espera ON espera.id_chamadoespera = cha1.id_chamadoespera AND ((espera.dataagendamento IS NULL OR DATE_ADD(espera.dataagendamento, INTERVAL +10 MINUTE) < cha1.datainicio) AND DATE_ADD(espera.data, INTERVAL +10 MINUTE) < cha1.datainicio) WHERE date(datafinal) = date('$data')) as numeroChamadosatrasados 
            FROM chamado cha
            WHERE date(datafinal) = date('$data')
            AND status = 'Finalizado'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>