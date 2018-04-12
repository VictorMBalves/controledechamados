<?php
include '../include/dbconf.php'; 

if($_GET['acao'] == "novo"){
    $titulo = $_POST['tituloAviso'];
    $descricao = str_replace("'","''",stringInsert($_POST['descricaoAviso'],60,"\n"));

    $sql = $conn->prepare("INSERT INTO avisos (titulo, descricao) VALUES('$titulo','$descricao')");
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
    $sql = $conn->prepare("DELETE FROM avisos WHERE id='$id'");
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
    include('../include/db.php');
    $id = $_GET['id'];
    $sql = "SELECT  `titulo`,`descricao` FROM `avisos` WHERE `id` = '{$id}' ";
    $query = $conn->query($sql);
    $arr;
    if ($query->num_rows) {
        while ($dados = $query->fetch_object()) {
            $arr['titulo'] = $dados->titulo;
            $arr['descricao'] = $dados->descricao;
        }
    }
    echo json_encode($arr);
} 
if($_GET['acao'] == "update"){
    $titulo = $_POST['tituloAviso'];
    $descricao = str_replace("'","''",stringInsert($_POST['descricaoAviso'],60,"\n"));
    $id = $_GET['id'];

    $sql = $conn->prepare("UPDATE avisos SET titulo = '$titulo', descricao = '$descricao' WHERE id = '$id'");
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