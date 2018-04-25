<?php
//Armazena os dados de login pra solicitar o token pra API 
$post = array(
        'session[email]' => 'admin@germantech.com.br',
        'session[password]' => 'q27pptz8'
    );
//URL de login da API
$URL='http://api.gtech.site/users/sign_in';
    
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$result=curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);//Se o status foi 200 deu tudo certo
curl_close($ch);
$dados = json_decode($result);
//pega o token de autenticação     
$token = $dados->auth_token;
//Monta a URL
$url = 'http://api.gtech.site/companies/';
//manda o token no header
$headers = [
        'Authorization:'.$token.'',
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
print_r($result);
