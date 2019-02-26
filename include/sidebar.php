<ul class="navbar-nav bg-gradient-chamados sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
  <div class="sidebar-brand-icon">
    <img src="../imagem/favicon-2.png"> 
  </div>
  <div class="sidebar-brand-text mx-3">Chamados</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item" id="liHome">
  <a class="nav-link" href="../pages/home">
    <i class="fas fa-fw fa-home"></i>
    <span>Home</span></a>
</li>
<?php
if($_SESSION['UsuarioNivel'] != 1 && $_SESSION['UsuarioNivel'] != 4) { 
  echo '<li class="nav-item" id="liDashboard">
    <a class="nav-link" href="../pages/dashBoard">
    <i class="fas fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
  </li>';
}
?>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<!-- <div class="sidebar-heading">
  Interface
</div> -->

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item" id="liChamados">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fas fa-plus"></i>
      <span>Chamado</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Adicionar novo:</h6>
        <a class="collapse-item" href="#" id="adcChamado">Chamado</a>
        <a class="collapse-item" href="chamadoespera">Chamado em espera</a>
        <?php 
          if($_SESSION['UsuarioNivel'] != 1) {
            echo '<h6 class="collapse-header">Consulta:</h6>';
            echo '<a class="collapse-item" href="chamados">Chamados</a>';
          }
        ?>
      </div>
    </div>
  </li>

  <!-- Nav Item - -->
  <li class="nav-item" id="liRegistroErros">
    <a class="nav-link" href="../pages/dashException">
      <i class="fab fa-fw fa-stack-overflow"></i>
      <span>Registro de erros</span></a>
  </li>

<!-- Nav Item - Relatórios Collapse Menu -->
  <?php
    if($_SESSION['UsuarioNivel'] != 1 && $_SESSION['UsuarioNivel'] != 4) { 
      echo'<li class="nav-item" id="liRelatorio">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
              <i class="far fa-fw fa-chart-bar"></i>
              <span>Relatórios</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Usuário:</h6>
                <a class="collapse-item" href="../pages/relatorio">Chamados por atendente</a>
                <h6 class="collapse-header">Empresas:</h6>
                <a class="collapse-item" href="dadosempresasapi">Dados emp. API</a>
                <a class="collapse-item" href="empresasinertes">Dados emp. inertes API</a>
                <a class="collapse-item" href="relatorioempre">Empresas solicitantes</a>
                <a class="collapse-item" href="#" id="registroAtividadeEcf">Registro de atividades ECF</a>
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
                <span>Plantão</span></a>
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