<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $data_inicio = $_GET['dataInicial'];
    $data_final =  $_GET['dataFinal'];
    $usuario = $_GET['usuario'];
    $sistema = $_GET['sistema'];
    $categoria = $_GET['categoria'];
    $cnpj = $_GET['cnpj'];
    $exceto = $_GET['exceto'];
    $atrasado = $_GET['atrasados'];
    $hora = $_GET['hora'];
    $empresa = $_GET['empresa'];

    $sql = "SELECT  chamado.id_chamado, 
                    chamado.empresa,
                    chamado.contato,
                    chamado.sistema,
                    chamado.descproblema,
                    chamado.datainicio,
                    usuario.nome as usuario,
                    TIMESTAMPDIFF(SECOND,datainicio,datafinal) as tempo
            from chamado
            left join categoria on categoria.id = chamado.categoria_id
            left join usuarios usuario on usuario.id = chamado.usuario_id ";

    if($atrasado == 'true'){
        $sql .=" INNER JOIN chamadoespera espera ON espera.id_chamadoespera = chamado.id_chamadoespera AND espera.usuario_id != 56 AND espera.notification IS TRUE ";
    }
    
    $sql .=" where date(chamado.datafinal) BETWEEN date('$data_inicio') and date('$data_final')
            and ('$usuario' = '' or chamado.usuario_id = cast('$usuario' as signed))
            and chamado.status = 'Finalizado'
            and ('$sistema' = '' or (case when upper(chamado.sistema) like '%LIGHT%' then 'LIGHT'
                                    when upper(chamado.sistema) like '%MANAGER%' then 'MANAGER'
                                    when upper(chamado.sistema) like '%EMISSOR%' then 'EMISSOR'
                                    when upper(chamado.sistema) like '%GOURMET%' then 'GOURMET' 
                                    else 'OUTROS' end) like upper('%$sistema%'))
            AND ('$cnpj' = '' or chamado.cnpj = '$cnpj')";

    if($atrasado == 'true'){
        $sql .=" AND ((espera.dataagendamento IS NULL OR DATE_ADD(espera.dataagendamento, INTERVAL +10 MINUTE) < chamado.datainicio) 
               OR DATE_ADD(espera.data, INTERVAL +10 MINUTE) < chamado.datainicio) ";
    }

    if($categoria != ''){
        $sql .=" AND chamado.categoria_id".($exceto == 'true' ? " not" : "")." in ($categoria) ";
    }

    if($empresa != ''){
        $sql .=" AND chamado.empresa LIKE '%$empresa%' ";
    }

    if($hora != ''){
        $sql .=" AND hour(chamado.datafinal) = $hora ";
    }

    $sql.=" order by chamado.datafinal desc";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>