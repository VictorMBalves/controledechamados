<?php 
  require_once '../include/Database.class.php';
  include '../validacoes/verificaSession.php';
  require_once '../include/Mailer.class.php';
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
  $usuario_id = $_SESSION['UsuarioID'];
  $cnpj = $_POST['cnpj'];
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
  $sql = $db->prepare("INSERT INTO chamado (id_chamadoespera, usuario, status, empresa, contato, telefone, sistema, versao, formacontato, categoria, descproblema, datainicio, usuario_id, cnpj) 
  VALUES (:idesp, :us, :sta, :empre, :cont, :tel, :sis, :versao, :for, :cat, :des, :data, :usuario_id, :cnpj)") or die(mysql_error());
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
  $sql->bindParam(":usuario_id", $usuario_id, PDO::PARAM_STR, 500);
  $sql->bindParam(":cnpj", $cnpj, PDO::PARAM_STR, 500);
  try
  {
    if($sql->execute()){
      $resultado->status = 'success';
      $resultado->idChamado = $db->lastInsertId();

      $sql = $db->prepare("SELECT cha.status as status, cha.empresa as empresa, usu.nome as nome, usu.email as email, usu.enviarEmail as enviaremail FROM chamadoespera cha INNER JOIN usuarios usu ON usu.id = cha.usuario_id WHERE id_chamadoespera='$idchamadoespera'");
	    $sql->execute();
	    $chaespera = $sql->fetch(PDO::FETCH_ASSOC);
      if($chaespera['enviaremail']){
				$mailer = new Mailer();
				$body = 'O seu chamado para empresa <strong>'.$chaespera['empresa'].'</strong> Foi iniciado.<br/>Data inicial: <strong>'.$datainicio.'</strong><br/>Atendente: <strong>'.$usuario.'</strong><br/>Descrição do problema:<strong>'.$descproblema.'</strong>';
        $mailer->sendEmail($chaespera['email'], $chaespera['nome'],'Início de atendimento', $body);
			}

      echo json_encode($resultado);
      exit;
    }
    throw new Exception('Insert não executado');
  } 
  catch (PDOException $e)
  {
    echo $e->getMessage();
    exit;
  }
?>
