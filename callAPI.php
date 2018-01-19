<?php
include('include/db.php');
if (isset($_GET['empresa'])) {
    echo retorna($_GET['empresa'], $conn);
}
//Retorna os dados da empresa pela API de BLOQUEIO 
function retorna($nome, $conn){
    $sql = "SELECT `cnpj` FROM `empresa` WHERE `nome` = '{$nome}' ";

    $query = $conn->query($sql);

    $arr;
    if ($query->num_rows) {
        while ($dados = $query->fetch_object()) {
            $arr['cnpj'] = $dados->cnpj;
        }
    }
      
      
      
    $post = array(
          'session[email]' => 'admin@germantech.com.br',
          'session[password]' => 'q27pptz8'
        );
        
    $URL='http://api.gtech.site/users/sign_in';
        
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URL);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $result=curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
    curl_close($ch);
    $dados = json_decode($result);
        
    $token = $dados->auth_token;
    //Monta a URL
        
    //distribuindo a informação a ser enviada
    $cnpj = $arr['cnpj'];

    $cnpj = trim($cnpj);
    $cnpj = str_replace(".", "", $cnpj);
    $cnpj = str_replace(",", "", $cnpj);
    $cnpj = str_replace("-", "", $cnpj);
    $cnpj = str_replace("/", "", $cnpj);
        
    //Monta a URL
    $url = 'http://api.gtech.site/companies/'.$cnpj.'';
        
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
        
    return $result;
}
