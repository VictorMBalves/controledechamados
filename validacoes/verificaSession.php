<?php
    header("Content-type: text/html; charset=utf-8");
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['UsuarioID'])) {
        $_SESSION['page_request'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
        header("Location: ../");
        exit;
    }

    if ($_SESSION['UsuarioNivel'] == 1) {
        $email = md5($_SESSION['Email']);
        header("Location: ../pages/chamadoespera");
        exit;
    }
    $email = md5($_SESSION['Email']);
?>