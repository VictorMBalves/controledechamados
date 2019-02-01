<?php 
try
{
    //Make sure that it is a POST request.
    if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
        throw new Exception('Request method must be POST!');
    }
     
    //Make sure that the content type of the POST request has been set to application/json
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if(strcasecmp($contentType, 'application/json') != 0){
        throw new Exception('Content type must be: application/json');
    }
     
    //Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));
     
    //Attempt to decode the incoming RAW post data from JSON.
    $decoded = json_decode($content, true);
     
    //If json_decode failed, the JSON is invalid.
    if(!is_array($decoded)){
        throw new Exception('Received content contained invalid JSON!');
    } 

  require_once '../include/Database.class.php';
  $db = Database::conexao();
  $data = date("Y-m-d H:i:s");
  $status = "Aguardando Retorno";
  $empresa=$decoded['empresa'];
  $contato=$decoded['contato'];
  $telefone=$decoded['telefone'];
  $descproblema = str_replace("'","''",$decoded['descproblema']);
  $enderecado = $decoded['enderecado'];
  $sistema = $decoded['sistema'];
  $versao = $decoded['versao'];
  $usuario=$decoded['UsuarioNome'];
  $sql = $db->prepare("INSERT INTO chamadoespera (usuario, status, empresa, contato, telefone, descproblema, data, enderecado, sistema, versao) 
  VALUES ('$usuario', '$status', '$empresa', '$contato', '$telefone', '$descproblema', '$data', '$enderecado','$sistema', '$versao')") or die(mysql_error());

 
  if ($sql->execute()) {
    echo 'success';
    exit;
  } else {
    echo 'error';
    exit;
  }
}catch (PDOException $e){
  echo $e;
  exit;
}
?>
