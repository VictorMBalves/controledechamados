<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <?php
            if(basename($_SERVER['PHP_SELF']) == "home.php"){
            echo'    <li class="nav-item align-middle">
                    <a class="nav-link" id="showAvisos" data-toggle="collapse" href="#avisos" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fas fa-comment"></i>
                    </a>
                </li>';
            }?>
        <!--notificações-->
        <?php include '../utilsPHP/notifica.php'?>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['UsuarioNome']?></span>
                <img class="img-profile rounded-circle" src="<?php echo 'https://www.gravatar.com/avatar/'.$email?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="../pages/meuschamados">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Meus chamados
                </a>
                <a class="dropdown-item" href="../pages/alterasenha">
                    <i class="fas fa-unlock fa-sm fa-fw mr-2 text-gray-400"></i>
                    Alterar dados
                </a>
                <i class=""></i>
                <?php if($_SESSION['UsuarioNivel'] == 3) { 
                    echo '<a class="dropdown-item" href="../pages/cad_usuario">
                            <i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400"></i>
                            Usuários
                            </a>';
                    }
                ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>

</nav>

  <!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pronto pra sair?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Selecione "Logout" se deseja encerar a sessão atual.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="../utilsPHP/logout">Logout</a>
            </div>
        </div>
    </div>
</div>