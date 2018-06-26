<?php
if(isset($_POST['mes'])){
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $mes = $_POST['mes'];
    $sql = "DELETE FROM escalasobreaviso WHERE mes = '$mes'";
    $query = $db->prepare($sql);
    $query->execute();
    if($query->rowcount() > 0){
        echo 'success';
    }else{
        echo 'fail';
    }
}
?>