<?php
require_once '../include/Database.class.php';
$db = Database::conexao();

$sql = $db->prepare("SELECT nome, email, disponivel FROM usuarios WHERE nivel = 2");
$sql->execute();
$result = $sql->fetchall(PDO::FETCH_ASSOC);
echo '<table class="table table-responsive">';
echo '<thead class="thead-light">';
echo '<th class="tableHead" colspan="2">';
    echo 'Lista de Atendentes';
echo '</th>';
echo '</thead>';
$allSessions = [];
$sessionNames = scandir(session_save_path());
$arrayUser = [];

foreach($sessionNames as $sessionName) {
    if(strpos($sessionName,".") === false) {
        array_push($arrayUser, json_decode(replace_session($sessionName)));
    }
}
echo '<tbody>';
foreach ($result as $row) {
    if ($row > 1) {
        $usuario = $row['nome'];
        $sql = $db->prepare("SELECT count(id_chamado) as numeroChamados FROM chamado WHERE usuario = '$usuario' AND status = 'Aberto'");
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        echo'<tr style="padding: 3px !important;">';
        echo '<td class="text-center" width="60" style="padding: 3px !important;">
                <div class="avatar vcenter">
                    <img class="img-avatar" src="https://www.gravatar.com/avatar/' . md5($row['email']) . ' alt="'.$row['email'].'">';
                    echo usuarioOnline($usuario, $arrayUser, $result['numeroChamados']);
    }
    echo'</tr>';
}
echo '</tbody>';
echo '</table>';


function usuarioOnline($needle='', $haystack=array(), $numChamado){
    foreach ($haystack as $item) {
        if ($item->UsuarioNome===$needle) {
            $lastLogin = date($item->lastLogin);
            $dataAtual = date("Y-m-d H:i:s");
            $intervalo = strtotime('-15 minutes');
            $intervalo = date('Y-m-d H:i:s', $intervalo);
            $intervalo45 = strtotime('-45 minutes');
            $intervalo45 = date('Y-m-d H:i:s', $intervalo45);
            
            if($lastLogin <= $dataAtual && $lastLogin >= $intervalo){
                $result = '<span class="avatar-status badge-success" ></span></div></td>';
                $result .= '<td style="padding: 3px !important;">';
                $result .=  ''.$needle.'</br>';
                if($numChamado != 0){
                    $result .= '<small><em style="color:#d9534f;">';
                    if($numChamado == "1"){
                         $result .= $numChamado. " chamado";  
                    }else{
                        $result .= $numChamado. " chamados";
                    } 
                        $result .= ' em atendimento </em></small>';
                }
                return $result."</td>";
            }else if($lastLogin <= $dataAtual && $lastLogin >= $intervalo45){
                $result = '<span class="avatar-status badge-warning" data-toggle="tooltip" data-placement="left" title="Ausente"></span></div></td>';
                $result .= '<td style="padding: 3px !important;">';
                $result .= ''.$needle.'</br>';
                $result .= '<small><em style="color:#ffc107;"><span class="glyphicon glyphicon-time"></span>&nbsp'.formatDateDiff(date_create($lastLogin), date_create(date("Y-m-d H:i:s"))).'</em></small>';
                return $result."</td>";
            }
            
        }
    }
    $result = '<span class="avatar-status badge-danger" data-toggle="tooltip" data-placement="left" title="Offline"></span></div></td>';
    $result .= '<td style="padding: 3px !important;">';
    $result .=  ''.$needle.'</br>';
    return $result."</td>";
}

function replace_session($sessionName){
    $string_session = file_get_contents(session_save_path()."/".$sessionName);
    $string_session = preg_replace('/(\|\w:\d{1,}:)/', '":', $string_session);
    $string_session = str_replace('";', '","', $string_session);
    $string_session = '{"'.$string_session.'}';
    $string_session = preg_replace('/(\,"\})/', '}', $string_session);
    return $string_session;
}


function formatDateDiff($start, $end=null) { 
    if(!($start instanceof DateTime)) { 
        $start = new DateTime($start); 
    } 
    
    if($end === null) { 
        $end = new DateTime(); 
    } 
    
    if(!($end instanceof DateTime)) { 
        $end = new DateTime($start); 
    } 
    
    $interval = $end->diff($start); 
    $doPlural = function($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals 
    
    $format = array(); 
    if($interval->y !== 0) { 
        $format[] = "%y ".$doPlural($interval->y, "Ano"); 
    } 
    if($interval->m !== 0) { 
        $format[] = "%m ".$doPlural($interval->m, "mêses"); 
    } 
    if($interval->d !== 0) { 
        $format[] = "%d ".$doPlural($interval->d, "dia"); 
    } 
    if($interval->h !== 0) { 
        $format[] = "%h ".$doPlural($interval->h, "hora"); 
    } 
    if($interval->i !== 0) { 
        $format[] = "%i ".$doPlural($interval->i, "minuto"); 
    } 
    if($interval->s !== 0) { 
        if(!count($format)) { 
            return "há menos de um ninuto"; 
        } else { 
            $format[] = "%s ".$doPlural($interval->s, "segundo"); 
        } 
    } 
    
    // We use the two biggest parts 
    if(count($format) > 1) { 
        $format = array_shift($format)." e ".array_shift($format); 
    } else { 
        $format = array_pop($format); 
    } 
    
    // Prepend 'since ' or whatever you like 
    return $interval->format($format); 
} 