<?php

    include '../include/dbconf.php'; 

    if($_POST == null){
        $sql = "SELECT id_empresa, nome, situacao, cnpj, sistema, versao FROM empresa ORDER BY id_empresa ASC";
        $query = $conn->prepare($sql);
        $query->execute();
        $resultado = $query->fetchall();
        echo json_encode($resultado);
    }else{
        $situacao = $_POST['situacao'];
        $palavra = $_POST['palavra'];
        $versaoDiferente = isset($_POST['negaVersao']);
        $sistema = $_POST['sistema'];
        $versao = $_POST['versao'];
  
        $query = "SELECT id_empresa, nome, situacao, cnpj, sistema, versao FROM empresa";
        if ($situacao != null) {
            $query = " $query WHERE situacao LIKE '$situacao' ";
        }
        if ($palavra != null) {
            if ($situacao != null) {
                $query = " $query AND nome LIKE '%".$palavra."%' ";
            } else {
                $query = " $query WHERE nome LIKE '%".$palavra."%' ";
            }
        }
        if ($sistema != null) {
            if ($situacao != null || $palavra != null) {
                $query = " $query AND sistema LIKE '$sistema'";
            } else {
                $query = " $query WHERE sistema LIKE '$sistema'";
            }
        }
        if ($versao != null) {
            if ($versaoDiferente != null) {
                if ($situacao != null || $palavra != null || $sistema != null) {
                    $query = " $query AND versao <> '$versao'";
                } else {
                    $query = " $query WHERE versao <> '$versao'";
                }
            } else {
                if ($situacao != null || $palavra != null || $sistema != null) {
                    $query = " $query AND versao LIKE '$versao'";
                } else {
                    $query = " $query WHERE versao LIKE '$versao'";
                }
            }
        }
        $sql = " $query ORDER BY id_empresa asc";
        
        $query = $conn->prepare($sql);
        $query->execute();
        $resultado = $query->fetchall();
        echo json_encode($resultado);
    }

?>