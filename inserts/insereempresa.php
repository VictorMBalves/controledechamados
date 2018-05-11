<!DOCTYPE html>
<html>
  <head>
    <script>
      function redireciona(){
        alert("Empresa cadastrada!");
        window.location.assign("../pages/empresa.php");
      }
    </script>
  </head>
</html>
<?php 
require_once '../include/Database.class.php';
$db = Database::conexao();

$empresa=$_POST['empresa'];
$cnpj=$_POST['cnpj'];
$situacao=$_POST['situacao'];
$telefone=$_POST['telefone'];
$celular=$_POST['celular'];
$backup=$_POST['backup'];
$sql = $db->prepare("INSERT INTO empresa (nome, cnpj, situacao, telefone, celular, backup) VALUES ('$empresa','$cnpj','$situacao','$telefone','$celular','$backup')") or die(mysql_error());
$sql->execute();
echo '<script> redireciona() </script>'
?>
</body>
</html>
