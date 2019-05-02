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
    
    $sql = " select sistemaAgrupado, count(id_chamado) as qtd, sum(tempo) as tempo,
                (SELECT
                    COUNT( DISTINCT cast(cha1.datafinal as date) ) qtd_dias
                FROM chamado cha1
                WHERE date(datafinal) BETWEEN date('$data_inicio') AND date('$data_final')
                AND cha1.status = 'Finalizado') as qtd_dias
             from ( " ;

    if($somentePlantao == 'false'){
      $sql.= " SELECT  (case when upper(chamado.sistema) like '%LIGHT%' then 'LIGHT'
                              when upper(chamado.sistema) like '%MANAGER%' then 'MANAGER'
                              when upper(chamado.sistema) like '%EMISSOR%' then 'EMISSOR'
                              when upper(chamado.sistema) like '%GOURMET%' then 'GOURMET' 
                              else 'OUTROS' end) as sistemaAgrupado, 
                              chamado.id_chamado, 
                              TIMESTAMPDIFF(SECOND, chamado.datainicio , chamado.datafinal) as tempo
              from chamado
              left join usuarios usuario on usuario.id = chamado.usuario_id 
              where date(chamado.datafinal) BETWEEN date('$data_inicio') and date('$data_final') ";
      $sql.= getWhereSql();

      if($considerarPlantao == 'true'){
          $sql.= " UNION ALL ";
      }
    }
          
    if($somentePlantao != 'false' || $considerarPlantao != 'false'){
      $sql.= " SELECT (case when upper(chamado.sistema) like '%LIGHT%' then 'LIGHT'
                              when upper(chamado.sistema) like '%MANAGER%' then 'MANAGER'
                              when upper(chamado.sistema) like '%EMISSOR%' then 'EMISSOR'
                              when upper(chamado.sistema) like '%GOURMET%' then 'GOURMET' 
                              else 'OUTROS' end) as sistemaAgrupado, 
                              chamado.id_plantao as id_chamado, 
                              TIMESTAMPDIFF(SECOND, timestamp(concat(data, ' ', horainicio)), timestamp(concat(data, ' ', horafim))) as tempo
              from plantao chamado
              left join usuarios usuario on usuario.id = chamado.usuario_id 
              where date(chamado.data) BETWEEN date('$data_inicio') and date('$data_final') ";
      $sql.= getWhereSql();
    }

    $sql.="  ) x
        group by sistemaAgrupado ";

    if($tipo_order == 'Quantidade'){
      $sql .=" order by count(id_chamado) desc ";
    }else{
      $sql .=" order by sum(tempo) desc ";
    }

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>