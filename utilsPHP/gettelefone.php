<?php
require_once '../include/Database.class.php';
$db = Database::conexao();

function retorna($nome, $db)
{
    $sql = "SELECT `telefone`, `celular`,`backup`
        FROM `empresa` WHERE `nome` = '{$nome}' ";
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $arr = [];
    if ($query->rowcount() > 0) {
        $arr['telefone'] = $result['telefone'];
        $arr['celular'] = $result['celular'];
        $arr['backup'] = $result['backup'];
    }
    return json_encode($arr);
}

if (isset($_GET['empresa'])) {
    echo retorna($_GET['empresa'], $db);
}
