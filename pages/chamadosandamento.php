<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    
    $sql = "SELECT cha.id_chamado as id_chamado, cha.usuario as usuario, cha.empresa as empresa, cha.contato as contato, cha.telefone as telefone, cha.datainicio as datainicio, cha.descproblema as descproblema, usu.email as email FROM chamado cha INNER JOIN usuarios usu ON usu.nome = cha.usuario  WHERE cha.status <> 'Finalizado' ORDER BY  cha.datainicio DESC";
    $query = $db->prepare($sql);
    $query->execute();
    $resultados = $query->fetchall(PDO::FETCH_ASSOC);

    echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><h6>Em Andamento</h6></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">'.sizeof($resultados).' chamados</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list-ul fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

    foreach($resultados as $chamado){
            echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">';
                echo '<div class="card for-search border-left-primary shadow h-100 py-2">';
                   echo '<div class="card-header" onclick="abrirVisualizacaoChamado('.$chamado['id_chamado'].')" style="cursor: pointer;">';
                        echo'<div class="row no-gutters align-items-center text-uppercase">';
                                echo $chamado['empresa'];
                        echo '</div>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <small>';
                                if($chamado['descproblema'] != '')
                                    echo $chamado['descproblema'];
                                else
                                    echo '<small class="text-muted">Sem descrição do chamado</small>';
                            echo'</small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 text-left">
                                    <img style="width:2.5rem;height:2.5rem;"class="img-profile rounded-circle" src="https://www.gravatar.com/avatar/'.md5($chamado['email']).'" data-toggle="tooltip" data-placement="left" title="Atendente responsável '.$chamado['usuario'].'">';
                            echo '</div>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                    <a href="../pages/abrechamadofa='.$chamado['id_chamado'].'" class="btn btn-success btn-circle" data-toggle="tooltip" data-placement="bottom" title="Finalizar chamado">
                                        <i class="far fa-check-circle"></i>
                                    </a>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 align-middle text-danger">
                                        <small data-toggle="tooltip" data-placement="bottom" title="Tempo decorrido">
                                            <i class="far fa-clock"></i>&nbsp';
                                                echo formatDateDiff(date_create($chamado['datainicio']));
                                    echo '</small>
                                    </div>
                                </div>
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