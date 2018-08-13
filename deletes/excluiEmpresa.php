<?php
    include '../validacoes/verificaSessionFinan.php';
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $id = $_POST['id'];
    $sql = $db->prepare("DELETE FROM empresa WHERE id_empresa=$id");
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