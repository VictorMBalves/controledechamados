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
    $considerarPlantao = $_GET['considerarPlantao'];
    $somentePlantao = $_GET['somentePlantao'];

    function getWhereSql($table_name){
        global $usuario, $sistema, $cnpj, $categoria, $exceto;
  
        $sql = " and ('$usuario' = '' or $table_name.usuario_id = cast('$usuario' as signed))
                      and ('$sistema' = '' or lower($table_name.sistema) like lower('%$sistema%'))
                      and $table_name.status = 'Finalizado'
                      and ('$cnpj' = '' or $table_name.cnpj = '$cnpj') ";
        if($categoria != ''){
            $sql.=" AND $table_name.categoria_id".($exceto == 'true' ? " not" : "")." in ($categoria) ";
        }
  
        return $sql;
    }

    $sql = "SELECT  x.horas, count(id_chamado) as qtd, 
                    (case x.horas   when 7 then '07h às 08h' 
                                    when 8 then '08h às 09h'
                                    when 9 then '09h às 10h'
                                    when 10 then '10h às 11h'
                                    when 11 then '11h às 12h'
                                    when 12 then '12h às 13h'
                                    when 13 then '13h às 14h'
                                    when 14 then '14h às 15h'
                                    when 15 then '15h às 16h'
                                    when 16 then '16h às 17h'
                                    when 17 then '17h às 18h'
                                    when 18 then '18h às 19h'
                                    when 19 then '19h às 20h'
                                    when 20 then '20h às 21h'
                                    when 21 then '21h às 22h' end) as descricao 
            FROM ( "; 

if($somentePlantao == 'false'){
    $sql.= " select x.horas, id_chamado ";
    $sql.= " from (select 7 as horas union select 8 as horas union select 9 as horas union select 10 as horas union select 11 as horas union select 12 as horas union select 13 as horas union select 14 as horas union select 15 as horas union select 16 as horas union select 17 as horas union select 18 as horas union select 19 as horas union select 20 as horas union select 21 as horas) x ";
    $sql.= " left join chamado on hour(chamado.datafinal) = x.horas and date(chamado.datafinal) BETWEEN '$data_inicio' and '$data_final' ";
    $sql.= getWhereSql('chamado');
    if($considerarPlantao == 'true'){
        $sql.=" UNION ALL ";
    }
}


if($somentePlantao != 'false' || $considerarPlantao != 'false'){
    $sql.= " select x.horas, id_plantao as id_chamado ";
    $sql.= " from (select 7 as horas union select 8 as horas union select 9 as horas union select 10 as horas union select 11 as horas union select 12 as horas union select 13 as horas union select 14 as horas union select 15 as horas union select 16 as horas union select 17 as horas union select 18 as horas union select 19 as horas union select 20 as horas union select 21 as horas) x ";
    $sql.= " left join plantao on hour(plantao.horainicio) = x.horas and date(plantao.data) BETWEEN '$data_inicio' and '$data_final' ";
    $sql.= getWhereSql('plantao');
}

    $sql.=" ) x group by x.horas";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    //  echo $sql;
    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>
