<?php
require_once '../include/Database.class.php';
$db = Database::conexao();
//get search term
$searchTerm = $_GET['term'];
$query = $db->prepare("SELECT nome FROM usuarios WHERE lower(nome) LIKE lower('%".$searchTerm."%')");
$query->execute();
$result = $query->fetchall(PDO::FETCH_ASSOC);

echo json_encode($result);