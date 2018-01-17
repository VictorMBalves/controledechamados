<?php
$dsn = "mysql:host=localhost;dbname=chamados;charset=utf8";
$username = "root";
$password = "ledZeppelin";
$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
$conn = new PDO($dsn, $username, $password, $opt);
?>