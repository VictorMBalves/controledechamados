<?php 
    require_once '../include/Database.class.php';
    include '../validacoes/verificaSession.php';
    $db = Database::conexao();
    $senha=$_POST['senha'];
    $idusuario=$_SESSION['UsuarioID'];
    $sql = $db->prepare("UPDATE usuarios SET senha=sha1('$senha') WHERE id='$idusuario'")
    or die(mysql_error());
    try
    {
        $sql->execute();
        echo 'success';
        exit;
    }
        catch (PDOException $e)
    {
        echo $e->getMessage();
        exit;
    }
?>