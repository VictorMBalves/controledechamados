<?php
require_once '../include/Database.class.php';
$db = Database::conexao();
$hoje = date('Y-m-d');
$mes = date('m');
$query = $db->prepare("SELECT * FROM escalasobreaviso WHERE mes = '$mes' AND '$hoje' BETWEEN inicioperido AND fimperiodo");
$query->execute();
$resultado = $query->fetch();

if($resultado != null){
    echo'<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Responsavel pelo plantão na semana: <strong>'.$resultado['usuario'].'</strong> <span class="glyphicon glyphicon-send"></span>.</a>';
}else{
    echo'<a href="plantao" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Não há escala de sobreaviso para essa semana!</a>';
}
?>