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
        alert("Histórico adicionado!");
        window.location.assign("home.php");
      }
      function redireciona2(){
        alert("Histórico adicionado!");
        window.location.assign("chamadoespera.php");
      }
    </script>
  </head>
</html>
<?php 
    include 'include/dbconf.php';
    $status = "Entrado em contato";
    $historico = $_POST['historico'];
    $id = $_POST['id_chamadoespera']; 
    echo $historico, $id;
    $sql = $conn->prepare("UPDATE chamadoespera SET historico='$historico', status='$status' WHERE id_chamadoespera='$id'") or die(mysql_error());
    $sql->execute();

        if($_SESSION['UsuarioNivel'] != 1){
            echo '<script> redireciona() </script>';
            }
       else{
          echo '<script> redireciona2() </script>';
       }    
?>