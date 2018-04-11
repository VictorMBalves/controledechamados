<?php
    include('include/dbconf.php');
    $mes = $_GET['mes'];
    $sql = "SELECT usuario FROM escalasobreaviso WHERE mes = '$mes' ORDER BY ordem";
    $query = $conn->prepare($sql);
    $query->execute();
    $resultado = $query->fetchall();

    if($resultado == null){
        echo "null";        
    }else{
        echo retornadados($resultado);
    }

    function retornadados($resultado)
    {
        $arr = [];
        for($i = 0; $i < count($resultado); $i++){
            $arr[$i] = $resultado[$i]['usuario'];
        }
        return json_encode($arr);
    }
?>