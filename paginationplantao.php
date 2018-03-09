<?php
header("Content-type: text/html; charset=utf-8");
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) {
    session_start();
}
// Verifica se não há a variável da sessão que identifica o usuário
if ($_SESSION['UsuarioNivel'] == 1) {
    echo'<script>erro()</script>';
} else {
    if (!isset($_SESSION['UsuarioID'])) {
        //Destrói a sessão por segurança
        session_destroy();
        //Redireciona o visitante de volta pro login
        header("Location: index.php");
        exit;
    }
}
include 'include/db.php';

if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page=1;
};
$start_from = ($page-1) * $limit;
$usuario=$_SESSION['UsuarioNome'];
$sql = "SELECT id_plantao,usuario, status, empresa, contato, telefone, date(datainicio) FROM plantao where usuario='$usuario' ORDER BY id_plantao DESC LIMIT $start_from, $limit";
$rs_result = mysqli_query($conn, $sql);
?>

<?php 
while ($row = mysqli_fetch_assoc($rs_result)) {
    echo '<tr>';
    echo '<td>';
    if ($row['status']!="Finalizado") {
        echo'<div class="circle2" data-toggle="tooltip" data-placement="left" title="Status: Aberto"></div>';
    } else {
        echo'<div class="circle" data-toggle="tooltip" data-placement="left" title="Status: Finalizado"></div> ';
    }
    echo'</td>';
    echo '<td>'.$row["date(datainicio)"].'</td>';
    echo '<td>'.$row["usuario"].'</td>';
    echo '<td>'.$row["id_plantao"].'</td>';
    echo '<td>'.$row["empresa"].'</td>';
    echo '<td>'.$row["contato"].'</td>';
    echo '<td>'.$row["telefone"].'</td>';
    echo '<td>';
    if ($row["status"]!="Finalizado") {
        echo "
<a style='margin-top:2px;' href='editachamado.php?id_plantao=".$row['id_plantao']."'><button data-toggle='tooltip' data-placement='left' title='Editar chamado' class='btn btn-warning teste12' type='button'><span class='glyphicon glyphicon-pencil'></span></button></a>
<a href='abrechamado.php?id_plantao=".$row['id_plantao']."'><button data-toggle='tooltip' data-placement='left' title='Finalizar chamado' class='btn btn-success teste12' type='button'><span class='glyphicon glyphicon-ok'></span></button></a>";
    } else {
        echo "<a href='consulta.php?id_plantao=".$row['id_plantao']. "'><button class='btn btn-info btn-sm btn-block' type='button'>Consultar</button></a> </td>";
        echo '</tr>';
    }
}
?>
