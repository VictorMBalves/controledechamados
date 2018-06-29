<?php
require_once '../include/Database.class.php';
$db = Database::conexao();
$hoje = date('Y-m-d');
$mes = date('m');
$query = $db->prepare("SELECT * FROM escalasobreaviso WHERE mes = '$mes' AND '$hoje' BETWEEN inicioperido AND fimperiodo");
$query->execute();
$resultado = $query->fetch();


if($resultado != null){
    echo'<div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Responsavel pelo plantão na semana: <strong>'.$resultado['usuario'].'</strong> <span class="glyphicon glyphicon-send"></span>.
        </div>';
}else{
    echo'<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Não há escala de sobreaviso para essa semana! <a href="plantao" class="alert-link"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" data-placement="left" title="Adicionar Escala"></span></a>.
    </div>';
}
?>