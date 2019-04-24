<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $data_inicio = $_GET['dataInicial'];
    $data_final =  $_GET['dataFinal'];
    $usuario = $_GET['usuario'];
    $sistema = $_GET['sistema'];
    $cnpj = $_GET['cnpj'];
    $categoria = $_GET['categoria'];
    $exceto = $_GET['exceto'];

    $sql = "SELECT 
	            (SUM(TIMESTAMPDIFF(SECOND,datainicio,datafinal)) / COUNT(id_chamado)) as tempo,
                COUNT(id_chamado) as numeroChamados
            FROM chamado
            where date(chamado.datafinal) BETWEEN date('$data_inicio') and date('$data_final')
            and ('$usuario' = '' or chamado.usuario_id = cast('$usuario' as signed))
            and ('$sistema' = '' or lower(chamado.sistema) like lower('%$sistema%'))
            AND ('$cnpj' = '' or chamado.cnpj = '$cnpj')
            AND status = 'Finalizado'";

    if($categoria != ''){
        $sql .=" AND chamado.categoria_id".($exceto == 'true' ? " not" : "")." in ($categoria)";
    }

    $stmt = $db->prepare($sql);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>