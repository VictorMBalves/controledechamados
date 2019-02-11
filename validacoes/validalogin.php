<?php
if (!empty($_POST) and (empty($_POST['usuario']) or empty($_POST['senha']))) {
    echo 'fail';
    exit;
}
require_once '../include/Database.class.php';
$db = Database::conexao();

$usuario = ($_POST['usuario']);
$senha = sha1(($_POST['senha']));

$sql = $db->prepare('SELECT id, nome, nivel, email FROM usuarios WHERE (usuario = :usuario ) AND (senha = :senha)  AND (ativo = 1) LIMIT 1');
$sql->bindParam(':usuario', $usuario, PDO::PARAM_STR, 25);
$sql->bindParam(':senha', $senha, PDO::PARAM_STR, 40);
$sql->execute();
$resultado = $sql->fetch();
if (empty($resultado)) {
    echo "fail";
    exit;
} else {
    if (!isset($_SESSION)) {
        session_start();
    }
    // Salva os dados encontrados na sessão
    $_SESSION['UsuarioID'] = $resultado['id'];
    $_SESSION['UsuarioNome'] = $resultado['nome'];
    $_SESSION['UsuarioNivel'] = $resultado['nivel'];
    $_SESSION['Email'] = $resultado['email'];
    $_SESSION['lastLogin'] = date("Y-m-d H:i:s");
    // Redireciona o visitante
    if($_SESSION['UsuarioNivel'] == 1){
        echo 'successNivel1';
        exit;
    }
    if(isset($_SESSION['page_request'])){
        echo $_SESSION['page_request'];
        unset($_SESSION['page_request']);
        exit;
    }
    echo 'success';
    exit;
}
?>