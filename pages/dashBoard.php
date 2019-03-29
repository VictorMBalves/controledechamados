<?php
    $day = date('w');
    $week_start = date('Y-m-d', strtotime('-'.$day.' days'));
    $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
    $dataEng = date('Y-m-d');
    $data = date('d/m/Y');
    $semana_start = date('d/m/Y', strtotime('-'.$day.' days'));
    $semana_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <title>Chamados</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Controle de chamados German Tech">
    <meta name="author" content="Victor Alves">
    <link rel="shortcut icon" href="../imagem/favicon.ico" />
    <link href="../assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../assets/css/jquery-ui.css" rel="stylesheet">
    <link href="../assets/css/toastr.css" rel="stylesheet"/>
    <link href="../assets/css/animate.css" rel="stylesheet"/>
    <link href="../assets/css/style.css" rel="stylesheet"/>
    <link href="../assets/css/jquery.flexdatalist.css" rel="stylesheet" />
    <style>
        .chart {
            width: 100%; 
            min-height: 450px;
        }
    </style>
    </head>
    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <?php 
                include '../validacoes/verificaSession.php'; 
                include '../include/sidebar.php';
            ?>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <?php include '../include/topbar.php';?>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                            <div id="plantao"></div>
                        </div>
                        
                        <div id="chamados" class="row animated fadeInRight">
                            <!--Chamados pendentes-->
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
                                <div id="pendentes"></div>
                            </div>
                            <!--Chamados pendentes-->

                            <!--Chamados ATRASADOS -->
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
                                <div id="atrasados"></div>
                            <!--Chamados ATRASADOS-->
                            </div>

                            <!--Chamados AGENDADOS -->
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
                                <div id="agendados"></div>
                            </div>
                            <!--Chamados AGENDADOS -->

                            <!--Chamados EM ATENDIMENTO -->
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
                                <div id="andamento"></div>
                            <!--Chamados EM ATENDIMENTO -->
                            </div>
                        </div>

                        <div class="row">
                            <!--TIMELINE DE ATENDIMENTOS-->
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding:20px;">
                                <div class="card shadow">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <div class="m-0 font-weight-bold"><span class="text-primary">Timeline atendimentos</span><br/>
                                            <small><label class="mb-0" id="dataTempoMedioAtendimento"><?php echo $data?></label> à <label class="mb-0" id="dataFinalTempoMedioAtendimento"><?php echo $data?></label></small>
                                        </div>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in text-center" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Período:</div>
                                                <form id="formTempoMedioAtendimento" class="container">
                                                    <div class="form-group">
                                                        <label  for="dtInicialTempoMedioAtendimento">Data inicial</label>
                                                        <input id="dtInicialTempoMedioAtendimento" name="dtInicialTempoMedioAtendimento" type="date" class="form-control" value="<?php echo $dataEng?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label  for="dtFinalTempoMedioAtendimento">Data final</label>
                                                        <input id="dtFinalTempoMedioAtendimento" name="dtFinalTempoMedioAtendimento" type="date" class="form-control" value="<?php echo $dataEng?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label  for="tipoTempoMedioAtendimento">Agrupar por</label>
                                                        <select id="tipoTempoMedioAtendimento" name="tipoTempoMedioAtendimento" class="form-control">
                                                            <option value="1">Empresa</option>
                                                            <option value="2">Atendente</option>
                                                        </select>
                                                    </div>
                                                    <button  class="btn btn-success" id="btnTempoMedioAtendimento" data-style="zoom-out" data-size="s">Gerar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4" style="padding-bottom:10px;">
                                                <div class="card border-left-info shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><h6>Tempo médio de atendimento</h6></div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><label id="media"></label></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="far fa-clock fa-2x text-gray-600"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4" style="padding-bottom:10px;">
                                                <div class="card border-left-success shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><h6>Nº de chamados atendidos</h6></div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><label id="atendidos"></label></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="far fa-check-square fa-2x text-gray-600"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4" style="padding-bottom:10px;">
                                                <div class="card border-left-danger shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"><h6>Nº de chamados que atrasaram</h6></div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><label id="atrasaram"></label></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i id="iconatrasados" class="far fa-frown fa-2x text-gray-600"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="chart_div5" class="chart"></div>
                                    </div>
                                </div>
                            </div>
                            <!--/TIMELINE DE ATENDIMENTOS-->

                            <!--CHAMADOS POR HORA-->
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding:20px;">
                                <div class="card shadow">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <div class="m-0 font-weight-bold"><span class="text-primary">Chamados por hora</span><br/> 
                                            <small><label class="mb-0" id="dataChamadosPorHora"><?php echo $data?></label></small>
                                        </div>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in text-center" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Período:</div>
                                                <form id="formChamadosPorHora" class="container">
                                                    <div class="form-group">
                                                        <label  for="dtInicialPorHora">Data</label>
                                                        <input id="dtInicialPorHora" name="dtInicialPorHora" type="date" class="form-control" value="<?php echo $dataEng?>">
                                                    </div>
                                                    <button  class="btn btn-success" id="btnChamadosPorHora" data-style="zoom-out" data-size="s">Gerar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div id="chart_div4" class="chart"></div>
                                    </div>
                                </div>
                            </div>
                            <!--/CHAMADOS POR HORA-->

                            <!--CHAMADOS POR CATEGORIA-->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6" style="padding:20px;">
                                <div class="card shadow">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <div class="m-0 font-weight-bold"><span class="text-primary">Categorias relacionadas na semana</span><br/>
                                            <small><label class="mb-0" id="dataChamadosCategoria"><?php echo $semana_start?></label> à <label id="dataFinalChamadosCategoria"><?php echo $semana_end?></label></small>
                                        </div>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in text-center" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Período:</div>
                                                <form id="form2" class="container">
                                                    <div class="form-group">
                                                        <label  for="dtInicial2">Data inicial</label>
                                                        <input id="dtInicial2" name="dtInicial2" type="date" class="form-control" value="<?php echo $week_start?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="dtFinal2">Data final</label>
                                                        <input id="dtFinal2" name="dtFinal2" type="date" class="form-control" value="<?php echo $week_end?>">
                                                    </div>
                                                        <button class="btn btn-success" id="btnChamadoCategoria" data-style="zoom-out" data-size="s">Gerar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div id="chart_div2"  class="chart"></div>
                                    </div>
                                </div>
                            </div>
                             <!--/CHAMADOS POR CATEGORIA-->

                            <!--CHAMADOS POR ATENDENTE-->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6" style="padding:20px;">
                                <div class="card shadow ">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <div class="m-0 font-weight-bold"><span class="text-primary">Chamados atendidos na semana por atendente</span><br/>
                                        <small><label class="mb-0" id="datainicioPorAtendente"><?php echo $semana_start?></label> à <label id="dataFinalPorAtendente"><?php echo $semana_end?></label></small>
                                    </div>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in text-center" aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Período:</div>
                                            <form id="form1" class="container">
                                                <div class="form-group">
                                                    <label  for="dtInicial1">Data inicial</label>
                                                    <input id="dtInicial1" name="dtInicial1" type="date" class="form-control" value="<?php echo $week_start?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="dtFinal1">Data final</label>
                                                    <input id="dtFinal1" name="dtFinal1" type="date" class="form-control" value="<?php echo $week_end?>">
                                                </div>
                                                    <button class="btn btn-success" data-style="zoom-out" data-size="s" id="btnChamadoAtendente">Gerar</button>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div id="chart_div" class="chart"></div>
                                    </div>
                                </div>
                            </div>
                            <!--/CHAMADOS POR ATENDENTE-->
                            
                            <!--RANK POR ATENDENTE-->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6" style="padding:20px;">
                                <div class="card shadow">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <div class="m-0 font-weight-bold"><span class="text-primary">Rank atendentes</span><br/>
                                            <small><label id="dataRank"><?php echo $data?></label></small>
                                        </div>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in text-center" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Período:</div>
                                                <form id="formRankAtendentes" class="container">
                                                    <div class="form-group">
                                                        <label  for="dtInicialRank">Data</label>
                                                        <input id="dtInicialRank" name="dtInicialRank" type="date" class="form-control" value="<?php echo $dataEng?>">
                                                    </div>
                                                    <button class="btn btn-success" id="btnRankAtendentes" data-style="zoom-out" data-size="s">Gerar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div id="chart_div3" class="chart"></div>
                                    </div>
                                </div>
                            </div>
                            <!--/RANK POR ATENDENTE-->
                        </div>
                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <?php include '../include/footer.php';?>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <div id="modalConsulta">
        </div>
        <div id="modalCadastro">
        </div>
        <div id="modalAgendamento">
        </div>

        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/jquery-easing/jquery.easing.min.js"></script>
        <script src="../assets/js/sb-admin-2.min.js"></script>
        <script src="../assets/js/jquery.flexdatalist.js"></script>	
        <script src="../assets/js/jquery.shortcuts.js"></script>
        <script src="../assets/js/toastr.min.js"></script>
        <script src="../assets/js/date.js"></script>
        <script src="../js/links.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="../js/dashboard.js"></script>
	</body>
</html>