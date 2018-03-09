<?php 
include 'include/dbconf.php';
echo'<div class="table-responsive">';
echo '<table class="table table-hover">';
echo '<tr class="caption">' ;
echo '<th>Status</th>';
echo '<th>contato</th>';
echo '<th>Data</th>';
echo '<th>Atendente</th>';
echo '<th>Atribuí­do para</th>';
echo '<th>Empresa</th>';
echo '<th>Contato</th>';
echo '<th>Telefone</th>';
echo '<th width="100px"><center><img src="imagem/acao.png"></center></th>
</tr>   
<tbody>';
$sql = $conn->prepare('SELECT id_chamadoespera, usuario, status, empresa, contato, telefone, data, enderecado, historico FROM chamadoespera ORDER BY data desc');
$sql->execute();
$result = $sql->fetchall();
foreach ($result as $row) {

    $data = formatarData($row['data']);

    if (!($row["status"] == "Finalizado")) {
        echo '<tr>';
        echo '<td>';
        if ($row['status']=="Aguardando Retorno") {
            echo '<div class="circle3" data-toggle="tooltip" data-placement="left" title="Aguardando Retorno"></div>';
        } else {
            echo '<div class="circle4" data-toggle="tooltip" data-placement="left" title="Entrado em contato"></div>';
        }
        echo '</td>';
        echo '<td>';
        if (is_null($row['historico'])) {
            echo 'Não';
        } else {
            echo 'Sim';
        }
        echo '</td>';
        echo '<td>'.$data.'</td>';
        echo '<td>'.$row["usuario"].'</td>';
        echo '<td>';
        if ($row["enderecado"] == null) {
            echo"Ninguém";
        } else {
            echo $row['enderecado'];
        }
        echo'</td>';
        echo '<td>'.$row["empresa"].'</td>';
        echo '<td>'.$row["contato"].'</td>';
        echo '<td>'.$row["telefone"].'</td>';
        echo "<td><a href='consultaespera.php?id_chamadoespera=".$row['id_chamadoespera']."'><button data-toggle='tooltip' data-placement='left' title='Visualizar' class='btn btn-info bttt' type='button'><i class='glyphicon glyphicon-search'></i></button></a> 
<a href='abrechamadoespera.php?id_chamadoespera=".$row['id_chamadoespera']. "'><button data-toggle='tooltip' data-placement='right' title='Atender' class='btn btn-success bttt' type='button'><i class='glyphicon glyphicon-share-alt'></i></button></a></td>";
        echo '</tr>';
    }
}

function formatarData($data){
$datainicio = date_create($data);
$dataFormatada = date_format($datainicio, 'd/m H:i');
return $dataFormatada;
}
?>