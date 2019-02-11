<?php

require_once '../include/Database.class.php';
$db = Database::conexao();

$sql = $db->prepare("SELECT nome, email, disponivel FROM usuarios WHERE nivel = 2");
$sql->execute();
$result = $sql->fetchall(PDO::FETCH_ASSOC);
echo '<ul class="list-group">';
echo '<li style="background-color:#222; color:white;" class="list-group-item">';
    echo 'Lista de Atendentes';
echo '</li>';

$allSessions = [];
$sessionNames = scandir(session_save_path());
$arrayUser = [];

foreach($sessionNames as $sessionName) {
    if(strpos($sessionName,".") === false) {
        array_push($arrayUser, json_decode(replace_session($sessionName)));
    }
}

function replace_session($sessionName){
    $string_session = file_get_contents(session_save_path()."/".$sessionName);
    $string_session = preg_replace('/(\|\w:\d{1,}:)/', '":', $string_session);
    $string_session = str_replace('";', '","', $string_session);
    $string_session = '{"'.$string_session.'}';
    $string_session = preg_replace('/(\,"\})/', '}', $string_session);
    return $string_session;
}

foreach ($result as $row) {
    if ($row > 1) {
        $usuario = $row['nome'];
        $sql = $db->prepare("SELECT count(id_chamado) as numeroChamados FROM chamado WHERE usuario = '$usuario' AND status = 'Aberto'");
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        echo '<li class="list-group-item" style="padding:5px;"><img src="https://www.gravatar.com/avatar/' . md5($row['email']) . '" width="25px"> ';
        echo $usuario;
        if(usuarioOnline($usuario, $arrayUser) || $row['disponivel']){
            echo '<span style="background-color:#5cb85c;" class="badge">Online</span>';
            if($row['disponivel']){
                echo '<em style="color:#d9534f;"> - ';if($result['numeroChamados'] == 1){echo $result['numeroChamados']. " chamado";  }else{echo $result['numeroChamados']. " chamados";} echo ' em atendimento </em>';
            }
        }else{
            echo '<span style="background-color:#d9534f;" class="badge">offline</span>';
        }

        echo '</li>';
    }
}
echo '</ul>';


function usuarioOnline($needle='', $haystack=array()){
    foreach ($haystack as $item) {
        if ($item->UsuarioNome===$needle) {
            $lastLogin = date($item->lastLogin);
            $dataAtual = date("Y-m-d H:i:s");
            $intervalo = strtotime('-30 minutes');
            $intervalo = date('Y-m-d H:i:s', $intervalo);
            
            if($lastLogin <= $dataAtual && $lastLogin >= $intervalo){
                return true;
            }else {
                return false;
            }
            
        }
    }
    return false;
}

