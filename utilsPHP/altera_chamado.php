<!DOCTYPE html>
<html>
  <head>
    <script>
      function redireciona(){
        alert("Atendimento finalizado!");
        window.location.assign("../pages/chamados.php");
      }
    </script>
  </head>
</html>
<?php 
include '../include/dbconf.php';
include '../validacoes/verificaSession.php';
$conn->exec('SET CHARACTER SET utf8');
$id=$_POST['id_chamado'];
$datafinal = date("Y-m-d H:i:s");
$status = "Finalizado";
$descsolucao=str_replace("'","''",$_POST['descsolucao']);
$usuario=$_SESSION['UsuarioNome'];
$sql = $conn->prepare("UPDATE chamado SET status= :status, descsolucao= :descs, datafinal= :data WHERE id_chamado=:id") or die(mysql_error());
$sql ->bindParam(":status", $status, PDO::PARAM_STR, 500);
$sql ->bindParam(":descs", $descsolucao, PDO::PARAM_STR, 500);
$sql ->bindParam(":data", $datafinal, PDO::PARAM_STR, 500);
$sql ->bindParam(":id", $id, PDO::PARAM_STR, 500);
$sql->execute();

$sql = $conn->prepare("SELECT usuario FROM chamado WHERE id_chamado = '$id'");
$sql->execute();
$resultado = $sql->fetch();

if($resultado['usuario'] == $usuario){
  $sql = $conn->prepare("SELECT id_chamado FROM chamado WHERE usuario = '$usuario' and status = 'Aberto' ") or die(mysql_error());
  $sql->execute();
  if ($sql->rowCount()<1) {
      $sql = $conn->prepare("UPDATE usuarios set disponivel=0 where nome = '$usuario'") or die(mysql_error());
      $sql->execute();
  }
}else{
  $usuario = $resultado['usuario'];
  $sql = $conn->prepare("SELECT id_chamado FROM chamado WHERE usuario = '$usuario' and status = 'Aberto' ") or die(mysql_error());
  $sql->execute();
  if ($sql->rowCount()<1) {
      $sql = $conn->prepare("UPDATE usuarios set disponivel=0 where nome = '$usuario'") or die(mysql_error());
      $sql->execute();
  }
}
echo '<script> redireciona() </script>'
?>
</body>
</html>
