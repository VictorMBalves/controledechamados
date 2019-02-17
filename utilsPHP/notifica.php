
<?php
        if(!isset($db)){
            require_once '../include/Database.class.php';
             $db = Database::conexao();
        }
        $enderecado =$_SESSION['UsuarioNome'];
        $status="Aguardando Retorno";
        $sqlNotificacoes = $db->prepare("SELECT id_chamadoespera, empresa, DATE_FORMAT(data,'%d/%m/%Y %H:%i') as data FROM chamadoespera WHERE enderecado like '$enderecado' and status='$status'");
        $sqlNotificacoes->execute();
        $notificacoes = $sqlNotificacoes->fetchall(PDO::FETCH_ASSOC);

        echo '<li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter">';if(sizeof($notificacoes) != 0){echo sizeof($notificacoes);}
                echo'</span>
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Notificações
                </h6>';
        
        foreach ($notificacoes as $notificacao) {
                echo ' <a class="dropdown-item d-flex align-items-center" href="../pages/abrechamadoespera='.$notificacao['id_chamadoespera'].'">';
                    echo '<div class="mr-3">';
                        echo '<div class="icon-circle bg-primary">';    
                            echo '<i class="fas fa-phone text-white"></i>';
                        echo'</div>';
                    echo '</div>';
                     echo '<div>';
                    echo '<div class="small text-gray-500">'.$notificacao['data'].'</div>';
                    echo '<span class="font-weight-bold">Chamado endereçado '.$notificacao['empresa'].'</span>';
                    echo '</div>';
                echo '</a>';
        }
        echo '<a class="dropdown-item text-center small text-gray-500" href="../pages/meuschamados">Ver todas</a>
        </div>
        </li>';
    ?>       