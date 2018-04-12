<?php
    if (!isset($_SESSION)) {
        session_start();
    }

if (!isset($_SESSION['UsuarioID'])) {
    session_destroy();

    header("Location: index.php");
    exit;
}
$email = md5($_SESSION['Email']);

        include 'include/dbconf.php';
        $conn->exec('SET CHARACTER SET utf8');
        $sql = $conn->prepare("SELECT nome, email, disponivel FROM usuarios WHERE nivel = 2");
        $sql->execute();
        $result = $sql->fetchall();
        echo '<ul class="list-group">';
        echo '<li style="background-color:#222;color:white;" class="list-group-item"><div>Lista de Atendentes</div></li>';
                foreach ($result as $row) {
                    if ($row > 1) {
                        echo '<li class="list-group-item" style="padding:5px;"><img src="https://www.gravatar.com/avatar/'.md5($row['email']).'" width="25px"> ';
                        echo $row['nome'];
                        if ($row['disponivel']) {
                            echo'<em style="color:#d9534f;"> - Em atendimento</em>';
                        } else {
                            echo'<em style="color:#5cb85c;"> - Disponível</em>';
                        }
                        
                        echo'</li>';
                    }
                }
            echo '</ul>';
 ?>       
