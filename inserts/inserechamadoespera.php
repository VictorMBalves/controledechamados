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
  $cnpj = $_POST['cnpj'];
  $dataagendamento = $_POST['dataagendamento'];

  $query = "INSERT INTO chamadoespera (usuario, status, empresa, contato, telefone, descproblema, data, enderecado, sistema, versao, usuario_id, cnpj";
  $query .= ($dataagendamento != '' ? ", dataagendamento)" : ")");
  $query .= " VALUES ('$usuario', '$status', '$empresa', '$contato', '$telefone', '$descproblema', '$data', '$enderecado','$sistema', '$versao', '$usuario_id', '$cnpj'";
  $query .= ($dataagendamento != '' ? ", '$dataagendamento');" : ");");

  $sql = $db->prepare($query);
  $sql->execute();
  echo "success";
}catch (PDOException $e){
  echo $e;
  exit;
}
?>
