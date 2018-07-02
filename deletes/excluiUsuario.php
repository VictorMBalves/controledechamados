<?php
    include '../validacoes/verificaSessionAdmin.php';
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $id = $_POST['id'];
    $sql = $db->prepare("DELETE FROM usuarios WHERE id=$id");
    try
    {
        $sql->execute();
        echo 'success';
        exit;
    }catch (PDOException $e)
    {
        echo $e->getMessage();
        exit;
    }
?>