<?php 
  require_once '../include/Database.class.php';
  include '../validacoes/verificaSession.php';
  $db = Database::conexao();

  $id=$_POST['id'];
  $empresa=$_POST['empresa'];
  $cnpj=$_POST['cnpj'];
  $situacao=$_POST['situacao'];
  $telefone=$_POST['telefone'];
  $celular=$_POST['celular'];
  $backup = $_POST['backup'];
  $sql = $db->prepare("UPDATE empresa SET nome='$empresa', cnpj='$cnpj', situacao='$situacao', telefone='$telefone', celular='$celular', backup='$backup' WHERE id_empresa='$id'") or die(mysql_error());
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
