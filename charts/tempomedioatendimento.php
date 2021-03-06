<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $dataInicio = $_GET['dtInicialTempoMedioAtendimento'];
    $datafinal = $_GET['dtFinalTempoMedioAtendimento'];
    $sql = "SELECT 
	            SEC_TO_TIME((SUM(TIMESTAMPDIFF(SECOND,datainicio,datafinal)) / COUNT(id_chamado))) as tempo,
                COUNT(id_chamado) as numeroChamados,
                (SELECT
     		        COUNT(id_chamado)
                FROM chamado cha1
     			INNER JOIN chamadoespera espera ON espera.id_chamadoespera = cha1.id_chamadoespera 
                            AND espera.usuario_id != 56 
                            AND ((espera.dataagendamento IS NULL OR DATE_ADD(espera.dataagendamento, INTERVAL +10 MINUTE) < cha1.datainicio) 
                                OR DATE_ADD(espera.data, INTERVAL +10 MINUTE) < cha1.datainicio)
                            AND espera.notification IS TRUE
                WHERE date(datafinal) BETWEEN date('$dataInicio') AND date('$datafinal')) as numeroChamadosatrasados 
            FROM chamado cha
            WHERE date(datafinal) BETWEEN date('$dataInicio') AND date('$datafinal')
            AND status = 'Finalizado'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>