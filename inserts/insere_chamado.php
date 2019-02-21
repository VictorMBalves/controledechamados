<?php 
  require_once '../include/Database.class.php';
  include '../validacoes/verificaSession.php';
  $db = Database::conexao();
  $datainicio = date("Y-m-d H:i:s");
  $status = "Aberto";
  $empresa=$_POST['empresa'];
  $contato=$_POST['contato'];
  $telefone=$_POST['telefone'];
  $sistema=$_POST['sistema'];
  $versao=$_POST['versao'];
  $formacontato=$_POST['formacontato'];
  $categoria=$_POST['categoria'];
  $descproblema=str_replace("'","''",$_POST['descproblema']);
  $usuario=$_SESSION['UsuarioNome'];
  $backup=$_POST['backup'];
  $usuario_id = $_SESSION['UsuarioID'];
  $sql = $db->prepare("UPDATE empresa set backup = '$backup' where nome='$empresa'") or die(mysql_error());
  try
  {
    $sql->execute();
  }
  catch (PDOException $e)
  {
    echo $e->getMessage();
    exit;
  }
  $sql = $db->prepare("UPDATE usuarios set disponivel=1 where id = '$usuario_id'") or die(mysql_error());
  try
  {
    $sql->execute();
  }
  catch (PDOException $e)
  {
    echo $e->getMessage();
    exit;
  }
  $sql = $db->prepare("INSERT INTO chamado (usuario, status, empresa, contato, telefone, sistema, versao, formacontato, categoria, descproblema, datainicio, usuario_id) 
  VALUES (:usuario, :status, :empresa, :contato, :telefone, :sistema, :versao, :formacontato, :categoria, :descproblema, :datainicio, :usuario_id)") or die(mysql_error());
  $sql ->bindParam(":usuario", $usuario, PDO::PARAM_STR, 500);
  $sql ->bindParam(":status", $status, PDO::PARAM_STR, 500);
  $sql ->bindParam(":empresa", $empresa, PDO::PARAM_STR, 500);
  $sql ->bindParam(":contato", $contato, PDO::PARAM_STR, 500);
  $sql ->bindParam(":telefone", $telefone, PDO::PARAM_STR, 500);
  $sql ->bindParam(":sistema", $sistema, PDO::PARAM_STR, 500);
  $sql ->bindParam(":versao", $versao, PDO::PARAM_STR, 500);
  $sql ->bindParam(":formacontato", $formacontato, PDO::PARAM_STR, 500);
  $sql ->bindParam(":categoria", $categoria, PDO::PARAM_STR, 500);
  $sql ->bindParam(":descproblema", $descproblema, PDO::PARAM_STR, 500);
  $sql ->bindParam(":datainicio", $datainicio, PDO::PARAM_STR, 500);
  $sql ->bindParam(":usuario_id", $usuario_id, PDO::PARAM_STR, 500);
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