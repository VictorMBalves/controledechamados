<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    
    $sql = "SELECT 
                id_chamadoespera, 
                status, 
                empresa,  
                data as databanco,  
                notification, 
                descproblema, 
                DATE_FORMAT(dataagendamento,'%d/%m/%Y %H:%i') as dataagendamento, 
                dataagendamento as dataAgend 
            FROM chamadoespera 
            WHERE status <> 'Finalizado' 
            AND dataagendamento IS NOT NULL AND dataagendamento >= NOW() ORDER BY dataagendamento ASC";
    $query = $db->prepare($sql);
    $query->execute();
    $resultados = $query->fetchall(PDO::FETCH_ASSOC);

    echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">
            <div class="card border-left-info shadow h-100 py-2" style="background-color:#d6f1f5;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><h6>AGENDADOS</h6></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">'.sizeof($resultados).' chamados</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-600"></i>
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
                echo '<div class="card border-left-info shadow h-100 py-2">';
                   echo '<div class="card-header" onclick="abrirVisualizacao('.$chamado['id_chamadoespera'].')" style="cursor: pointer;">';
                        echo'<div class="row no-gutters align-items-center text-uppercase">';
                                echo $chamado['empresa'];
                        echo '</div>
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
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 align-items-center text-right">
                                        <a href="../pages/abrechamadoespera='.$chamado['id_chamadoespera'].'" target="_blank" class="btn btn-success btn-circle" data-toggle="tooltip" data-placement="bottom" title="Atender">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 align-middle text-info">
                                            <small data-toggle="tooltip" data-placement="bottom" title="Data agendamento">
                                                <i class="fas fa-calendar-alt"></i>&nbsp';
                                                    echo $chamado['dataagendamento'];
                                        echo '</small>
                                        </div>';
                                        if($chamado['dataAgend'] < date("Y-m-d H:i:s")) {
                                            echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12 align-middle text-danger">
                                                    <small data-toggle="tooltip" data-placement="bottom" title="Tempo decorrido">
                                                    <i class="far fa-clock"></i>&nbsp';
                                                        echo formatDateDiff(date_create($chamado['dataAgend']));
                                                echo '</small>
                                                </div>';
                                        }
                               echo'</div>
                            </div>
                    </div>
                </div>';
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
                return "há menos de um minuto"; 
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
?>