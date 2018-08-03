<?php
require_once '../include/ConsultacURL.class.php';
require_once '../include/Database.class.php';

$db = Database::conexao();

if(isset($_POST['versao'])){
    $versao = str_replace(".","",$_POST['versao']);
    $url = "api.gtech.site/companies?q[version_int_lt]=".$versao."&q[active_eq]=true";
}else{
    $url ="api.gtech.site/companies?q[version_int_lt]=4350&q[active_eq]=true";
}
$curl = new ConsultacURL();
$resultados =& json_decode($curl->connection($url));
foreach ($resultados as $resultado){
    if($resultado->phone == null)
        $resultado->phone = "Sem telefone";
    if($resultado->city == null)
        $resultado->city = "Sem cidade";
    if($resultado->state == null)
        $resultado->state = "Sem estado";
    $resultado->phone2 = getPhoneBD($resultado->name, $db, "Telefone");
    $resultado->celular = getPhoneBD($resultado->name, $db, "Celular");
    $resultado->payment = number_format($resultado->payment, 2, ',', '.');
}
echo json_encode($resultados);



function getPhoneBD($nomeEmpresa, $db, $tipo)
 {
    $sql = "SELECT `telefone`, `celular` FROM `empresa` WHERE `nome` = '{$nomeEmpresa}' ";
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $arr = [];
    if ($query->rowcount() > 0) {
        if($tipo == "Telefone"){
            return $result['telefone'];
        }if($tipo == "Celular"){
            return $result['celular'];
        }
    }
    return "Sem Telefone";
 }
?>


