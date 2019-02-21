<?php 
  include '../validacoes/verificaSession.php';
  require_once '../include/Database.class.php';
  require_once '../include/Mailer.class.php';
  $db = Database::conexao();

  $id=$_POST['id_chamado'];
  $datafinal = date("Y-m-d H:i:s");
  $status = "Finalizado";
  $descsolucao = str_replace("'","''",$_POST['descsolucao']);
  $usuario = $_SESSION['UsuarioNome'];
  $contato = $_POST['contato'];
  $telefone = $_POST['telefone'];
  $sistema = $_POST['sistema'];
  $versao = $_POST['versao'];
  $formacontato = $_POST['formacontato'];
  $categoria = $_POST['categoria'];
  $descproblema = str_replace("'","''",$_POST['descproblema']);
  $backup = $_POST['backup'];

  if(!isset($descproblema) || $descproblema == ""){
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
  }else{
    $sql = $db->prepare("UPDATE chamado SET status='$status', descsolucao='$descsolucao', contato='$contato', telefone='$telefone', sistema='$sistema', formacontato='$formacontato', descproblema='$descproblema', categoria='$categoria', versao='$versao', datafinal= '$datafinal'  WHERE id_chamado='$id'")or die(mysql_error());
    try
    {
      $sql->execute();
    }catch (PDOException $e)
    {
      echo $e->getMessage();
      exit;
    }
  }
  //ENVIA O EMAIL
  $sql = $db->prepare("SELECT cha.empresa as empresa, usu.nome as nome, usu.email as email, usu.enviarEmail as enviaremail, c.datainicio as datainicio FROM chamado c INNER JOIN chamadoespera cha ON cha.id_chamadoespera = c.id_chamadoespera INNER JOIN usuarios usu ON usu.id = cha.usuario_id WHERE c.id_chamado='$id'");
  $sql->execute();
  $chaespera = $sql->fetch(PDO::FETCH_ASSOC);
  if($chaespera['enviaremail']){
    $mailer = new Mailer();
    $body = 'O seu chamado para empresa <strong>'.$chaespera['empresa'].'</strong> Foi finalizado.<br/>Data início: <strong>'.$chaespera['datainicio'].'</strong><br/>Data finalização: <strong>'.$datafinal.'</strong><br/>Atendente: <strong>'.$usuario.'</strong><br/>Descrição do problema:<strong>'.$descproblema.'</strong><br/>Solução:<strong>'.$descsolucao.'</strong>';
    $mailer->sendEmail($chaespera['email'], $chaespera['nome'],'Fim de atendimento', $body);
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
