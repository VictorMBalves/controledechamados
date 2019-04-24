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
                'ATRASADOS'  as tipo,
                count(cha1.id_chamado) as qtd,
                (SELECT
                    COUNT( DISTINCT cast(cha1.datafinal as date) ) qtd_dias
                 FROM chamado cha1
                 WHERE date(datafinal) BETWEEN date('$data_inicio') AND date('$data_final')
                   AND cha1.status = 'Finalizado') as qtd_dias
            FROM chamado cha1
            INNER JOIN chamadoespera espera ON espera.id_chamadoespera = cha1.id_chamadoespera AND espera.usuario_id != 56 AND espera.notification IS TRUE
            left join categoria on categoria.id = cha1.categoria_id
            left join usuarios usuario on usuario.id = cha1.usuario_id
            WHERE date(datafinal) BETWEEN date('$data_inicio') AND date('$data_final')
              AND cha1.status = 'Finalizado'   
              AND ((espera.dataagendamento IS NULL OR DATE_ADD(espera.dataagendamento, INTERVAL +10 MINUTE) < cha1.datainicio) 
               OR DATE_ADD(espera.data, INTERVAL +10 MINUTE) < cha1.datainicio)
               and ('$usuario' = '' or cha1.usuario_id = cast('$usuario' as signed))
              AND ('$sistema' = '' or lower(cha1.sistema) like lower('%$sistema%'))
              AND ('$cnpj' = '' or cha1.cnpj = '$cnpj')";

    if($categoria != ''){
      $sql .=" AND cha1.categoria_id".($exceto == 'true' ? " not" : "")." in ($categoria)";
    }

    $sql .=" UNION ALL 

            SELECT
                'TOTAL'  as tipo,
                count(cha1.id_chamado) as qtd,
                (SELECT
                    COUNT( DISTINCT cast(cha1.datafinal as date) ) qtd_dias
                 FROM chamado cha1
                 WHERE date(datafinal) BETWEEN date('$data_inicio') AND date('$data_final')
                   AND cha1.status = 'Finalizado') as qtd_dias
            FROM chamado cha1
            left join categoria on categoria.id = cha1.categoria_id
            left join usuarios usuario on usuario.id = cha1.usuario_id
            WHERE date(datafinal) BETWEEN date('$data_inicio') AND date('$data_final')
              and ('$usuario' = '' or cha1.usuario_id = cast('$usuario' as signed))
              AND ('$sistema' = '' or lower(cha1.sistema) like lower('%$sistema%'))
              AND ('$cnpj' = '' or cha1.cnpj = '$cnpj')
              AND cha1.status = 'Finalizado'";

    if($categoria != ''){
      $sql .=" AND cha1.categoria_id".($exceto == 'true' ? " not" : "")." in ($categoria)";
    }

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    // echo $sql;
    // if(sizeof($resultado) == 0){
    //     return;
    // }
    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>