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
    $tipo_order = $_GET['tipo_order'];

    $sql = "SELECT (case when upper(chamado.sistema) like '%LIGHT%' then 'LIGHT'
                         when upper(chamado.sistema) like '%MANAGER%' then 'MANAGER'
                         when upper(chamado.sistema) like '%EMISSOR%' then 'EMISSOR'
                         when upper(chamado.sistema) like '%GOURMET%' then 'GOURMET' 
                         else 'OUTROS' end) as sistemaAgrupado, 
                    count(chamado.id_chamado) as qtd, 
                    sum(TIMESTAMPDIFF(SECOND, chamado.datainicio , chamado.datafinal )) as tempo,
                    (SELECT
                    COUNT( DISTINCT cast(cha1.datafinal as date) ) qtd_dias
                 FROM chamado cha1
                 WHERE date(datafinal) BETWEEN date('$data_inicio') AND date('$data_final')
                   AND cha1.status = 'Finalizado') as qtd_dias
            from chamado 
            left join categoria on categoria.id = chamado.categoria_id 
            left join usuarios usuario on usuario.id = chamado.usuario_id 
            where date(chamado.datafinal) BETWEEN date('$data_inicio') and date('$data_final')
              and chamado.status = 'Finalizado'
              and ('$usuario' = '' or chamado.usuario_id = cast('$usuario' as signed))
              and ('$sistema' = '' or lower(chamado.sistema) like lower('%$sistema%'))
              AND ('$cnpj' = '' or chamado.cnpj = '$cnpj')";
            
    if($categoria != ''){
      $sql .=" AND chamado.categoria_id".($exceto == 'true' ? " not" : "")." in ($categoria)";
    }

    $sql.=" GROUP BY sistemaAgrupado ";
    if($tipo_order == 'Quantidade'){
      $sql .=" order by count(chamado.id_chamado)  desc ";
    }else{
      $sql .=" order by sum(TIMESTAMPDIFF(SECOND, chamado.datainicio , chamado.datafinal )) desc ";
    }
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>