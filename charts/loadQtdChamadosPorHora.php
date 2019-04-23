<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $data_inicio = $_GET['dataInicial'];
    $data_final =  $_GET['dataFinal'];
    $usuario = $_GET['usuario'];
    $sistema = $_GET['sistema'];
    $cnpj = $_GET['cnpj'];
    $sql = "SELECT x.horas, count(chamado.id_chamado) as qtd
            from (select 7 as horas union select 8 as horas union select 9 as horas union select 10 as horas union select 11 as horas union select 12 as horas union select 13 as horas union select 14 as horas union select 15 as horas union select 16 as horas union select 17 as horas union select 18 as horas union select 19 as horas union select 20 as horas union select 21 as horas) x
            left join chamado on hour(chamado.datafinal) = x.horas and chamado.datafinal BETWEEN '$data_inicio' and '$data_final'
                                                                   and ('$usuario' = '' or chamado.usuario_id = cast('$usuario' as signed))
                                                                   and ('$sistema' = '' or lower(chamado.sistema) like lower('%$sistema%'))
                                                                   AND ('$cnpj' = '' or chamado.cnpj = '$cnpj')
            group by x.horas";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    //  echo $sql;
    // if(sizeof($resultado) == 0){
    //     return;
    // }
    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>