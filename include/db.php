<?php
$servername = "localhost";
$username = "root";
$password = "d8hj0ptr";
$dbname = "chamados";
$limit = 15;

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
$conn->set_charset("utf8");
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
} 

?> 
