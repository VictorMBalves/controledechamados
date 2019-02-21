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
    $allSessions = [];
    $sessionNames = scandir(session_save_path());
    $arrayUser = [];

    foreach($sessionNames as $sessionName) {
        if(strpos($sessionName,".") === false) {
            array_push($arrayUser, json_decode(replace_session($sessionName)));
        }
    }

    foreach($arrayUser as $userSession){
        if($userSession->UsuarioNome == $resultado['nome'] && $userSession->UsuarioID == $resultado['id']){
            $command = 'rm -rf '.$userSession->sessionPath;
            $output = shell_exec($command);       
        }
    }

    if (!isset($_SESSION)) {
        session_start();
    }
    // Salva os dados encontrados na sessão
    $_SESSION['UsuarioID'] = $resultado['id'];
    $_SESSION['UsuarioNome'] = $resultado['nome'];
    $_SESSION['UsuarioNivel'] = $resultado['nivel'];
    $_SESSION['Email'] = $resultado['email'];
    $_SESSION['lastLogin'] = date("Y-m-d H:i:s");
    setcookie("sessionID", session_id(), time() + (86400 * 30), "/");
    // Redireciona o visitante
    if($_SESSION['UsuarioNivel'] == 1){
        echo 'successNivel1';
        exit;
    }else if($_SESSION['UsuarioNivel'] == 3){
        echo 'successNivel3';
        exit;
    }
    echo 'success';
    exit;
}

function replace_session($sessionName){
    $string_session = file_get_contents(session_save_path()."/".$sessionName);
    $string_session = preg_replace('/(\|\w:\d{1,}:)/', '":', $string_session);
    $string_session = str_replace('";', '","', $string_session);
    $string_session = '{"'.$string_session.'sessionPath":"'.session_save_path()."/".$sessionName.'"}';
    $string_session = preg_replace('/(\,"\})/', '}', $string_session);
    return $string_session;
}

?>