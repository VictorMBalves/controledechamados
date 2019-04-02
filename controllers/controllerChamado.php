<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();

    $request_method = $_SERVER["REQUEST_METHOD"];
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    $allowed = ['id_chamado', 'status', 'empresa', 'cnpj', 'contato', 'telefone', 'sistema', 'versao', 'formacontato', 'descproblema', 'descsolucao', 'datainicio', 'datafinal', 'enderecado', 'usuario_id', 'categoria_id', 'id_chamadoespera'];
    $setStr = "";

    if(strcasecmp($contentType, 'application/json') != 0){
        returnMessage("Content type precisa ser: application/json", 400);
        exit;
    }

    function returnMessage($message, $status){
        global $request_method;
        return json_encode(array(
            "status" => $status,
            "message" => $message,
            "request_type" => $request_method,
        ), true);
    }

    function getContentsBody(){
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        return $decoded;
    }

    function create_stmt_params($decoded){
        global $allowed, $setStr;
       
        foreach ($allowed as $key)
        {
            if (isset($decoded[$key]) && $key != "id_chamado")
            {
                $setStr .= "`$key` = :$key,";
                $params[":".$key] = $decoded[$key];
            }
        }
        $setStr = rtrim($setStr, ",");

        return $params;
    }

    /**
     * Função para fazer update do chamado atualizando conforme os paramêtros passados no body da requisicao
     *
     */
    function update(){
        global $db, $setStr;
        $params = create_stmt_params(getContentsBody());
        
        if(!is_array($params)){
            echo returnMessage("Estrutura do body não corresponde a um JSON valido", 400);
            exit;
        }

        if(!isset($_GET['id'])){
            echo returnMessage("Não informado ID para UPDATE", 400);
            exit;
        }else{
            $params[':id_chamado'] = $_GET['id'];
        }

        try{
            $stmt = $db->prepare("UPDATE chamado SET $setStr WHERE id_chamado = :id_chamado");
            $stmt->execute($params);
        }catch(PDOException $e){
            echo returnMessage($e->getMessage(),400);
            exit;
        }

        if($stmt->rowCount()){
            echo returnMessage("Registro alterado com sucesso!",200);
            exit;
        }else{
            echo returnMessage("Nada para alterar",201);
            exit;
        }
        exit;
    }

    switch ($request_method) {
        case 'PUT':
           update();
           break;
        default:
           echo returnMessage("Não consegui entender sua requisição!", 405);
           break;
    }

?>