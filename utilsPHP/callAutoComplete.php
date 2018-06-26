<?php
if (isset($_GET['term'])) {
    echo retorna($_GET['term']);
}
//Retorna os dados da empresa pela API de BLOQUEIO
function retorna($term)
{
    //Monta a URL
    $ano = Date('Y');
    $mes = Date('m');
    $dia = Date('j'); //Dia do mes sem Zero a esquerda ex: 1, 2, 3 ...

    $token = md5($ano.'11586637000128'.$mes.$dia);
    
    $url = 'http://api.gtech.site/companies/find_companies?term='.$term.'';

    //manda o token no header
    $headers = [
        'Authorization:'.$token.'',
        'Accept:application/vnd.germantech.v2'
    ];
    $ch = curl_init();
    //envia a URL como parâmetro para o cURL;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result=curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
    curl_close($ch);
    //retorna os dados da empresa em JSON encode
    $datas = json_decode($result, TRUE);
    
    foreach($datas as $data){
        $dado[] = strtoupper($data['name']);
    }

    return json_encode($dado);
}