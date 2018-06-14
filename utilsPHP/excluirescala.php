<?php
if(isset($_POST['mes'])){
    include '../include/dbconf.php';
    $mes = $_POST['mes'];
    $sql = "DELETE FROM escalasobreaviso WHERE mes = '$mes'";
    $query = $conn->prepare($sql);
    $query->execute();
    if($query->rowcount() > 0){
        echo 'success';
    }else{
        echo 'fail';
    }
}
?>