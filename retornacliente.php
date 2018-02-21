<?php
include('include/dbconf.php');
$dados = $conn->prepare("SELECT * FROM empresa");
$dados->execute();
echo json_encode($dados->fetchAll(PDO::FETCH_ASSOC));
