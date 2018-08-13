<?php 
  require_once '../include/Database.class.php';
  include '../validacoes/verificaSession.php';
  $db = Database::conexao();
  if(isset($_POST['id_chamadoespera'])){
    $idchamadoespera =$_POST['id_chamadoespera'];
    $statusespera = "Finalizado";

    $sql = $db->prepare("UPDATE chamadoespera SET status= :s WHERE id_chamadoespera= :id ") or die(mysql_error());
    $sql->bindParam(":s", $statusespera, PDO::PARAM_STR, 500);
    $sql->bindParam(":id", $idchamadoespera, PDO::PARAM_INT);
    try
    {
      $sql->execute();
    } 
    catch (PDOException $e)
    {
      echo $e->getMessage();
      exit;
    }
  }
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
  if(isset($backup)){
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
  }
  $sql = $db->prepare("UPDATE usuarios set disponivel=1 where nome = '$usuario'") or die(mysql_error());
  try
  {
    $sql->execute();

  } 
  catch (PDOException $e)
  {
    echo $e->getMessage();
    exit;
  }
  $sql = $db->prepare("INSERT INTO chamado (id_chamadoespera, usuario, status, empresa, contato, telefone, sistema, versao, formacontato, categoria, descproblema, datainicio) 
  VALUES (:idesp, :us, :sta, :empre, :cont, :tel, :sis, :versao, :for, :cat, :des, :data)") or die(mysql_error());
  $sql->bindParam(":idesp", $idchamadoespera, PDO::PARAM_INT);
  $sql->bindParam(":us", $usuario, PDO::PARAM_STR, 500);
  $sql->bindParam(":sta", $status, PDO::PARAM_STR, 500);
  $sql->bindParam(":empre", $empresa, PDO::PARAM_STR, 500);
  $sql->bindParam(":cont", $contato, PDO::PARAM_STR, 500);
  $sql->bindParam(":tel", $telefone, PDO::PARAM_STR, 500);
  $sql->bindParam(":sis", $sistema, PDO::PARAM_STR, 500);
  $sql->bindParam(":versao", $versao, PDO::PARAM_STR, 500);
  $sql->bindParam(":for", $formacontato, PDO::PARAM_STR, 500);
  $sql->bindParam(":cat", $categoria, PDO::PARAM_STR, 500);
  $sql->bindParam(":des", $descproblema, PDO::PARAM_STR, 500);
  $sql->bindParam(":data", $datainicio, PDO::PARAM_STR, 500);
  try
  {
    $sql->execute();

    $sql = $db->prepare("SELECT id_chamado FROM chamado ORDER BY id_chamado DESC LIMIT 1");
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);

    $resultado->status = 'success';
    $resultado->idChamado = $row['id_chamado'];

    echo json_encode($resultado);
    exit;
  } 
  catch (PDOException $e)
  {
    echo $e->getMessage();
    exit;
  }
?>
