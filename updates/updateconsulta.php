<?php

include '../validacoes/verificaSessionFinan.php';
require_once '../include/Database.class.php';
$db = Database::conexao();
$status = "Entrado em contato";
$historico = str_replace("'","''",$_POST['historico']);
$id = $_POST['id'];
$usuario=$_SESSION['UsuarioNome'];
$email = $_SESSION['Email'];
$sql = $db->prepare("INSERT INTO historicochamado (id_chamadoespera, usuario, descricaohistorico, emailusuario) VALUES ('$id', '$usuario', '$historico','$email')") or die(mysql_error());
if($sql->execute()){
	$sql = $db->prepare("UPDATE chamadoespera SET  status='$status' WHERE id_chamadoespera='$id'") or die(mysql_error());
	if($sql->execute()){
		echo 'success';
		exit;
	}else{
		echo 'error';
		exit;
	}
}else{
	echo 'error';
	exit;
}
?>