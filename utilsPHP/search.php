<?php
require_once '../include/Database.class.php';
$db = Database::conexao();
$searchTerm = $_GET['term'];
$query = $db->prepare("SELECT nome FROM empresa WHERE nome LIKE '%".$searchTerm."%'");
$query->execute();
$result = $query->fetchAll();
if ($query->rowcount() > 0) {
    foreach($result as $dado){
        $data[] = $dado['nome'];
    }
}
echo json_encode($data);