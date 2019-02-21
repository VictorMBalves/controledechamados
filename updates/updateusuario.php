<?php
  require_once '../include/Database.class.php';
  include '../validacoes/verificaSession.php';
  $db = Database::conexao();

  $id=$_POST['id'];
  $nome=$_POST['nome'];
  $usuario=$_POST['usuario'];
  $email=$_POST['email'];
  $senha=$_POST['senha'];
  $nivel=$_POST['nivel'];
  $enviarEmail = $_POST['enviarEmail'];
  $pass =SHA1($senha);

  $sql = $db->prepare("UPDATE usuarios SET nome='$nome', usuario='$usuario', email='$email', senha='$pass', nivel='$nivel', enviarEmail='$enviarEmail' WHERE id='$id'") or die(mysql_error());
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
