<!DOCTYPE html>
<html>
  <head>
    <script>
      function redireciona(){
        alert("Atendimento finalizado!");
        window.location.assign("chamados.php");
      }
    </script>
  </head>
</html>
<?php 
include 'include/dbconf.php';
$conn->exec('SET CHARACTER SET utf8');
$id=$_POST['id_chamado'];
$datafinal = date("Y-m-d H:i:s");
$status = "Finalizado";
$descsolucao=$_POST['descsolucao'];
$sql = $conn->prepare("UPDATE chamado SET status= :status, descsolucao= :descs, datafinal= :data WHERE id_chamado=:id") or die(mysql_error());
$sql ->bindParam(":status", $status, PDO::PARAM_STR,500);
$sql ->bindParam(":descs", $descsolucao, PDO::PARAM_STR,500);
$sql ->bindParam(":data", $datafinal, PDO::PARAM_STR,500);
$sql ->bindParam(":id", $id, PDO::PARAM_STR,500);
$sql->execute();
echo '<script> redireciona() </script>'      
?>
</body>
</html>
