<?php

include '../validacoes/verificaSessionFinan.php';
require_once '../include/Database.class.php';
$db = Database::conexao();
$status = "Entrado em contato";
$historico = str_replace("'","''",$_POST['historico']);
$id = $_POST['id'];
$sql = $db->prepare("UPDATE chamadoespera SET historico='$historico', status='$status' WHERE id_chamadoespera='$id'") or die(mysql_error());
if($sql->execute()){
	echo 'success';
	exit;
}else{
	echo 'error';
	exit;
}
?>