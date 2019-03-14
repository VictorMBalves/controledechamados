<?php
require_once '../include/Database.class.php';
$db = Database::conexao();
$sql = $db->prepare("SELECT nome, email, disponivel FROM usuarios WHERE nivel = 2");
$sql->execute();
$result = $sql->fetchall(PDO::FETCH_ASSOC);
//HEADER
// echo'<div class="bg-gradient-info">';
    // echo '<li class="nav-item ">';
    //     echo '<a class="nav-link" href="#">';
    //         echo '<i class="fas fa-fw fa-users"></i>';
    //             echo '<span>Help-desk</span>';
    //     echo '</a>';
    //     echo '<hr class="sidebar-divider d-none d-md-block">';
    // echo '</li>';
    echo '<div class="sidebar-heading">Help-desk</div>';
//HEADER

$allSessions = [];
$sessionNames = scandir(session_save_path());
$arrayUser = [];

foreach($sessionNames as $sessionName) {
    if(strpos($sessionName,".") === false) {
        array_push($arrayUser, json_decode(replace_session($sessionName)));
    }
}

foreach ($result as $row) {
    if ($row > 1) {
        
        $usuario = $row['nome'];
        $sql = $db->prepare("SELECT count(id_chamado) as numeroChamados FROM chamado WHERE usuario = '$usuario' AND status = 'Aberto'");
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        echo'<li class="nav-item">';
            echo '<a class="nav-link " href="#">';
                echo '<div class="container" style="padding:0;">';
                echo '<div class="row">';
                    echo '<div class="col-12 col-sm-3 col-md-3 col-lg-3 userImage text-center" style="padding-right:none;">';
                        echo '<div class="avatar vcenter" style="margin-top:5px;">';
                            echo '<img class="img-avatar" src="https://www.gravatar.com/avatar/' . md5($row['email']) . ' alt="'.$row['email'].'">';
                                echo usuarioStatus($usuario, $arrayUser, $result['numeroChamados']);
                        echo '</div>
                        </div>
                    </div>
                </a>
            </li>';
    }
}

// echo '</div>';

function usuarioStatus($needle='', $haystack=array(), $numChamado){
    foreach ($haystack as $item) {
        if ($item->UsuarioNome===$needle) {
            $lastLogin = date($item->lastLogin);
            $dataAtual = date("Y-m-d H:i:s");
            $intervalo = strtotime('-15 minutes');
            $intervalo = date('Y-m-d H:i:s', $intervalo);
            $intervalo45 = strtotime('-45 minutes');
            $intervalo45 = date('Y-m-d H:i:s', $intervalo45);
            
            if($lastLogin <= $dataAtual && $lastLogin >= $intervalo){
                $result = '<span class="avatar-status badge-success" ></span></div></div>';
                $result .= '<div class="col-12 col-sm-9 col-md-9 col-lg-9 userName d-none d-sm-block"><div><span>';
                $result .=  ''.$needle.'</span></div>';
                if($numChamado != 0){
                    $result .= '<span class="text-danger" ><small><em>';
                    if($numChamado == "1"){
                         $result .= $numChamado. " chamado";  
                    }else{
                        $result .= $numChamado. " chamados";
                    } 
                        $result .= ' em atendimento </em></small></span>';
                }else{
                    $result .= '<span class="text-success" ><small><em>Online</em><span>';
                }
                return $result;
            }else if($lastLogin <= $dataAtual && $lastLogin >= $intervalo45){
                $result = '<span class="avatar-status badge-warning"></span></div></div>';
                $result .= '<div class="col-12 col-sm-9 col-md-9 col-lg-9 userName d-none d-sm-block"><div><span>';
                $result .=  ''.$needle.'</span></div>';
                $result .= '<span class="text-warning"><small><em><i class="far fa-clock"></i>&nbsp'.formatDateDiff(date_create($lastLogin), date_create(date("Y-m-d H:i:s"))).'</em></small></span>';
                return $result;
            }
            
        }
    }
    $result = '<span class="avatar-status badge-danger" data-toggle="tooltip" data-placement="left" title="Offline"></span></div></div>';
    $result .= '<div class="col-12 col-sm-9 col-md-9 col-lg-9 userName d-none d-sm-block"><div><span>';
    $result .=  ''.$needle.'</span></div>';
    $result .= '<span class="text-danger" ><small><em>Offline</em><span>';
    return $result;
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
        $format[] = "%h ".$doPlural($interval->h, "h"); 
    } 
    if($interval->i !== 0) { 
        $format[] = "%i ".$doPlural($interval->i, "min"); 
    } 
    if($interval->s !== 0) { 
        if(!count($format)) { 
            return "há menos de um ninuto"; 
        } else { 
            $format[] = "%s ".$doPlural($interval->s, "s"); 
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