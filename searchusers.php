<?php
include('include/db.php');

//get search term
$searchTerm = $_GET['term'];

//get matched data from skills table
$query = $conn->query("SELECT * FROM usuarios WHERE lower(nome) LIKE lower('%".$searchTerm."%')");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['nome'];
}

//return json data
echo json_encode($data);
