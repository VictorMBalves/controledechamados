<!DOCTYPE html>
<html>
  <head>
    <script>
      function redireciona(){
        alert("Usuario cadastrado!");
        window.location.assign("../pages/cad_usuario.php");
      }
    </script>
  </head>
</html>
<?php 
require_once '../include/Database.class.php';
$db = Database::conexao();

$nome=$_POST['nome'];
$usuario=$_POST['usuario'];
$senha=$_POST['senha'];
$email=$_POST['email'];
$nivel=$_POST['nivel'];
$ativo= "1";
$data= date("Y-m-d H:i:s");
$sql = $db->prepare("INSERT INTO usuarios (nome, usuario, senha, email, nivel, ativo, cadastro) 
VALUES ('$nome','$usuario',SHA1('$senha'),'$email','$nivel','$ativo','$data')") or die(mysql_error());
$sql->execute();
echo '<script> redireciona() </script>'
?>
</body>
</html>
