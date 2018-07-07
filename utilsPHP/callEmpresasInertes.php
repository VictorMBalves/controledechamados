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
       $resultado->phone = getPhoneBD($resultado->name, $db);
        
}
echo json_encode($resultados);

function getPhoneBD($nomeEmpresa, $db)
 {
    $sql = "SELECT `telefone`, `celular` FROM `empresa` WHERE `nome` = '{$nomeEmpresa}' ";
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $arr = [];
    if ($query->rowcount() > 0) {
        if($result['telefone'] != null && ($result['telefone'] != "(000)0000-0000" && $result['telefone'] != "(000)00000-0000")){
            return $result['telefone'];
        }if($result['celular'] != null && ($result['celular'] != "(000)00000-0000" && $result['celular'] != "(000)0000-0000")){
            return $result['celular'];
        }
    }
    return "Sem Telefone";
 }
?>


