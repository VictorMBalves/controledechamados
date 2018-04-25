<!DOCTYPE>
<html>
<head>
<script>
function loginfail() {
	alert('Usuario não cadastrado');
	setTimeout(window.location='../index.html',5000);
}
 
</script>
</head>
<body>
</body>
</html>
<?php

if (!empty($_POST) and (empty($_POST['usuario']) or empty($_POST['senha']))) {
    header("Location:../index.html");
    exit;
}
include '../include/dbconf.php';
$usuario = ($_POST['usuario']);
$senha = sha1(($_POST['senha']));

$sql = $conn->prepare('SELECT id, nome, nivel, email FROM usuarios WHERE (usuario = :usuario ) AND (senha = :senha)  AND (ativo = 1) LIMIT 1');
$sql->bindParam(':usuario', $usuario, PDO::PARAM_STR, 25);
$sql->bindParam(':senha', $senha, PDO::PARAM_STR, 40);
$sql->execute();
$resultado = $sql->fetch();
if (empty($resultado)) {
    echo "<script>loginfail()</script>";
} else {
    if (!isset($_SESSION)) {
        session_start();
    }
    // Salva os dados encontrados na sessão
    $_SESSION['UsuarioID'] = $resultado['id'];
    $_SESSION['UsuarioNome'] = $resultado['nome'];
    $_SESSION['UsuarioNivel'] = $resultado['nivel'];
    $_SESSION['Email'] = $resultado['email'];
    // Redireciona o visitante
    header("Location:../pages/home.php");
    exit;
}
?>