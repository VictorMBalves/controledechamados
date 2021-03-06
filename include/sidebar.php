<ul class="navbar-nav bg-gradient-chamados sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <img src="../imagem/favicon-2.png">
        </div>
        <div class="sidebar-brand-text mx-3">CHAMADOS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <?php 
      if($_SESSION['UsuarioNivel'] != 1) {
        echo '<li class="nav-item" id="liHome">';
        echo '  <a class="nav-link" href="../pages/home">';
        echo '  <i class="fas fa-fw fa-home"></i>';
        echo '<span>HOME</span></a>';
        echo '</li>';
      }
    ?>

    <?php
      if($_SESSION['UsuarioNivel'] == 2) { 
        echo '<li class="nav-item" id="liDash">
                <a class="nav-link" href="../pages/dashBoard">
                <i class="fas fa-tachometer-alt"></i>
                <span>DASHBOARD</span></a>
              </li>';
      }elseif($_SESSION['UsuarioNivel'] == 3){
        echo '<li class="nav-item" id="liDash">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDash" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-tachometer-alt"></i>
          <span>DASHBOARDS</span>
        </a>
        <div id="collapseDash" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="../pages/dashBoard">
                <i class="fas fa-tachometer-alt"></i>
                <span>DASHBOARD</span></a>
                <hr class="sidebar-divider">
        <a class="collapse-item" href="../pages/dashBoard2">
              <i class="fas fa-chart-bar"></i>
              <span>GERENCIAL</span></a>
          </div>
        </div>
      </li>';
      }
?>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
  Interface
</div> -->

    <?php 
    if($_SESSION['UsuarioNivel'] == 3) {
      echo '<li class="nav-item" id="liCadastros">';
      echo '  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCadastros" aria-expanded="true" aria-controls="collapseCadastros">';
      echo '    <i class="fas fa-edit"></i>';
      echo '    <span>CADASTROS</span>';
      echo '  </a>';
      echo '  <div id="collapseCadastros" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">';
      echo '    <div class="bg-white py-2 collapse-inner rounded">';
      echo '      <h6 class="collapse-header">CADASTRAR:</h6>';
      echo '      <a class="collapse-item" href="categorias">CATEGORIAS</a>';
      echo '      <a class="collapse-item" href="../pages/cad_usuario">USUÁRIOS</a>';
      echo '    </div>';
      echo '  </div>';
      echo '</li>';
    }
  ?>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item" id="liChamados">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fas fa-plus"></i>
            <span>CHAMADO</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">LANÇAR:</h6>
                <?php 
                  if($_SESSION['UsuarioNivel'] != 1) {
                    echo '<a class="collapse-item" href="#" id="adcChamado">CHAMADO</a>';
                  }
                ?>
                <a class="collapse-item" href="#" id="adcChamadoEspera">CHAMADO EM ESPERA</a>
                <?php 
                  if($_SESSION['UsuarioNivel'] != 1) {
                    echo '<h6 class="collapse-header">CONSULTA:</h6>';
                    echo '<a class="collapse-item" href="chamados">CHAMADO</a>';
                  }
                ?>
            </div>
        </div>
    </li>

    <?php 
        if($_SESSION['UsuarioNivel'] != 1) {
          echo '<li class="nav-item" id="liRegistroErros">';
          echo '  <a class="nav-link" href="../pages/dashException">';
          echo '  <i class="fab fa-fw fa-stack-overflow"></i>';
          echo '<span>REGISTRO DE ERROS</span></a>';
          echo '</li>';
        }
    ?>

    <!-- Nav Item - Relatórios Collapse Menu -->
    <?php
    if($_SESSION['UsuarioNivel'] != 1 && $_SESSION['UsuarioNivel'] != 4) { 
      echo'<li class="nav-item" id="liRelatorio">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
              <i class="far fa-fw fa-chart-bar"></i>
              <span>RELATÓRIOS</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">USUÁRIO:</h6>
                <a class="collapse-item" href="../pages/relatorio">CHAMADOS POR ATENDENTE</a>
                <h6 class="collapse-header">EMPRESAS:</h6>
                <a class="collapse-item" href="dadosempresasapi">DADOS EMP. API</a>
                <a class="collapse-item" href="empresasinertes">DADOS EMP. INERTES API</a>
                <a class="collapse-item" href="relatorioempre">EMPRESAS SOLICITANTES</a>
                <a class="collapse-item" href="#" id="registroAtividadeEcf">REGISTRO DE ATIVIDADES ECF</a>
              </div>
            </div>
          </li>';
      }
  ?>

    <!-- <li class="nav-item" id="liClientes">
    <a class="nav-link" href="../pages/empresa">
      <i class="far fa-fw fa-building"></i>
      <span>Clientes</span></a>
  </li> -->
    <?php
    if($_SESSION['UsuarioNivel'] != 1) { 
    echo'  <li class="nav-item" id="liPlantao">
              <a class="nav-link" href="../pages/plantao">
                <i class="fas fa-fw fa-first-aid"></i>
                <span>PLANTÃO</span></a>
            </li>';
    }
  ?>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <div id="usuarios"></div>

</ul>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>