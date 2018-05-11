<?php
require_once '../include/Database.class.php';
$db = Database::conexao();

$user = filter_input(INPUT_GET, 'usuario');
if ($user == '') {
    echo '<p id="pValid" class="text-warning text-left"><small>Preencha o campo <strong>LOGIN</strong>!</small></p>';
} else {
    $sql = "SELECT * FROM `usuarios` WHERE `usuario` = '{$user}'";
    $query = $db->prepare($sql);
    $query->execute();
    if ($query->rowcount() > 0) {
        echo '<p id="pValid" class="text-danger text-left"><small>Usuário <strong>'.$user.'</strong> já cadastrado!</small></p>';
    } else {
        echo '<p id="pValid" class="text-success text-left"><small>Usuário <strong>'.$user.'</strong> disponivel</small></p>';
    }
}
