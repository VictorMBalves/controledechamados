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
            AND notification IS FALSE
            ORDER BY status, data DESC, dataagendamento DESC";
    $query = $db->prepare($sql);
    $query->execute();
    $resultados = $query->fetchall(PDO::FETCH_ASSOC);

    $cards = [];

    foreach($resultados as $chamado) {
        $card = "";
        $card .='<div class="col-12 col-sm-12 col-md-12 col-lg-12 for-search" style="padding-bottom:10px;">';
            $card .='<div class="card border-left-success  shadow h-100 py-2">';
                $card .='<div class="card-header" onclick="abrirVisualizacao('.$chamado['id_chamadoespera'].')" style="cursor: pointer;">';
                    $card .='<div class="row no-gutters align-items-center text-uppercase text-gray-800"><strong>';
                        $card .=$chamado['empresa'];
                            $card .='</strong></div>
                </div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <small>';
                        $card .= $chamado['descproblema'];
                        $card .='</small>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">';
                            if($chamado['status'] == "Aguardando Retorno"){
                                $card .='<span class="badge badge-warning">Aguardando retorno</span>';
                            }else{
                                $card .='<span class="badge badge-info">Entrado em contato</span>';
                            }
                            $card .='</div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 align-items-center text-right">
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
                                $card.='<div class="col-12 col-sm-12 col-md-12 col-lg-12 align-middle text-info">
                                         <small data-toggle="tooltip" data-placement="bottom" title="Data agendamento">
                                            <i class="fas fa-calendar-alt m-1"></i>'.
                                            $chamado['dataagendamentoformat'].'
                                        </small>
                                        </div>';
                                }
                                    $card.='<div class="col-12 col-sm-12 col-md-12 col-lg-12 align-middle text-success">
                                <small data-toggle="tooltip" data-placement="bottom" title="Última data atualizada">
                                    <i class="fas fa-calendar-alt m-1"></i>'.
                                    $chamado['dataFormatada'].'
                            </small>
                            </div>';
                            $card.='<div class="col-12 col-sm-12 col-md-12 col-lg-12 align-middle text-danger">
                                <small data-toggle="tooltip" data-placement="bottom" title="Tempo decorrido">
                                    <i class="far fa-clock m-1"></i>';
                                        $card.=formatDateDiff(date_create($chamado['databanco']));
                                        $card.='</small>
                            </div>
                        </div>
                    </div>
            </div>
        </div>';
        array_push($cards, $card);
    }
    echo json_encode($cards, JSON_UNESCAPED_UNICODE);
?>
