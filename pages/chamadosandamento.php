<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    
    $sql = "SELECT  cha.id_chamado as id_chamado, 
                    cha.empresa as empresa, 
                    cha.contato as contato, 
                    cha.telefone as telefone, 
                    cha.datainicio as 
                    datainicio, 
                    cha.descproblema as descproblema, 
                    usu.email as email, 
                    usu.nome as usuario 
            FROM chamado cha 
            LEFT JOIN usuarios usu ON usu.id = cha.usuario_id  
            WHERE cha.status <> 'Finalizado' 
            ORDER BY  cha.datainicio";
    $query = $db->prepare($sql);
    $query->execute();
    $resultados = $query->fetchall(PDO::FETCH_ASSOC);

    echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">
            <div class="card border-left-primary shadow h-100 py-2" style="background-color:#d4ddf7;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><h6>Em Andamento</h6></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">'.sizeof($resultados).' chamados</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list-ul fa-2x text-gray-600"></i>
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
                echo '<div class="card border-left-primary shadow h-100 py-2">';
                   echo '<div class="card-header" onclick="abrirVisualizacaoChamado('.$chamado['id_chamado'].')" style="cursor: pointer;">';
                        echo'<div class="row no-gutters align-items-center text-uppercase text-gray-800"><strong>';
                                echo $chamado['empresa'];
                        echo '</strong></div>
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
                                <div class="col-6 col-sm-12 col-md-6 col-lg-6 text-left">
                                    <img style="width:2.5rem;height:2.5rem;"class="img-profile rounded-circle" src="https://www.gravatar.com/avatar/'.md5($chamado['email']).'" data-toggle="tooltip" data-placement="left" title="Atendente responsável '.$chamado['usuario'].'">';
                            echo '</div>
                                <div class="col-6 col-sm-12 col-md-6 col-lg-6 text-right">
                                    <a href="../pages/abrechamadofa='.$chamado['id_chamado'].'" target="_blank" class="btn btn-success btn-circle" data-toggle="tooltip" data-placement="bottom" title="Finalizar chamado">
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

?>