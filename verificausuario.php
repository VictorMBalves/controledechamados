<?php
  //envio o charset para evitar problemas com acentos
  header("Content-Type: text/html; charset=UTF-8");


  $mysqli = new mysqli('localhost', 'root', 'd8hj0ptr', 'chamados');

  $user = filter_input(INPUT_GET, 'usuario');
  if($user == ''){
    echo '<p class="text-warning" style="margin-left:160px;"><small>Preencha o campo <strong>LOGIN</strong>!</small></p>';
  }
  else{
  $sql = "SELECT * FROM `usuarios` WHERE `usuario` = '{$user}'"; //monto a query


  $query = $mysqli->query( $sql ); //executo a query

  if( $query->num_rows > 0 ) {//se retornar algum resultado
    echo '<p class="text-danger" style="margin-left:160px;"><small>Usuário <strong>'.$user.'</strong> já cadastrado!</small></p>';
  } else {
    echo '<p class="text-success" style="margin-left:160px;"><small>Usuário <strong>'.$user.'</strong> disponivel</small></p>';
  }
}