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

    if ($_SESSION['UsuarioNivel'] == 1) {
        $email = md5($_SESSION['Email']);
        header("Location: ../pages/chamadoespera.php");
        exit;
    }
    $email = md5($_SESSION['Email']);
?>