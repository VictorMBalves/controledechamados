<?php
    $day = date('w');
    $week_start = date('Y-m-d', strtotime('-'.$day.' days'));
    $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
    $dataEng = date('Y-m-d');
    $data = date('d/m/Y');
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
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
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
                                <?php //include 'chamadospendentes.php';?>
                            </div>
                            <!--Chamados pendentes-->

                            <!--Chamados ATRASADOS -->
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
                                <div id="atrasados"></div>
                                <?php //include 'chamadosatrasados.php'; ?>
                            <!--Chamados ATRASADOS-->
                            </div>

                            <!--Chamados AGENDADOS -->
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
                                <div id="agendados"></div>
                                <?php //include 'chamadosagendados.php'; ?>
                            </div>
                            <!--Chamados AGENDADOS -->

                            <!--Chamados EM ATENDIMENTO -->
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3" style="padding-bottom:5px;">
                                <div id="andamento"></div>
                                <?php //include 'chamadosandamento.php'; ?>
                            <!--Chamados EM ATENDIMENTO -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding:20px;">
                                <div class="card shadow">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Timeline atendimentos - <label id="dataTempoMedioAtendimento"><?php echo $data?></label></h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in text-center" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Período:</div>
                                                <form id="formTempoMedioAtendimento" class="container">
                                                    <div class="form-group">
                                                        <label  for="dtInicialTempoMedioAtendimento">Data</label>
                                                        <input id="dtInicialTempoMedioAtendimento" name="dtInicialTempoMedioAtendimento" type="date" class="form-control" value="<?php echo $dataEng?>">
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
                                        <div id="chart_div5" class="chart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding:20px;">
                                <div class="card shadow">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Chamdos por hora - <label id="dataChamadosPorHora"><?php echo $data?></label></h6>
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
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6" style="padding:20px;">
                                <div class="card shadow">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Chamados atendidos na semana por categoria</h6>
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
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6" style="padding:20px;">
                                <div class="card shadow ">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Chamados atendidos na semana por atendente</h6>
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
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6" style="padding:20px;">
                                <div class="card shadow">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Rank atendentes - <label id="dataRank"><?php echo $data?></label></h6>
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
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="../assets/js/sb-admin-2.min.js"></script>
        <script src="../assets/js/jquery.flexdatalist.js"></script>	
        <script src="../assets/js/jquery.shortcuts.js"></script>
        <script src="../assets/js/toastr.min.js"></script>
        <script src="../assets/js/date.js"></script>
        <script src="../js/links.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="../assets/js/ladda/spin.min.js"></script>
        <script type="text/javascript" src="../assets/js/ladda/ladda.min.js"></script>
        <script type="text/javascript" src="../js/dashboard.js"></script>
	</body>
</html>