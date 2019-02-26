<?php
require_once '../include/Database.class.php';
include '../validacoes/verificaSession.php';
$db = Database::conexao();

$id_chamado = $_POST['id'];
$dataAgendamento = $_POST['dataagendamento'];
$desc = $_POST['problema'];

$sql = $db->prepare("SELECT * FROM chamado WHERE id_chamado = '$id_chamado'");
$sql->execute();
$chamado = $sql->fetch(PDO::FETCH_ASSOC);

//Chamado espera
$empresa = $chamado['empresa'];
$data = date("Y-m-d H:i:s");
$status = "Entrado em contato";
$contato = $chamado['contato'];
$telefone = $chamado['telefone'];
$descproblema = str_replace("'", "''", $desc);
$sistema = $chamado['sistema'];
$versao = $chamado['versao'];
$cnpj = $chamado['cnpj'];
$usuario = $_SESSION['UsuarioNome'];
$usuario_id = $_SESSION['UsuarioID'];
$dataAgendamento = date($dataAgendamento);

$sql = $db->prepare("INSERT INTO chamadoespera (usuario, status, empresa, contato, telefone, descproblema, data, sistema, versao, usuario_id, cnpj, dataagendamento) 
  VALUES ('$usuario', '$status', '$empresa', '$contato', '$telefone', '$descproblema', '$data', '$sistema', '$versao', '$usuario_id', '$cnpj', '$dataAgendamento')") or die(mysql_error());
try {
  $sql->execute();
  $sql = $db->prepare("UPDATE chamado SET status = 'Finalizado' WHERE id_chamado = '$id_chamado'");
  $sql->execute();
  echo "success";
  exit;
} catch (PDOException $e) {
  echo $e;
  exit;
}
//Chamado espera
 ?>