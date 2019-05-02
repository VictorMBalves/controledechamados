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

    function getWhereSql(){
      global $usuario, $sistema, $cnpj, $categoria, $exceto;

      $sql = " and ('$usuario' = '' or chamado.usuario_id = cast('$usuario' as signed))
                    and ('$sistema' = '' or lower(chamado.sistema) like lower('%$sistema%'))
                    and chamado.status = 'Finalizado'
                    and ('$cnpj' = '' or chamado.cnpj = '$cnpj') ";
      if($categoria != ''){
          $sql.=" AND chamado.categoria_id".($exceto == 'true' ? " not" : "")." in ($categoria) ";
      }

      return $sql;
  }

  $sql = " select tipo, count(id_chamado) as qtd,
                (SELECT
                    COUNT( DISTINCT cast(cha1.datafinal as date) ) qtd_dias
                FROM chamado cha1
                WHERE date(datafinal) BETWEEN date('$data_inicio') AND date('$data_final')
                AND cha1.status = 'Finalizado') as qtd_dias
             from ( " ;

  if($somentePlantao == 'false'){
    $sql.= " SELECT 'TOTAL'  as tipo,
                    chamado.id_chamado
            from chamado
            left join usuarios usuario on usuario.id = chamado.usuario_id 
            where date(chamado.datafinal) BETWEEN date('$data_inicio') and date('$data_final') ";
    $sql.= getWhereSql();

    $sql.= " UNION ALL ";

    $sql.= " SELECT 'ATRASADOS'  as tipo,
                    chamado.id_chamado
            from chamado
            INNER JOIN chamadoespera espera ON espera.id_chamadoespera = chamado.id_chamadoespera AND espera.usuario_id != 56 AND espera.notification IS TRUE
            left join usuarios usuario on usuario.id = chamado.usuario_id 
            where date(chamado.datafinal) BETWEEN date('$data_inicio') and date('$data_final') 
              AND ((espera.dataagendamento IS NULL OR DATE_ADD(espera.dataagendamento, INTERVAL +10 MINUTE) < chamado.datainicio) 
               OR DATE_ADD(espera.data, INTERVAL +10 MINUTE) < chamado.datainicio) ";

    $sql.= getWhereSql();

    if($considerarPlantao == 'true'){
      $sql.= " UNION ALL ";
    }
  }

  if($somentePlantao != 'false' || $considerarPlantao != 'false'){
    $sql.= " SELECT 'TOTAL'  as tipo,
                    chamado.id_plantao as id_chamado
            from plantao chamado
            left join usuarios usuario on usuario.id = chamado.usuario_id 
            where date(chamado.data) BETWEEN date('$data_inicio') and date('$data_final') ";
    $sql.= getWhereSql();
  }

  $sql.="  ) x
         group by tipo ";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    // echo $sql;
    // if(sizeof($resultado) == 0){
    //     return;
    // }
    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>