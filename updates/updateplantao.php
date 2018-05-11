<!DOCTYPE html>
<html>
  <head>
    <script>
      function redireciona(){
        alert("Atendimento Editado!");
        window.location.assign("../plantao.php");
      }
    </script>
  </head>
</html>
<?php 
require_once '../include/Database.class.php';
$db = Database::conexao();

$id=$_POST['id_plantao'];
$contato=$_POST['contato'];
$telefone=$_POST['telefone'];
$sistema=$_POST['sistema'];
$versao=$_POST['versao'];
$formacontato=$_POST['formacontato'];
$categoria=$_POST['categoria'];
$descproblema=str_replace("'","''",$_POST['descproblema']);
$backup=$_POST['backup'];
$sql = $db->prepare("UPDATE empresa set backup = '$backup' where nome='$empresa'") or die(mysql_error());
$sql->execute();
$sql = $db->prepare("UPDATE plantao SET  contato='$contato', telefone='$telefone', sistema='$sistema', versao='$versao', formacontato='$formacontato', descproblema='$descproblema', categoria='$categoria'  WHERE id_plantao='$id'")
or die(mysql_error());
$sql->execute();
echo '<script> redireciona() </script>'
?>
</body>
</html>
