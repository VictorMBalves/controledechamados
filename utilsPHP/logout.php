<?php 
    session_start(); 
    session_destroy(); 
    setcookie("sessionID", session_id(), time() - 360,'/');
    header("Location: ../"); 
    exit;
?>
