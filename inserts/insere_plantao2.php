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
    header("Location: ../index.html");
    exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <script>
      function redireciona(){
        alert("Plantão Registrado!");
        window.location.assign("../pages/plantao.php?#menu1");
      }
      function erro(){
        alert("Erro ao registrar atendimento!");
        window.location.assign("../pages/plantao.php");
      }
    
    </script>
  </head>
</html>
<?php 
include '../include/dbconf.php'; 
$conn->exec('SET CHARACTER SET utf8');
$data=$_POST['data'];
$horai=$_POST['horainicio'];
$horaf=$_POST['horafim'];
$status = "Finalizado";
$empresa=$_POST['empresa'];
$contato=$_POST['contato'];
$telefone=$_POST['telefone'];
$sistema=$_POST['sistema'];
$versao=$_POST['versao'];
$formacontato=$_POST['formacontato'];
$categoria=$_POST['categoria'];
$descproblema=str_replace("'","''",$_POST['descproblema']);
$descsolucao=str_replace("'","''",$_POST['descsolucao']);
$usuario=$_SESSION['UsuarioNome'];
$backup=$_POST['backup'];
$sql = $conn->prepare("UPDATE empresa set backup = '$backup' where nome='$empresa'") or die(mysql_error());
$sql->execute();
$sql = $conn->prepare("INSERT INTO plantao (usuario, status, empresa, contato, telefone, sistema, versao, formacontato, categoria, descproblema, descsolucao, data, horainicio, horafim) 
VALUES (:usuario, :status, :empresa, :contato, :telefone, :sistema, :versao, :formacontato, :categoria, :descproblema, :descsolucao, :data, :horai, :horaf)") or die(mysql_error());
$sql ->bindParam(":usuario", $usuario, PDO::PARAM_STR, 500);
$sql ->bindParam(":status", $status, PDO::PARAM_STR, 500);
$sql ->bindParam(":empresa", $empresa, PDO::PARAM_STR, 500);
$sql ->bindParam(":contato", $contato, PDO::PARAM_STR, 500);
$sql ->bindParam(":telefone", $telefone, PDO::PARAM_STR, 500);
$sql ->bindParam(":sistema", $sistema, PDO::PARAM_STR, 500);
$sql ->bindParam(":versao", $versao, PDO::PARAM_STR, 500);
$sql ->bindParam(":formacontato", $formacontato, PDO::PARAM_STR, 500);
$sql ->bindParam(":categoria", $categoria, PDO::PARAM_STR, 500);
$sql ->bindParam(":descproblema", $descproblema, PDO::PARAM_STR, 500);
$sql ->bindParam(":descsolucao", $descsolucao, PDO::PARAM_STR, 500);
$sql ->bindParam(":data", $data, PDO::PARAM_STR, 500);
$sql ->bindParam(":horai", $horai, PDO::PARAM_STR, 500);
$sql ->bindParam(":horaf", $horaf, PDO::PARAM_STR, 500);
$sql->execute();
if ($sql->rowCount() > 0) {
    echo '<script> redireciona() </script>';
} else {
    echo '<script> erro() </script>';
}
?>
</body>
</html>