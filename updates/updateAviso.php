<?php
require_once '../include/Database.class.php';
$db = Database::conexao();

if($_GET['acao'] == "novo"){
    $titulo = $_POST['tituloAviso'];
    $descricao = str_replace("'","''",stringInsert($_POST['descricaoAviso'],60,"\n"));

    $sql = $db->prepare("INSERT INTO avisos (titulo, descricao) VALUES('$titulo','$descricao')");
    $sql->execute();
    if($sql->rowcount() > 0){
        echo 'success';
        return;
    }else{
        echo 'error';
        return;
    }
}
if($_GET['acao'] == "excluir"){
    $id = $_POST['id'];
    $sql = $db->prepare("DELETE FROM avisos WHERE id='$id'");
    $sql->execute();
    if($sql->rowcount() > 0){
        echo 'success';
        return;
    }else{
        echo 'error';
        return;
    }
}
if($_GET['acao'] == "getAviso"){
    $id = $_GET['id'];
    $query = $db->prepare("SELECT  `titulo`,`descricao` FROM `avisos` WHERE `id` = '{$id}' ");
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($query->rowcount() > 0) {
        echo json_encode($result);
    }
} 
if($_GET['acao'] == "update"){
    $titulo = $_POST['tituloAviso'];
    $descricao = str_replace("'","''",stringInsert($_POST['descricaoAviso'],60,"\n"));
    $id = $_GET['id'];

    $sql = $db->prepare("UPDATE avisos SET titulo = '$titulo', descricao = '$descricao' WHERE id = '$id'");
    $sql->execute();
    if($sql->rowcount() > 0){
        echo 'success';
        return;
    }else{
        echo 'error';
        return;
    }
}  


function stringInsert($str,$pos,$insertstr)
{
    if (!is_array($pos))
        $pos=array($pos);

    $offset=-1;
        foreach($pos as $p)
        {
            $offset++;
            $str = substr($str, 0, $p+$offset) . $insertstr . substr($str, $p+$offset);
        }
    return $str;
}

?>