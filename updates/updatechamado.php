<?php 
  require_once '../include/Database.class.php';
  include '../validacoes/verificaSession.php';
  $db = Database::conexao();

  $id=$_POST['id_chamado'];
  $empresa=$_POST['empresa'];
  $contato=$_POST['contato'];
  $telefone=$_POST['telefone'];
  $sistema=$_POST['sistema'];
  $versao=$_POST['versao'];
  $formacontato=$_POST['formacontato'];
  $categoria=$_POST['categoria'];
  $descproblema=str_replace("'","''",$_POST['descproblema']);
  $backup=$_POST['backup'];
  $sql = $db->prepare("UPDATE empresa set backup = '$backup' where nome='$empresa'") or die(mysql_error());
  try
  {
    $sql->execute();
  }catch (PDOException $e)
  {
    echo $e->getMessage();
    exit;
  }
  $sql = $db->prepare("UPDATE chamado SET  contato='$contato', telefone='$telefone', sistema='$sistema', formacontato='$formacontato', descproblema='$descproblema', categoria='$categoria', versao='$versao'  WHERE id_chamado='$id'")
  or die(mysql_error());
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
