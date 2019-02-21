<?php

	include '../validacoes/verificaSessionFinan.php';
	require_once '../include/Database.class.php';
	require_once '../include/Mailer.class.php';
	$db = Database::conexao();

	/**Dados */
	$status = "Entrado em contato";
	$historico = str_replace("'","''",$_POST['historico']);
	$id = $_POST['id'];
	$data = date("Y-m-d H:i:s");
	$usuario=$_SESSION['UsuarioNome'];
	$email = $_SESSION['Email'];
	$usuario_id = $_SESSION['UsuarioID'];

	$sql = $db->prepare("SELECT cha.status as status, cha.empresa as empresa, usu.nome as nome, usu.email as email, usu.enviarEmail as enviaremail FROM chamadoespera cha INNER JOIN usuarios usu ON usu.id = cha.usuario_id WHERE id_chamadoespera='$id'");
	$sql->execute();
	$chamado = $sql->fetch(PDO::FETCH_ASSOC);
	if($chamado['status'] == "Finalizado"){
		echo 'Chamado finalizado';
		exit;
	}

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

	if(isset($_POST['dataagendamento'])){
		$dataAgendamento = date($_POST['dataagendamento']);
		$sql = $db->prepare("UPDATE chamadoespera SET dataagendamento = '$dataAgendamento', status='Entrado em contato' WHERE id_chamadoespera='$id'") or die(mysql_error());
		if($sql->execute()){
			echo 'success';
			exit;
		}else{
			echo 'error';
			exit;
		}
	}


	$sql = $db->prepare("INSERT INTO historicochamado (id_chamadoespera, usuario, descricaohistorico, emailusuario, usuario_id) VALUES ('$id', '$usuario', '$historico','$email','$usuario_id')") or die(mysql_error());
	if($sql->execute()){
		$sql = $db->prepare("UPDATE chamadoespera SET  status='Entrado em contato', data='$data' WHERE id_chamadoespera='$id'") or die(mysql_error());
		if($sql->execute()){
			if($chamado['enviaremail']){
				$mailer = new Mailer();
				$body = 'Foi adicionado um novo registro de contato para o chamado da empresa <strong>'.$chamado['empresa'].'</strong><br/>Data: <strong>'.$data.'</strong><br/>Atendente: <strong>'.$usuario.'</strong><br/>Registro:<strong>'.$historico.'</strong>';
				$mailer->sendEmail($chamado['email'], $chamado['nome'],'Registro de contato', $body);
			}
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