<?php
header("Content-type: text/html; charset=utf-8");

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['UsuarioID'])) {
    session_destroy();
    header("Location: ../index.html");
    exit;
}

if($_SESSION['UsuarioNivel'] != 3) {
    session_destroy();
    header("Location: ../pages/home.html");
    exit;
}

$email = md5($_SESSION['Email']);
?>