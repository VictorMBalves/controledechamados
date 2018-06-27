<?php 
  include '../validacoes/verificaSession.php';
  require_once '../include/Database.class.php';
  $db = Database::conexao();

  $id=$_POST['id_chamado'];
  $datafinal = date("Y-m-d H:i:s");
  $status = "Finalizado";
  $descsolucao=str_replace("'","''",$_POST['descsolucao']);
  $usuario=$_SESSION['UsuarioNome'];
  $sql = $db->prepare("UPDATE chamado SET status= :status, descsolucao= :descs, datafinal= :data WHERE id_chamado=:id") or die(mysql_error());
  $sql ->bindParam(":status", $status, PDO::PARAM_STR, 500);
  $sql ->bindParam(":descs", $descsolucao, PDO::PARAM_STR, 500);
  $sql ->bindParam(":data", $datafinal, PDO::PARAM_STR, 500);
  $sql ->bindParam(":id", $id, PDO::PARAM_STR, 500);
  try
  {
    $sql->execute();
  }catch (PDOException $e)
  {
    echo $e->getMessage();
    exit;
  }

  $sql = $db->prepare("SELECT usuario FROM chamado WHERE id_chamado = '$id'");
  try
  {
    $sql->execute();
  }catch (PDOException $e)
  {
    echo $e->getMessage();
    exit;
  }
  $resultado = $sql->fetch(PDO::FETCH_ASSOC);

  if($resultado['usuario'] == $usuario){
    $sql = $db->prepare("SELECT id_chamado FROM chamado WHERE usuario = '$usuario' and status = 'Aberto' ") or die(mysql_error());
    try
    {
      $sql->execute();
    }catch (PDOException $e)
    {
      echo $e->getMessage();
      exit;
    }
    if ($sql->rowCount()<1) {
        $sql = $db->prepare("UPDATE usuarios set disponivel=0 where nome = '$usuario'") or die(mysql_error());
        try
        {
          $sql->execute();
        }catch (PDOException $e)
        {
          echo $e->getMessage();
          exit;
        }
    }
    echo 'success';
    exit;
  }else{
    $usuario = $resultado['usuario'];
    $sql = $db->prepare("SELECT id_chamado FROM chamado WHERE usuario = '$usuario' and status = 'Aberto' ") or die(mysql_error());
    $sql->execute();
    if ($sql->rowCount()<1) {
        $sql = $db->prepare("UPDATE usuarios set disponivel=0 where nome = '$usuario'") or die(mysql_error());
        try
        {
          $sql->execute();
        }catch (PDOException $e)
        {
          echo $e->getMessage();
          exit;
        }
    }
    echo 'success';
    exit;
  }
?>
