<?php
    header("Content-type: text/html; charset=utf-8");

    if (!isset($_SESSION)) {
        if(isset($_COOKIE['sessionID']) && $_COOKIE['sessionID'] != ''){
            session_id($_COOKIE['sessionID']);
            session_start();
        }else{
            header("Location: ../");
            return;
        }
    }

    if (!isset($_SESSION['UsuarioID'])) {
        setcookie("sessionID", session_id(), time() - 360,'/');
        header("Location: ../");
        exit;
    }

    $_SESSION['lastLogin'] = date("Y-m-d H:i:s");
    $email = md5($_SESSION['Email']);
?>