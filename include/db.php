<?php
$servername = "localhost";
$username = "root";
$password = "ledzeppelin";
$dbname = "chamados";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
$conn->set_charset("utf8");
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
} 
?> 
