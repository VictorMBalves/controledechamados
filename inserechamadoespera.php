<?php
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID'])) {
// Destrói a sessão por segurança
session_destroy();
// Redireciona o visitante de volta pro login
header("Location: index.php"); exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <script>
      function redireciona(){
        alert("Atendimento Registrado!");
        window.location.assign("home.php");
      }
      function redireciona2(){
        alert("Atendimento Registrado!");
        window.location.assign("chamadoespera.php");
      }
    </script>
  </head>
</html>
<?php 
include 'include/dbconf.php';
$conn->exec('SET CHARACTER SET utf8');
$data = date("Y-m-d H:i:s");
$status = "Aguardando Retorno";
$empresa=$_POST['empresa'];
$contato=$_POST['contato'];
$telefone=$_POST['telefone'];
$descproblema=$_POST['descproblema'];
$enderecado = $_POST['enderecado'];
$usuario=$_SESSION['UsuarioNome'];
$sql = $conn->prepare("INSERT INTO chamadoespera (usuario, status, empresa, contato, telefone, descproblema, data, enderecado) 
VALUES ('$usuario', '$status', '$empresa', '$contato', '$telefone', '$descproblema', '$data', '$enderecado')") or die(mysql_error());
$sql->execute();
if($_SESSION['UsuarioNivel'] == 2){
echo '<script> redireciona() </script>';
}
else{
  echo '<script> redireciona2() </script>';
}    
?>