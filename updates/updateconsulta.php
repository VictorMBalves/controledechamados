<?php

include '../validacoes/verificaSessionFinan.php';
require_once '../include/Database.class.php';
$db = Database::conexao();
$status = "Entrado em contato";
$historico = str_replace("'","''",$_POST['historico']);
$id = $_POST['id'];
$data = date("Y-m-d H:i:s");
$usuario=$_SESSION['UsuarioNome'];
$email = $_SESSION['Email'];


if(isset($_POST['notification'])){
	$notification = $_POST['notification'];
	if($notification == 'true'){
		$notification = 1;
	}else{
		$notification = 0;
	}
	$sql = $db->prepare("UPDATE chamadoespera SET notification = '$notification' WHERE id_chamadoespera='$id'") or die(mysql_error());
	if($sql->execute()){
		echo 'success';
		exit;
	}else{
		echo 'error';
		exit;
	}
}


$sql = $db->prepare("INSERT INTO historicochamado (id_chamadoespera, usuario, descricaohistorico, emailusuario) VALUES ('$id', '$usuario', '$historico','$email')") or die(mysql_error());
if($sql->execute()){
	$sql = $db->prepare("UPDATE chamadoespera SET  status='$status', data='$data' WHERE id_chamadoespera='$id'") or die(mysql_error());
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