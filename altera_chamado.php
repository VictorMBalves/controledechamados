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
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) {
    session_start();
}
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID'])) {
    // Destrói a sessão por segurança
    session_destroy();
    // Redireciona o visitante de volta pro login
    header("Location: index.php");
    exit;
}
include 'include/dbconf.php';
$conn->exec('SET CHARACTER SET utf8');
$id=$_POST['id_chamado'];
$datafinal = date("Y-m-d H:i:s");
$status = "Finalizado";
$descsolucao=$_POST['descsolucao'];
$usuario=$_SESSION['UsuarioNome'];
$sql = $conn->prepare("UPDATE chamado SET status= :status, descsolucao= :descs, datafinal= :data WHERE id_chamado=:id") or die(mysql_error());
$sql ->bindParam(":status", $status, PDO::PARAM_STR, 500);
$sql ->bindParam(":descs", $descsolucao, PDO::PARAM_STR, 500);
$sql ->bindParam(":data", $datafinal, PDO::PARAM_STR, 500);
$sql ->bindParam(":id", $id, PDO::PARAM_STR, 500);
$sql->execute();

$sql = $conn->prepare("SELECT * FROM chamado WHERE usuario = '$usuario' and status = 'Aberto' ") or die(mysql_error());
$sql->execute();
if ($sql->rowCount()<1) {
    $sql = $conn->prepare("UPDATE usuarios set disponivel=0 where nome = '$usuario'") or die(mysql_error());
    $sql->execute();
}
echo '<script> redireciona() </script>'
?>
</body>
</html>
