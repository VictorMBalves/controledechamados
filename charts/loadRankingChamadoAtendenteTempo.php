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
    $agrupado = $_GET['agrupado'];
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

    if($agrupado == 'false'){
      $sql = "SELECT id, nome, datainicio , datafinal, ";
    }else{
      $sql = "SELECT id, nome, sum(TIMESTAMPDIFF(SECOND, datainicio , datafinal )) as tempo, ";
    }
  
    $sql.= " 
                (SELECT
                    COUNT( DISTINCT cast(cha1.datafinal as date) ) qtd_dias
                FROM chamado cha1
                WHERE date(datafinal) BETWEEN date('$data_inicio') AND date('$data_final')
                AND cha1.status = 'Finalizado') as qtd_dias
            from ( " ;

    if($somentePlantao == 'false'){
      $sql.= " SELECT  usuario.id, usuario.nome, chamado.datainicio , chamado.datafinal
              from chamado
              left join usuarios usuario on usuario.id = chamado.usuario_id 
              where date(chamado.datafinal) BETWEEN date('$data_inicio') and date('$data_final') ";
      $sql.= getWhereSql();

      if($considerarPlantao == 'true'){
          $sql.= " UNION ALL ";
      }
    }
            
    if($somentePlantao != 'false' || $considerarPlantao != 'false'){
        $sql.= " SELECT  usuario.id, usuario.nome, timestamp(concat(data, ' ', horainicio)) as datainicio, 
                timestamp(concat(data, ' ', horafim)) as datafinal
                from plantao chamado
                left join usuarios usuario on usuario.id = chamado.usuario_id 
                where date(chamado.data) BETWEEN date('$data_inicio') and date('$data_final') ";
        $sql.= getWhereSql();
    }

    $sql.="  ) x ";
    
    if($agrupado == 'false'){
      $sql.=" order by datainicio ";
    }else{
      $sql.=" GROUP by id, nome
      order by sum(TIMESTAMPDIFF(SECOND, datainicio , datafinal )) desc";
    }
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>