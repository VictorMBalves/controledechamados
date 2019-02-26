<?php 
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $week_start =  $_GET['dtInicial2'];
    $week_end = $_GET['dtFinal2'];
    $sql = "SELECT DISTINCT categoria from chamado where date(datainicio) BETWEEN '$week_start' and '$week_end' group by date(datainicio), categoria  ORDER BY categoria";

    $query = $db->prepare($sql);
    $query->execute();
    $categorias = $query->fetchall(PDO::FETCH_ASSOC);

    if(sizeof($categorias) == 0){
        return;
    }

    $categoriasArray = ['Mês'];
    foreach($categorias as $categoria){
        if($categoria['categoria'] == NULL)
            $categoria['categoria'] = "Não informado";
        array_push($categoriasArray, $categoria['categoria']);
    }
    
    $query = $db->prepare("SELECT DISTINCT date(datainicio) from chamado where date(datainicio) BETWEEN '$week_start' and '$week_end' group by date(datainicio) ORDER BY date(datainicio)");
    $query->execute();
    $datas = $query->fetchall(PDO::FETCH_ASSOC);
    
    $dataTable = [];
    array_push($dataTable, $categoriasArray);

    foreach ($datas as $data) {
        $datasArray = [];
        $datainicio = date_create($data['date(datainicio)']);
        $dataFormatada = date_format($datainicio, 'd/m/Y');

        array_push($datasArray, $dataFormatada);

        $datainicio = $data['date(datainicio)'];
        $query = $db->prepare("SELECT cha.categoria, count(datainicio) from chamado cha where date(datainicio) = '$datainicio'  group by date(datainicio),cha.categoria ORDER BY categoria");
        $query->execute();
        $resultados = $query->fetchall(PDO::FETCH_ASSOC);
        $atual = 0;
        foreach ($categorias as $categoria) {
            if ($atual == sizeof($resultados) || $categoria['categoria'] == $resultados[$atual]['categoria']) {
                if ($atual < sizeof($resultados)) {
                    if ($categoria['categoria'] == $resultados[$atual]['categoria']) {
                        array_push($datasArray, intval($resultados[$atual]['count(datainicio)']));
                        $totalcategorias[$categoria['categoria']] += $resultados[$atual]['count(datainicio)'];
                        $total += $resultados[$atual]['count(datainicio)'];
                        $atual++;
                    }
                } else {
                    array_push($datasArray, 0);
                }
            } else {
                array_push($datasArray, 0);
            }
        }
        array_push($dataTable, $datasArray);
    }

    echo json_encode($dataTable, JSON_UNESCAPED_UNICODE);
?>