<?php
  header("Content-Type: text/html; charset=UTF-8");
  include('../include/db.php');

  $bloqueio = $_GET['bloqueio'];
  if (!isset($bloqueio)) {
      echo '<div class="alert alert-danger" role="alert">
                <center>Não configurado</center>
            </div>';
  } else {
      if ($bloqueio == "true") {
          echo '<div class="alert alert-danger" role="alert">
                    <center>Empresa bloqueada</center>
                </div>';
      } else{
        echo '<div class="alert alert-success" role="alert">
                <center>Novo chamado:</center>
            </div>';
      }
  }