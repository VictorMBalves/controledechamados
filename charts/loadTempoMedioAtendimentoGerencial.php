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

     $sql = " select   (sum(tempo)/ COUNT(id_chamado)) as tempo, 
                    COUNT(id_chamado) as numeroChamados
             from ( " ;

    if($somentePlantao == 'false'){
        $sql.= " SELECT  TIMESTAMPDIFF(SECOND,datainicio,datafinal) as tempo, 
                         chamado.id_chamado
                from chamado
                left join usuarios usuario on usuario.id = chamado.usuario_id 
                where date(chamado.datafinal) BETWEEN date('$data_inicio') and date('$data_final') ";
        $sql.= getWhereSql();

        if($considerarPlantao == 'true'){
            $sql.= " UNION ALL ";
        }
    }
        
    if($somentePlantao != 'false' || $considerarPlantao != 'false'){
        $sql.= " SELECT TIMESTAMPDIFF(SECOND, timestamp(concat(data, ' ', horainicio)), timestamp(concat(data, ' ', horafim))) as tempo,
                        chamado.id_plantao as id_chamado        
                from plantao chamado
                left join usuarios usuario on usuario.id = chamado.usuario_id 
                where date(chamado.data) BETWEEN date('$data_inicio') and date('$data_final') ";
        $sql.= getWhereSql();
    }

    $sql.="  ) x ";


    $stmt = $db->prepare($sql);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>