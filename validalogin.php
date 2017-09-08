<!DOCTYPE>
<html>
<head>
<script>
function loginfail() {
	alert('Usuario não cadastrado');
	setTimeout(window.location='index.php',5000);
}
 
</script>
</head>
<body>
</body>
</html>
<?php

if (!empty($_POST) AND (empty($_POST['usuario']) OR empty($_POST['senha']))) {
  header("Location: index.php"); exit;
}
include 'include/dbconf.php';
$usuario = ($_POST['usuario']);
$senha = ($_POST['senha']);

$sql = $conn->prepare('SELECT id, nome, nivel, email FROM usuarios WHERE (usuario = :usuario ) AND (senha = :senha)  AND (ativo = 1) LIMIT 1');
$sql->bindParam(':usuario',$usuario, PDO::PARAM_STR,25); 
$sql->bindParam(':senha',sha1($senha), PDO::PARAM_STR,40);                 
$sql->execute();
$resultado = $sql->fetch();
if (empty($resultado)){
   echo "<script>loginfail()</script>"; 
    } 
else {
  if (!isset($_SESSION)) session_start();
  // Salva os dados encontrados na sessão
  $_SESSION['UsuarioID'] = $resultado['id'];
  $_SESSION['UsuarioNome'] = $resultado['nome'];
  $_SESSION['UsuarioNivel'] = $resultado['nivel'];
  $_SESSION['Email'] = $resultado['email'];
  // Redireciona o visitante
  if($resultado['nivel'] == 2 || 3) {
    header("Location: home.php"); exit;
  } else {
    header("Location: chamadoespera.php"); exit;
  }
}
?>