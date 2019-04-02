<?php
require_once '../include/Database.class.php';
$db = Database::conexao();
//get search term
$searchTerm = $_GET['term'];
if($searchTerm)
    $query = $db->prepare("SELECT nome FROM usuarios WHERE lower(nome) LIKE lower('%".$searchTerm."%')");
else
    $query = $db->prepare("SELECT id, nome FROM usuarios WHERE nivel IN(2, 3)");
$query->execute();
$result = $query->fetchall(PDO::FETCH_ASSOC);

echo json_encode($result);