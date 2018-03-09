<?php
include 'include/db.php';
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page=1;
};
$start_from = ($page-1) * $limit;

$situacao = null;
$palavra = null;
$versao = null;
$sistema = null;
$versaoDiferente = null;

if(isset($_SESSION['situacao']))
    $situacao = $_SESSION['situacao'];
if(isset($_SESSION['palavra']))
    $palavra = $_SESSION['palavra'];
if(isset($_SESSION['versao']))
    $versao = $_SESSION['versao'];
if(isset($_SESSION['sistema']))
    $sistema = $_SESSION['sistema'];
if(isset($_SESSION['versaoDiferente']))
    $versaoDiferente = $_SESSION['versaoDiferente'];


    $query = "SELECT * FROM empresa";
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
    $sql = " $query ORDER BY id_empresa ASC LIMIT $start_from, $limit";
    $rs_result = mysqli_query($conn, $sql);
?>

<?php 
while ($row = mysqli_fetch_assoc($rs_result)) {
    echo '<tr>';
    echo '<td>'.$row["id_empresa"].'</td>';
    echo '<td>'.$row["nome"].'</td>';
    echo '<td>'.$row["situacao"].'</td>';
    echo '<td>'.$row["cnpj"].'</td>';
    echo '<td>'.$row["sistema"].'</td>';
    echo '<td>'.$row["versao"].'</td>';
    echo "<td> <a style='margin-top:2px;' href='editaempresa.php?id_empresa=".$row['id_empresa']."'><button data-toggle='tooltip' data-placement='left' title='Editar cadastro' class='btn btn-warning btn-sm btn-block' type='button'><span class='glyphicon glyphicon-pencil'></span></button></a>";
}
?>
