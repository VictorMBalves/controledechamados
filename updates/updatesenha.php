<!Doctype html>
<html>
    <head>
        <script>
            function erro(){
                alert('Acesso negado! Redirecinando a pagina principal.');
                window.location.assign("../chamado_usuario.php");
                }
        </script>
    </head>
</html>
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
    alert("Senha alterada com sucesso!");
         window.location.assign("../pages/home.php");
    
}
</script>
</head>
</html>

<?php 
require_once '../include/Database.class.php';
$db = Database::conexao();

$senha=$_POST['senha'];
$idusuario=$_SESSION['UsuarioID'];

$sql = $db->prepare("UPDATE usuarios SET senha=sha1('$senha') WHERE id='$idusuario'")
or die(mysql_error());
$sql->execute();
   echo '<script> redireciona() </script>'
?>

</body>
</html>