<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $mes = $_GET['mes'];
    $sql = "SELECT usuario FROM escalasobreaviso WHERE mes = '$mes' AND YEAR(inicioperido) = YEAR(CURDATE()) ORDER BY ordem";
    $query = $db->prepare($sql);
    $query->execute();
    $resultado = $query->fetchall();

    if ($resultado == null) {
        echo "null";
    } else {
        echo retornadados($resultado);
    }

    function retornadados($resultado)
    {
        $arr = [];
        for ($i = 0; $i < count($resultado); $i++) {
            $arr[$i] = $resultado[$i]['usuario'];
        }
        return json_encode($arr);
    }
?>