<?php
require_once '../include/Database.class.php';
$db = Database::conexao();
$searchTerm = $_GET['term'];
$query = $db->prepare("SELECT nome FROM empresa WHERE nome LIKE '%".$searchTerm."%'");
$query->execute();
$result = $query->fetchall(PDO::FETCH_ASSOC);

echo json_encode($result);