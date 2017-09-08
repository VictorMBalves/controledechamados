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
$contato=$_POST['contato'];
$telefone=$_POST['telefone'];
$modulo=$_POST['modulo'];
$versao=$_POST['versao'];
$formacontato=$_POST['formacontato'];
$categoria=$_POST['categoria'];
$descproblema=$_POST['descproblema'];
$sql = $conn->prepare("UPDATE chamado SET  contato='$contato', telefone='$telefone', modulo='$modulo', versao='$versao', formacontato='$formacontato', descproblema='$descproblema', categoria='$categoria'  WHERE id_chamado='$id'") 
or die(mysql_error());
$sql->execute();
echo '<script> redireciona() </script>'      
?>
</body>
</html>
