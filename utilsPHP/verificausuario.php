<?php
require_once '../include/Database.class.php';
$db = Database::conexao();

$user = filter_input(INPUT_GET, 'usuario');
if ($user == '') {
        echo 'vazio';
} else {
    $sql = "SELECT * FROM `usuarios` WHERE `usuario` = '{$user}'";
    $query = $db->prepare($sql);
    $query->execute();
    if ($query->rowcount() > 0) {
        echo 'invalido';
    } else {
        echo 'valido';
    }
}
