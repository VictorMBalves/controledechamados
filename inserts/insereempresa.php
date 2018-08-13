<?php
  require_once '../include/Database.class.php';
  include '../validacoes/verificaSessionFinan.php';
  $db = Database::conexao();

  $empresa=$_POST['empresa'];
  $cnpj=$_POST['cnpj'];
  $situacao=$_POST['situacao'];
  $telefone=$_POST['telefone'];
  $celular=$_POST['celular'];
  $backup=$_POST['backup'];
  $sql = $db->prepare("INSERT INTO empresa (nome, cnpj, situacao, telefone, celular, backup) VALUES ('$empresa','$cnpj','$situacao','$telefone','$celular','$backup')") or die(mysql_error());
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
