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
?>
<!DOCTYPE html>
<html>
  <head>
    <script>
      function redireciona(){
        alert("Atendimento Registrado!");
        window.location.assign("chamados.php");
      }
    </script>
  </head>
</html>
<?php 
include 'include/dbconf.php';
$conn->exec('SET CHARACTER SET utf8');
$idchamadoespera =$_POST['id_chamadoespera'];
$statusespera = "Finalizado";

$sql = $conn->prepare("UPDATE chamadoespera SET status= :s WHERE id_chamadoespera= :id ") or die(mysql_error());
$sql->bindParam(":s", $statusespera, PDO::PARAM_STR, 500);
$sql->bindParam(":id", $idchamadoespera, PDO::PARAM_INT);
$sql->execute();

$datainicio = date("Y-m-d H:i:s");
$status = "Aberto";
$idchamadoespera=$_POST['id_chamadoespera'];
$empresa=$_POST['empresa'];
$contato=$_POST['contato'];
$telefone=$_POST['telefone'];
$sistema=$_POST['sistema'];
$versao=$_POST['versao'];
$formacontato=$_POST['formacontato'];
$categoria=$_POST['categoria'];
$descproblema=str_replace("'","''",$_POST['descproblema']);
$usuario=$_SESSION['UsuarioNome'];
$backup=$_POST['backup'];
$sql = $conn->prepare("UPDATE empresa set backup = '$backup' where nome='$empresa'") or die(mysql_error());
$sql->execute();
$sql = $conn->prepare("UPDATE usuarios set disponivel=1 where nome = '$usuario'") or die(mysql_error());
$sql->execute();
$sql = $conn->prepare("INSERT INTO chamado (id_chamadoespera, usuario, status, empresa, contato, telefone, sistema, versao, formacontato, categoria, descproblema, datainicio) 
VALUES (:idesp, :us, :sta, :empre, :cont, :tel, :sis, :versao, :for, :cat, :des, :data)") or die(mysql_error());
$sql->bindParam(":idesp", $idchamadoespera, PDO::PARAM_INT);
$sql->bindParam(":us", $usuario, PDO::PARAM_STR, 500);
$sql->bindParam(":sta", $status, PDO::PARAM_STR, 500);
$sql->bindParam(":empre", $empresa, PDO::PARAM_STR, 500);
$sql->bindParam(":cont", $contato, PDO::PARAM_STR, 500);
$sql->bindParam(":tel", $telefone, PDO::PARAM_STR, 500);
$sql->bindParam(":sis", $sistema, PDO::PARAM_STR, 500);
$sql ->bindParam(":versao", $versao, PDO::PARAM_STR, 500);
$sql->bindParam(":for", $formacontato, PDO::PARAM_STR, 500);
$sql->bindParam(":cat", $categoria, PDO::PARAM_STR, 500);
$sql->bindParam(":des", $descproblema, PDO::PARAM_STR, 500);
$sql->bindParam(":data", $datainicio, PDO::PARAM_STR, 500);
$sql->execute();
echo '<script> redireciona() </script>'
?>
</body>
</html>
