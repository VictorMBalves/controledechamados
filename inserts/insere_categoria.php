<?php
require_once '../include/Database.class.php';
// include '../validacoes/verificaSession.php';
$db = Database::conexao();

$request_method = $_SERVER["REQUEST_METHOD"];
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

 if(strcasecmp($contentType, 'application/json') != 0){
     returnMessage("Content type precisa ser: application/json", 405);
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

function insertCategoria(){
    global $db;
    $decoded =  getContentsBody();
    $categoria = $decoded['categoria'];
    $descricao = $decoded['descricao'];
    try{
        $stmt = $db->prepare("INSERT INTO categoria (categoria, descricao) VALUES(:categoria, :descricao)");
        $stmt->execute(array(
            ':categoria' => $categoria,
            ':descricao' => $descricao
        ));
    }catch(PDOException $e){
        echo returnMessage($e->getMessage(),400);
        exit;
    }
    if($stmt->rowCount()){
        echo returnMessage("Registro salvo com sucesso!",200);
        exit;
    }else{
        echo returnMessage("Erro ao inserir registro!",400);
        exit;
    }

    exit;
}

function getCategoria(){
    global $db;
    $decoded =  getContentsBody();
    if(is_array($decoded)){
        try{
            $id = $decoded['id'];
            $stmt = $db->prepare("SELECT * FROM categoria WHERE id = :id ORDER BY datacadastro DESC");
            $stmt->execute(array(
                ':id' => $id
            ));
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($resultado);
            exit;
        }catch(PDOException $e){
            echo returnMessage($e->getMessage(),400);
            exit;
        }
    }else{
        try{
            if(isset($_GET['term'])){
                $searchTerm = $_GET['term'];
                $stmt = $db->prepare("SELECT * FROM categoria WHERE lower(categoria) LIKE lower('%".$searchTerm."%') ORDER BY descricao DESC");
            }else{
                $stmt = $db->prepare("SELECT * FROM categoria ORDER BY datacadastro DESC");
            }
            $stmt->execute();
            $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);
            echo json_encode($resultado);
            exit;
        }catch(PDOException $e){
            echo returnMessage($e->getMessage(),400);
            exit;
        }
    }
    exit;
}

function updateCategoria(){
    global $db;
    $decoded =  getContentsBody();

    if(!is_array($decoded)){
        echo returnMessage("Estrutura do body não corresponde a um JSON valido", 405);
        exit;
    }

    $id = $decoded['id'];
    $categoria = $decoded['categoria'];
    $descricao = $decoded['descricao'];

    try{
        $stmt = $db->prepare("UPDATE categoria SET categoria = :categoria, descricao = :descricao WHERE id = :id");
        $stmt->execute(array(
            ':id' => $id,
            ':categoria' => $categoria,
            ':descricao' => $descricao
        ));
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

function deleteCategoria(){
    global $db;
    $decoded =  getContentsBody();

    if(!is_array($decoded)){
        echo returnMessage("Estrutura do body não corresponde a um JSON valido", 405);
        exit;
    }

    try{
        $stmt = $db->prepare("DELETE FROM categoria WHERE id = :id");
        $stmt->execute(array(
            ":id" => $decoded['id']
        ));
        if($stmt->rowcount() > 0){
            echo returnMessage("registro excluido",200);
            return;
        }else{
            echo returnMessage("Erro ao excluir",400);
            return;
        }
        exit;
    }catch(PDOException $e){
        echo returnMessage($e->getMessage(),400);
        exit;
    }
}

switch ($request_method) {
    case 'POST':
       insertCategoria();
       break;
    case 'GET':
       getCategoria();
       break;
    case 'PUT':
       updateCategoria();
       break;
    case 'DELETE':
       deleteCategoria();
       break;
    default:
       echo returnMessage("Não consegui entender sua requisição!", 405);
       break;
}
?>