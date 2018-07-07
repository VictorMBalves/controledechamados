<?php
require_once '../include/Database.class.php';
$db = Database::conexao();
//se a variavel da empresa estiver vazia retorna
if (isset($_GET['empresa'])) {
    echo retorna($_GET['empresa'], $db);
}
//Retorna os dados da empresa pela API de BLOQUEIO
function retorna($nome, $db)
{
    //pega o cnpj da empresa que foi solicitada
    $sql = "SELECT `cnpj` FROM `empresa` WHERE `nome` = '{$nome}' ";

    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    
    $cnpj = $result['cnpj'];
    //Remove traços e pontos
    $cnpj = trim($cnpj);
    $cnpj = str_replace(".", "", $cnpj);
    $cnpj = str_replace(",", "", $cnpj);
    $cnpj = str_replace("-", "", $cnpj);
    $cnpj = str_replace("/", "", $cnpj); 

    $url = 'http://api.gtech.site/companies/'.$cnpj.'';
    require_once '../include/ConsultacURL.class.php';

    $curl = new ConsultacURL();
    echo $curl->connection($url);
}