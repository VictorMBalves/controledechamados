<?php

include '../validacoes/verificaSessionFinan.php';
include '../include/dbconf.php';
$status = "Entrado em contato";
$historico = str_replace("'","''",$_POST['historico']);
$id = $_POST['id'];
$sql = $conn->prepare("UPDATE chamadoespera SET historico='$historico', status='$status' WHERE id_chamadoespera='$id'") or die(mysql_error());
if($sql->execute()){
	echo 'success';
	exit;
}else{
	echo 'error';
	exit;
}
?>