<?php 
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $week_start =  $_GET['dtInicial2'];
    $week_end = $_GET['dtFinal2'];
    $sql = "SELECT DISTINCT 
                cat.descricao AS descricao,
                cat.categoria AS categoria,
                count(datainicio) AS quantidade
            FROM chamado cha 
                INNER JOIN categoria cat ON cat.id in (cha.categoria_id) where date(cha.datainicio) BETWEEN '$week_start' and '$week_end' 
            GROUP BY cat.descricao, cat.categoria 
            ORDER BY cat.descricao ";

    $query = $db->prepare($sql);
    $query->execute();
    $categorias = $query->fetchall(PDO::FETCH_ASSOC);

    echo json_encode($categorias, JSON_UNESCAPED_UNICODE);
?>