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
        alert("Cadastro Alterado!");
        window.location.assign("../pages/empresa.php");
      }
    </script>
  </head>
</html>
<?php 
require_once '../include/Database.class.php';
$db = Database::conexao();

$id=$_POST['id_empresa'];
$empresa=$_POST['empresa'];
$cnpj=$_POST['cnpj'];
$situacao=$_POST['situacao'];
$telefone=$_POST['telefone'];
$celular=$_POST['celular'];
$backup = $_POST['backup'];
$sql = $db->prepare("UPDATE empresa SET nome='$empresa', cnpj='$cnpj', situacao='$situacao', telefone='$telefone', celular='$celular', backup='$backup' WHERE id_empresa='$id'") or die(mysql_error());
$sql->execute();
echo '<script> redireciona() </script>'
?>
</body>
</html>
