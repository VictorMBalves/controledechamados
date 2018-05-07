<?php
include '../include/dbconf.php';
$conn->exec('SET CHARACTER SET utf8');
$sql = $conn->prepare("SELECT nome, email, disponivel FROM usuarios WHERE nivel = 2");
$sql->execute();
$result = $sql->fetchall();
echo '<ul class="list-group">';
echo '<li style="background-color:#222; color:white;" class="list-group-item">';
    echo 'Lista de Atendentes';
echo '</li>';
foreach ($result as $row) {
    if ($row > 1) {
        $usuario = $row['nome'];
        $sql = $conn->prepare("SELECT count(id_chamado) as numeroChamados FROM chamado WHERE usuario = '$usuario' AND status = 'Aberto'");
        $sql->execute();
        $result = $sql->fetch();
        echo '<li class="list-group-item" style="padding:5px;"><img src="https://www.gravatar.com/avatar/' . md5($row['email']) . '" width="25px"> ';
        echo $usuario;
        if ($row['disponivel']) {
            echo '<em style="color:#d9534f;"> - ';if($result['numeroChamados'] == 1){echo $result['numeroChamados']. " chamado";  }else{echo $result['numeroChamados']. " chamados";} echo ' em atendimento </em>';
        } else {
            echo '<em style="color:#5cb85c;"> - Disponível</em>';
        }

        echo '</li>';
    }
}
echo '</ul>';


