<?php 
    
$allSessions = [];
$sessionNames = scandir(session_save_path());
$arrayUser = [];
foreach($sessionNames as $sessionName) {
    if(strpos($sessionName,".") === false) {
        array_push($arrayUser, json_decode(replace_session($sessionName)));
    }
}
foreach($arrayUser as $userSession){
    $lastLogin = date($userSession->lastLogin);
    $dataAtual = date("Y-m-d H:i:s");
    $intervalo = strtotime('-5 minutes');
    $intervalo = date('Y-m-d H:i:s', $intervalo);
    
    if($lastLogin <= $dataAtual && $lastLogin >= $intervalo){
        echo $userSession->UsuarioNome.' Ativo';
    }else {
        $command = 'rm -rf '.$userSession->sessionPath;
        $output = shell_exec($command);
        echo "<pre>Deletado</pre>";
        
    }
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