<?php
  header("Content-Type: text/html; charset=UTF-8");
  include('../include/db.php');

  $user = filter_input(INPUT_GET, 'usuario');
  if ($user == '') {
      echo '<p class="text-warning text-left"><small>Preencha o campo <strong>LOGIN</strong>!</small></p>';
  } else {
      $sql = "SELECT * FROM `usuarios` WHERE `usuario` = '{$user}'";
      $query = $conn->query($sql);
      if ($query->num_rows > 0) {
          echo '<p class="text-danger text-left"><small>Usuário <strong>'.$user.'</strong> já cadastrado!</small></p>';
      } else {
          echo '<p class="text-success text-left"><small>Usuário <strong>'.$user.'</strong> disponivel</small></p>';
      }
  }
