<!DOCTYPE html>
<html>
  <head>
    <script>
      function redireciona(){
        alert("Atendimento Editado!");
        window.location.assign("chamados.php");
      }
    </script>
  </head>
</html>
<?php 
include 'include/dbconf.php';
$conn->exec('SET CHARACTER SET utf8');
$id=$_POST['id_chamado'];
$empresa=$_POST['empresa'];
$contato=$_POST['contato'];
$telefone=$_POST['telefone'];
$modulo=$_POST['modulo'];
$formacontato=$_POST['formacontato'];
$categoria=$_POST['categoria'];
$descproblema=$_POST['descproblema'];
$backup=$_POST['backup'];
$sql = $conn->prepare("UPDATE empresa set backup = '$backup' where nome='$empresa'") or die(mysql_error());
$sql->execute();
$sql = $conn->prepare("UPDATE chamado SET  contato='$contato', telefone='$telefone', modulo='$modulo', formacontato='$formacontato', descproblema='$descproblema', categoria='$categoria'  WHERE id_chamado='$id'")
or die(mysql_error());
$sql->execute();
echo '<script> redireciona() </script>'
?>
</body>
</html>
