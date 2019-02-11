<?php
header("Content-type: text/html; charset=utf-8");
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['UsuarioID'])) {
    session_destroy();
    header("Location: ../");
    exit;
}
    $_SESSION['lastLogin'] = date("Y-m-d H:i:s");
    $email = md5($_SESSION['Email']);
?>