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
  $sql = $db->prepare("INSERT INTO chamadoespera (usuario, status, empresa, contato, telefone, descproblema, data, enderecado, sistema, versao) 
  VALUES ('$usuario', '$status', '$empresa', '$contato', '$telefone', '$descproblema', '$data', '$enderecado','$sistema', '$versao')") or die(mysql_error());

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
