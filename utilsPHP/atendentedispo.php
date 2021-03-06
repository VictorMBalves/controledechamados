<?php
require_once '../include/Database.class.php';
$db = Database::conexao();
$sql = $db->prepare("SELECT id, nome, email FROM usuarios WHERE nivel = 2");
$sql->execute();
$result = $sql->fetchall(PDO::FETCH_ASSOC);
//HEADER
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
        $id = $row['id'];
        $sql = $db->prepare("SELECT count(cha.id_chamado) as numeroChamados FROM chamado cha INNER JOIN usuarios u ON u.id = cha.usuario_id AND u.id = $id WHERE cha.status = 'Aberto'");
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
                         $result .= $numChamado. " atendimento";  
                    }else{
                        $result .= $numChamado. " atendimentos";
                    } 
                        $result .= '</em></small></span>';
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
