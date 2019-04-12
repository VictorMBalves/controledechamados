<?php
    require_once '../include/Database.class.php';
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
                DATE_FORMAT(dataagendamento,'%d/%m/%Y %H:%i') as dataagendamentoformat
            FROM chamadoespera 
            WHERE status <> 'Finalizado' 
            AND (dataagendamento IS NULL OR dataagendamento <= NOW())
            AND (data between DATE_ADD(NOW(), INTERVAL -10 MINUTE) AND NOW() OR dataagendamento between DATE_ADD(NOW(), INTERVAL -10 MINUTE) AND NOW())
            AND notification IS TRUE
            ORDER BY dataagendamento ASC, data ASC";
    $query = $db->prepare($sql);
    $query->execute();
    $resultados = $query->fetchall(PDO::FETCH_ASSOC);

    echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">
            <div class="card border-left-danger shadow h-100 py-2" style="background-color:#f9d5d2;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"><h6>PENDENTES</h6></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">'.sizeof($resultados).' chamados</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation fa-2x text-gray-600"></i>
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
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6">';
                                    if($chamado['status'] == "Aguardando Retorno"){
                                        echo '<span class="badge badge-warning">Aguardando retorno</span>';
                                    }else{
                                        echo '<span class="badge badge-info">Entrado em contato</span>';
                                    }
                            echo '</div>
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 align-items-center text-center">
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
                                    </div>';}
                                        echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12 align-middle text-success">
                                        <small data-toggle="tooltip" data-placement="bottom" title="Última data atualizada">
                                            <i class="fas fa-calendar-alt m-1"></i>'.
                                               $chamado['dataFormatada'].'
                                    </small>
                                    </div>';
                                
                                    echo'<div class="col-12 col-sm-12 col-md-12 col-lg-12 align-middle text-danger">
                                        <small data-toggle="tooltip" data-placement="bottom" title="Tempo decorrido">
                                            <i class="far fa-clock m-1"></i>';
                                                if($chamado['dataagendamento'] != null && $chamado['dataagendamento'] > $chamado['databanco']){
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
?>