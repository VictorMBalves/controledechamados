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
    
    $sql = " select id, descricao, sum(idchamado) as qtd, 
                (SELECT
                    COUNT( DISTINCT cast(cha1.datafinal as date) ) qtd_dias
                FROM chamado cha1
                WHERE date(datafinal) BETWEEN date('$data_inicio') AND date('$data_final')
                AND cha1.status = 'Finalizado') as qtd_dias
             from ( " ;

    if($somentePlantao == 'false'){
        $sql.= " SELECT  categoria.id, categoria.descricao, 1 as idchamado
                from chamado
                left join categoria on FIND_IN_SET(categoria.id, chamado.categoria_id)
                left join usuarios usuario on usuario.id = chamado.usuario_id 
                where date(chamado.datafinal) BETWEEN date('$data_inicio') and date('$data_final') ";
        $sql.= getWhereSql();

        if($considerarPlantao == 'true'){
            $sql.= " UNION ALL ";
        }
    }
             
    if($somentePlantao != 'false' || $considerarPlantao != 'false'){
        $sql.= " SELECT  categoria.id, categoria.descricao, 1 as idchamado
                from plantao chamado
                left join categoria on FIND_IN_SET(categoria.id, chamado.categoria_id)
                left join usuarios usuario on usuario.id = chamado.usuario_id 
                where date(chamado.data) BETWEEN date('$data_inicio') and date('$data_final') ";
        $sql.= getWhereSql();
    }

    $sql.="  ) x
            group by id, descricao
            order by sum(idchamado) desc";
    
    // echo $sql;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>