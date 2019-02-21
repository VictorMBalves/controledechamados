<?php 
    require_once '../include/Database.class.php';
    include '../validacoes/verificaSession.php';
    $db = Database::conexao();
    $senha=$_POST['senha'];
    $idusuario=$_SESSION['UsuarioID'];
    $usuario=$_POST['usuario'];
    $sql = $db->prepare("UPDATE usuarios SET senha=sha1('$senha'), nome='$usuario' WHERE id='$idusuario'")
    or die(mysql_error());
    try
    {
        $sql->execute();
        $_SESSION['UsuarioNome'] = $usuario;
        echo 'success';
        exit;
    }
        catch (PDOException $e)
    {
        echo $e->getMessage();
        exit;
    }
?>