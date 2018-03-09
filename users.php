<?php
 include('include/db.php');
    
    //get search term
    $searchTerm = $_GET['term'];
    
    $searchTerm = str_replace("@","",$searchTerm);

    //get matched data from skills table
    $query = $conn->query("SELECT * FROM usuarios WHERE nome LIKE '%".$searchTerm."%'");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['nome'];
    }
    
    //return json data
    echo json_encode($data);
