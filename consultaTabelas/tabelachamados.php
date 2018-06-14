<?php
    include '../include/dbconf.php'; 
    if($_POST == null){
        $data = date('Y-m').'-01';
        $data2 = date('Y-m-t');
        $sql ="SELECT id_chamado,usuario, status, empresa, contato, telefone, DATE_FORMAT(datainicio,'%d/%m/%Y') as data FROM chamado WHERE date(datainicio) BETWEEN '$data' and '$data2' ORDER BY id_chamado DESC";
        $query = $conn->prepare($sql);
        $query->execute();
        $resultado = $query->fetchall();
        echo json_encode($resultado);
    }else{
        $status = $_POST['status'];
        $palavra = $_POST['palavra'];
        $usuario = $_POST['usuario'];
        $data = $_POST['data'];
        $query = "SELECT id_chamado, usuario, status, empresa, contato, telefone, DATE_FORMAT(datainicio,'%d/%m/%Y') as data  FROM chamado ";
        if ($status != null) {
            $query = " $query WHERE status LIKE '$status' ";
        }
        if ($palavra != null) {
            if ($status != null) {
                $query = " $query AND empresa LIKE '%".$palavra."%' ";
            } else {
                $query = " $query WHERE empresa LIKE '%".$palavra."%' ";
            }
        }
        if ($usuario != null) {
            if ($status != null || $palavra != null) {
                $query = " $query AND usuario LIKE '$usuario' ";
            } else {
                $query = " $query WHERE usuario LIKE '$usuario' ";
            }
        }
        if ($data != null) {
            if ($status != null || $palavra != null || $usuario != null) {
                $query = " $query AND datainicio LIKE '%".$data."%' ";
            } else {
                $query = " $query WHERE datainicio LIKE '%".$data."%'  ";
            }
        }
        $sql = " $query ORDER BY datainicio desc";

        $query = $conn->prepare($sql);
        $query->execute();
        $resultado = $query->fetchall();
        echo json_encode($resultado);
    }
?>