<?php 
try
{
  include '../validacoes/verificaSessionFinan.php';
  require_once '../include/Database.class.php';
  $db = Database::conexao();
  $chamado_id = $_POST['chamado_id'];
  $datafinal = $_POST['datafinal'];

  $query = "UPDATE chamado set datafinal = '$datafinal' where id_chamado = $chamado_id";
  // echo $query; 
  $sql = $db->prepare($query);
  $sql->execute();
  echo "success";
}catch (PDOException $e){
  echo $e;
  exit;
}
?>
