
<?php 
  require_once '../include/Database.class.php';
  include '../validacoes/verificaSession.php';
  $db = Database::conexao();

  $nome=$_POST['nome'];
  $usuario=$_POST['usuario'];
  $senha=$_POST['senha'];
  $email=$_POST['email'];
  $nivel=$_POST['nivel'];
  $enviarEmail=$_POST['enviarEmail'];
  $ativo= "1";
  $data= date("Y-m-d H:i:s");
  $sql = $db->prepare("INSERT INTO usuarios (nome, usuario, senha, email, nivel, ativo, cadastro, enviarEmail) 
  VALUES ('$nome','$usuario',SHA1('$senha'),'$email','$nivel','$ativo','$data','$enviarEmail')") or die(mysql_error());
  try
  {
    $sql->execute();
    echo 'success';
    exit;
  }
  catch (PDOException $e)
  {
    echo $e->getMessage();
    exit;
  }
?>
