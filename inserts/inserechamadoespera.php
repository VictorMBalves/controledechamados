<?php 
try
{
  include '../validacoes/verificaSessionFinan.php';
  require_once '../include/Database.class.php';
  $db = Database::conexao();
  $data = date("Y-m-d H:i:s");
  $status = "Aguardando Retorno";
  $empresa=$_POST['empresa'];
  $contato=$_POST['contato'];
  $telefone=$_POST['telefone'];
  $descproblema = str_replace("'","''",$_POST['descproblema']);
  $enderecado = $_POST['enderecado'];
  $sistema = $_POST['sistema'];
  $versao = $_POST['versao'];
  $usuario=$_SESSION['UsuarioNome'];
  $usuario_id = $_SESSION['UsuarioID'];
  $sql = $db->prepare("INSERT INTO chamadoespera (usuario, status, empresa, contato, telefone, descproblema, data, enderecado, sistema, versao, usuario_id) 
  VALUES ('$usuario', '$status', '$empresa', '$contato', '$telefone', '$descproblema', '$data', '$enderecado','$sistema', '$versao', '$usuario_id')") or die(mysql_error());

  $sql->execute();
  if ($_SESSION['UsuarioNivel'] != 1) {
    echo 'success';
    exit;
  } else {
    echo 'success1';
    exit;
  }
}catch (PDOException $e){
  echo $e;
  exit;
}
?>
