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
        window.location.assign("../pages/cad_usuario.php");
      }
    </script>
  </head>
</html>
<?php

require_once '../include/Database.class.php';
$db = Database::conexao();

$id=$_POST['id'];
$nome=$_POST['nome'];
$usuario=$_POST['usuario'];
$email=$_POST['email'];
$senha=$_POST['senha'];
$nivel=$_POST['nivel'];

$pass =SHA1($senha);

$sql = $db->prepare("UPDATE usuarios SET nome='$nome', usuario='$usuario', email='$email', senha='$pass', nivel='$nivel' WHERE id='$id'") or die(mysql_error());
$sql->execute();
echo '<script> redireciona() </script>'
?>
</body>
</html>
