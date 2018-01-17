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
$situacao = $_SESSION['situacao'];
$palavra = $_SESSION['palavra'];
$query = "SELECT * FROM empresa ";
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
    echo '<td>'.$row["telefone"].'</td>';
    echo '<td>'.$row["celular"].'</td>';
    echo "<td> <a style='margin-top:2px;' href='editaempresa.php?id_empresa=".$row['id_empresa']."'><button data-toggle='tooltip' data-placement='left' title='Editar cadastro' class='btn btn-warning btn-sm btn-block' type='button'><span class='glyphicon glyphicon-pencil'></span></button></a>";
}
?>
