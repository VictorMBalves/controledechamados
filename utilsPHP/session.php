<pre>
<?php 
    
$allSessions = [];
$sessionNames = scandir(session_save_path());
$arrayUser = [];
foreach($sessionNames as $sessionName) {
    if(strpos($sessionName,".") === false) {
        array_push($arrayUser, json_decode(replace_session($sessionName)));
    }
}
if(empty($arrayUser)){
    echo "<h2>Nenhum usuário conectado :/</h2>";
    return;
}

echo "<h2>Usuários conectados:</h2><br/>";
foreach($arrayUser as $userSession){
    var_dump($userSession);
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
</pre>
