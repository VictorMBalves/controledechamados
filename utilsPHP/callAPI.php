<?php
include('../include/db.php');
//se a variavel da empresa estiver vazia retorna
if (isset($_GET['empresa'])) {
    echo retorna($_GET['empresa'], $conn);
}
//Retorna os dados da empresa pela API de BLOQUEIO
function retorna($nome, $conn)
{
    //pega o cnpj da empresa que foi solicitada
    $sql = "SELECT `cnpj` FROM `empresa` WHERE `nome` = '{$nome}' ";

    $query = $conn->query($sql);

    $arr;
    if ($query->num_rows) {
        while ($dados = $query->fetch_object()) {
            $arr['cnpj'] = $dados->cnpj;
        }
    } 
    
    $cnpj = $arr['cnpj'];
    //Remove traços e pontos
    $cnpj = trim($cnpj);
    $cnpj = str_replace(".", "", $cnpj);
    $cnpj = str_replace(",", "", $cnpj);
    $cnpj = str_replace("-", "", $cnpj);
    $cnpj = str_replace("/", "", $cnpj); 

    //Monta a URL
    $ano = Date('Y');
    $mes = Date('m');
    $dia = Date('j'); //Dia do mes sem Zero a esquerda ex: 1, 2, 3 ...

    $token = md5($ano.'11586637000128'.$mes.$dia);
    
    $url = 'http://api.gtech.site/companies/'.$cnpj.'';

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
    return $result;
}

  // //Armazena os dados de login pra solicitar o token pra API 
    // $post = array(
    //       'session[email]' => 'admin@germantech.com.br',
    //       'session[password]' => 'q27pptz8'
    //     );
    // //URL de login da API
    // $URL='http://api.gtech.site/users/sign_in';
        
    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, $URL);
    // curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    // $result=curl_exec($ch);
    // $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);//Se o status foi 200 deu tudo certo
    // curl_close($ch);
    // $dados = json_decode($result);
    // //pega o token de autenticação     
    // $token = $dados->auth_token;
    // //pega o cnpj da empresa pra enviar junto com o token 