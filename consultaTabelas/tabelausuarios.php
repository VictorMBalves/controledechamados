<?php
     include '../include/dbconf.php';
     $sql = $conn->prepare('SELECT id, nome, usuario, email FROM usuarios ORDER BY id desc');
     $sql->execute();
     $result = $sql->fetchall();
     echo json_encode($result);
?>