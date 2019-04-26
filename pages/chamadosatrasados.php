<?php
    require_once '../include/Database.class.php';
    require_once '../include/Mailer.class.php';
    $db = Database::conexao();
    $sql = "SELECT 
                id_chamadoespera, 
                usuario, 
                status, 
                empresa, 
                contato, 
                telefone, 
                data as databanco,
                DATE_FORMAT(data,'%d/%m/%Y %H:%i') as dataFormatada,
                enderecado, 
                historico, 
                notification, 
                descproblema,
                dataagendamento,
                DATE_FORMAT(dataagendamento,'%d/%m/%Y %H:%i') as dataagendamentoformat,
                emailEnviado
            FROM chamadoespera 
            WHERE status <> 'Finalizado' 
            AND data < DATE_ADD(NOW(), INTERVAL -10 MINUTE) 
            AND (dataagendamento IS NULL OR dataagendamento < DATE_ADD(NOW(), INTERVAL -10 MINUTE))
            AND notification IS TRUE
            ORDER BY coalesce(dataagendamento, data), status";
    $query = $db->prepare($sql);
    $query->execute();
    $resultados = $query->fetchall(PDO::FETCH_ASSOC);

    $userstmt = $db->prepare("SELECT * FROM usuarios WHERE nivel = 3 AND enviarEmail IS TRUE");
    $userstmt->execute();
    $usuarioSuporteAvancado = $userstmt->fetchall(PDO::FETCH_ASSOC);

    foreach ($resultados as $chamado) {
        if($chamado['status'] == 'Entrado em contato'){
            $id = $chamado['id_chamadoespera'];
            $update = "UPDATE chamadoespera SET dataagendamento = DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE id_chamadoespera = '$id'";
            $stmt = $db->prepare($update);
            $stmt->execute();
        }else if(!$chamado['emailEnviado'] && (date_add(date_create($chamado['databanco']), date_interval_create_from_date_string('30 minutes')) <= date_create(date("Y-m-d H:i:s")))){
            if(!horarioValidoEnvio()){
                continue;
            }
            $mailer = new Mailer();
            foreach ($usuarioSuporteAvancado as $usuario) {
                $body = 'O chamado em espera da empresa <strong>'.$chamado['empresa'].'</strong> está a mais de '.formatDateDiff(date_create($chamado['databanco']), date_create(date("Y-m-d H:i:s"))).' atrasado.<br/>Data: <strong>'.$chamado['dataFormatada'].'</strong><br/>';
                $mailer->sendEmail($usuario['email'], $usuario['nome'],'Chamado atrasado', $body);
            }
            $id = $chamado['id_chamadoespera'];
            $update = "UPDATE chamadoespera SET emailEnviado = TRUE WHERE id_chamadoespera = '$id'";
            $stmt = $db->prepare($update);
            $stmt->execute();
        }
    }
    
    $query = $db->prepare($sql);
    $query->execute();
    $resultados = $query->fetchall(PDO::FETCH_ASSOC);

    echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">
            <div class="card border-left-danger shadow h-100 py-2" style="background-color:#f9d5d2;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"><h6>ATRASADOS</h6></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">'.sizeof($resultados).' chamados</div>
                        </div>
                        <div class="col-auto">
                            <i class="far fa-clock fa-2x text-gray-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    if(isset($_GET['continue'])){
        return;
    }
    
    foreach($resultados as $chamado){
            echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12 for-search" style="padding-bottom:10px;">';
                echo '<div class="card border-left-danger shadow h-100 py-2">';
                   echo '<div class="card-header" onclick="abrirVisualizacao('.$chamado['id_chamadoespera'].')" style="cursor: pointer;">';
                        echo'<div class="row no-gutters align-items-center text-uppercase text-gray-800"><strong>';
                                echo $chamado['empresa'];
                        echo '</strong></div>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <small>';
                                    echo $chamado['descproblema'];
                            echo'</small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-4 col-sm-12 col-md-12 col-lg-12 col-xl-4">';
                                    if($chamado['status'] == "Aguardando Retorno"){
                                        echo '<span class="badge badge-danger" style="white-space: pre-line !important;">Aguardando retorno</span>';
                                    }else{
                                        echo '<span class="badge badge-info" style="white-space: pre-line !important;">Entrado em contato</span>';
                                    }
                            echo '</div>
                                    <div class="col-8 col-sm-12 col-md-12 col-lg-12 col-xl-8 align-items-center text-right">
                                        <a href="../pages/abrechamadoespera='.$chamado['id_chamadoespera'].'" target="_blank" class="btn btn-success btn-circle m-1" data-toggle="tooltip" data-placement="bottom" title="Atender">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                        <a  class="btn btn-info btn-circle m-1" data-toggle="tooltip" data-placement="bottom" title="Agendar" onclick="abrirAgendamento('.$chamado['id_chamadoespera'].')" style="cursor: pointer; color:white;">
                                            <i class="fas fa-calendar-alt"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">';
                                    if($chamado['dataagendamento'] != null && $chamado['dataagendamento'] > $chamado['databanco']){
                                        echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12 align-middle text-info">
                                                 <small data-toggle="tooltip" data-placement="bottom" title="Data agendamento">
                                                    <i class="fas fa-calendar-alt m-1"></i>'.
                                                    $chamado['dataagendamentoformat'].'
                                                </small>
                                                </div>';
                                        }else{
                                        echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12 align-middle text-success">
                                        <small data-toggle="tooltip" data-placement="bottom" title="Última data atualizada">
                                            <i class="fas fa-calendar-alt m-1"></i>'.
                                            $chamado['dataFormatada'].'
                                    </small>
                                    </div>';
                                    }
                                    echo'<div class="col-12 col-sm-12 col-md-12 col-lg-12 align-middle text-danger">
                                        <small data-toggle="tooltip" data-placement="bottom" title="Tempo decorrido">
                                            <i class="far fa-clock m-1"></i>';
                                                if($chamado['dataagendamento'] != null){
                                                    echo formatDateDiff(date_create($chamado['dataagendamento']));
                                                }else{
                                                    echo formatDateDiff(date_create($chamado['databanco']));
                                                }
                                    echo '</small>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>';
    }

    function horarioValidoEnvio(){
        $hora = date('H');
        $dia = date('w');
        $horasSemana = array("08","09","10","11","12","13","14","15","16","17");
        $horasSabado = array("08", "09", "10", "11");
        if($dia == "0"){//Domingo
            return false;
        }else if($dia == "6" && !in_array($hora, $horasSabado)){//Sabado Antes das 08hrs e depois das 12hrs
            return false;
        }else if(!in_array($hora, $horasSemana)){//Segunda a sexta Antes das 08hrs e depois das 18hrs
            return false;
        }

        return true;
    }
?>