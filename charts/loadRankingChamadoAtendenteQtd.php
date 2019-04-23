<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $data_inicio = $_GET['dataInicial'];
    $data_final =  $_GET['dataFinal'];
    $usuario = $_GET['usuario'];
    $sistema = $_GET['sistema'];
    $cnpj = $_GET['cnpj'];
    $sql = "SELECT   usuario.id, usuario.nome, count(chamado.id_chamado) as qtd,
                    (SELECT
                    COUNT( DISTINCT cast(cha1.datafinal as date) ) qtd_dias
                 FROM chamado cha1
                 WHERE date(datafinal) BETWEEN date('$data_inicio') AND date('$data_final')
                   AND cha1.status = 'Finalizado') as qtd_dias
            from chamado
            left join categoria on categoria.id = chamado.categoria_id
            left join usuarios usuario on usuario.id = chamado.usuario_id
            where date(chamado.datafinal) BETWEEN date('$data_inicio') and date('$data_final')
            and ('$usuario' = '' or chamado.usuario_id = cast('$usuario' as signed))
            and ('$sistema' = '' or lower(chamado.sistema) like lower('%$sistema%'))
            AND ('$cnpj' = '' or chamado.cnpj = '$cnpj')
            GROUP by usuario.id, usuario.nome
            order by count(chamado.id_chamado) desc";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    //  echo $sql;
    // if(sizeof($resultado) == 0){
    //     return;
    // }
    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>