<?php
include 'include/db.php';

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  
  
$sql = "SELECT id_chamado,usuario, status, empresa, contato, telefone, date(datainicio) FROM chamado ORDER BY id_chamado DESC LIMIT $start_from, $limit";  
$rs_result = mysqli_query($conn, $sql); 
?>

<?php  
while ($row = mysqli_fetch_assoc($rs_result)) {
echo '<tr>';            
echo '<td>';if($row['status']!="Finalizado"){echo'<div class="circle2" data-toggle="tooltip" data-placement="left" title="Status: Aberto"></div>';} else {echo'<div class="circle" data-toggle="tooltip" data-placement="left" title="Status: Finalizado"></div> '; } 
echo'</td>';
echo '<td>'.$row["date(datainicio)"].'</td>';
echo '<td>'.$row["usuario"].'</td>';
echo '<td>'.$row["id_chamado"].'</td>';
echo '<td>'.$row["empresa"].'</td>';
echo '<td>'.$row["contato"].'</td>';
echo '<td>'.$row["telefone"].'</td>';
echo '<td>';
if ($row["status"]!="Finalizado") {
echo "
<a style='margin-top:2px;' href='editachamado.php?id_chamado=".$row['id_chamado']."'><button data-toggle='tooltip' data-placement='left' title='Editar chamado' class='btn btn-warning teste12' type='button'><span class='glyphicon glyphicon-pencil'></span></button></a>
<a href='abrechamado.php?id_chamado=".$row['id_chamado']."'><button data-toggle='tooltip' data-placement='left' title='Finalizar chamado' class='btn btn-success teste12' type='button'><span class='glyphicon glyphicon-ok'></span></button></a>";
}
else{
echo "<a href='consulta.php?id_chamado=".$row['id_chamado']. "'><button class='btn btn-info btn-sm btn-block' type='button'>Consultar</button></a> </td>";
echo '</tr>';
}  
}
?>
