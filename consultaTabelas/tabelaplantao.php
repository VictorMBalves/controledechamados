<?php
       require_once '../include/Database.class.php';
       $db = Database::conexao();
       
       if($_POST == null){
           $data = date('Y-m').'-01';
           $data2 = date('Y-m-t');
           $sql ="SELECT id_plantao, usuario, status, empresa, contato, telefone, DATE_FORMAT(data,'%d/%m/%Y') as data FROM plantao WHERE date(data) BETWEEN '$data' and '$data2' ORDER BY id_plantao DESC";
           $query = $db->prepare($sql);
           $query->execute();
           $resultado = $query->fetchall(PDO::FETCH_ASSOC);
           echo json_encode($resultado);
       }else{
           $status = $_POST['status'];
           $palavra = $_POST['flexdatalist-palavra'];
           $usuario = $_POST['usuario'];
           $datainicio = $_POST['datainicio'];
           $datafim = $_POST['datafinal'];
   
           $query = "SELECT id_plantao, usuario, status, empresa, contato, telefone, DATE_FORMAT(data,'%d/%m/%Y') as data FROM plantao ";
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
           if ($datainicio != null) {
               if ($status != null || $palavra != null || $usuario != null) {
                   $query = " $query AND date(data) BETWEEN '".$datainicio."' AND '".$datafim."'";
               } else {
                   $query = " $query WHERE date(data) BETWEEN '".$datainicio."' AND '".$datafim."'";
               }
           }
           $sql = " $query ORDER BY id_plantao desc";
   
           $query = $db->prepare($sql);
           $query->execute();
           $resultado = $query->fetchall(PDO::FETCH_ASSOC);
           echo json_encode($resultado);
       }
    
    ?>