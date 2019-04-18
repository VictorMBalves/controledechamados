<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $data_inicio = $_GET['dataInicial'];
    $data_final =  $_GET['dataFinal'];
    $usuario = $_GET['usuario'];
    $sistema = $_GET['sistema'];
    $sql = "SELECT  categoria.id, categoria.descricao, sum(TIMESTAMPDIFF(SECOND, chamado.datainicio , chamado.datafinal )) as tempo
            from chamado
            left join categoria on categoria.id = chamado.categoria_id
            left join usuarios usuario on usuario.id = chamado.usuario_id
            where date(chamado.datafinal) BETWEEN date('$data_inicio') and date('$data_final')
              and ('$usuario' = '' or chamado.usuario_id = '$usuario')
              and ('$sistema' = '' or lower(chamado.sistema) like lower('%$sistema%'))
            GROUP by categoria.id, categoria.descricao
            order by sum(TIMESTAMPDIFF(SECOND, chamado.datainicio , chamado.datafinal )) desc";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    // echo $sql;
    // if(sizeof($resultado) == 0){
    //     return;
    // }
    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>