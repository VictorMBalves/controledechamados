<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $sql = $db->prepare('SELECT id, nome, nivel, disponivel FROM usuarios');
    $sql->execute();
    $usuarios = $sql->fetchall(PDO::FETCH_ASSOC);
    $data_incio = date('Y-m-d', mktime(0, 0, 0, date('m') , 1 , date('Y')));
    $data_fim = date('Y-m-d',mktime(23, 59, 59, date('m'), date("t"), date('Y')));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Chamados</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Controle de chamados German Tech">
    <meta name="author" content="Alison Luis">
    <link rel="shortcut icon" href="../imagem/favicon.ico" />
    <link href="../assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../assets/css/jquery-ui.css" rel="stylesheet">
    <link href="../assets/css/toastr.css" rel="stylesheet" />
    <link href="../assets/css/animate.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href="../assets/css/jquery.flexdatalist.css" rel="stylesheet" />
    <link href="../assets/css/component-chosen.min.css" rel="stylesheet" />
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
                    </div>


                    <div class="row">
                        <!--FILTROS-->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse" id="collapseCardExample" style="">
                                    <div class="card-body">

                                        <form id="formFiltros">
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <label for="dataInicial">Data inicial </label>
                                                    <input id="dataInicial" name="dataInicial" type="date"
                                                        class="form-control mb-2 mr-sm-2"
                                                        value="<?php echo $data_incio?>">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="dataFinal">Data final </label>
                                                    <input id="dataFinal" name="dataFinal" type="date"
                                                        class="form-control mb-2 mr-sm-2"
                                                        value="<?php echo $data_fim?>">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="usuario">Usuário</label>
                                                    <select name="usuario" data-placeholder="Selecione um usuário..."
                                                        id="usuario" type="text" class="form-control chosen-select">
                                                        <option value=""></option>
                                                        <?php 
                                                            foreach ($usuarios as $row) {
                                                                echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="sistema">Sistema</label>
                                                    <select name="sistema" type="text" id="sistema"
                                                        data-placeholder="Selecione um sistema..."
                                                        class="form-control chosen-select">
                                                        <option></option>
                                                        <option value="Manager">Manager
                                                        </option>
                                                        <option value="Light">Light
                                                        </option>
                                                        <option value="Gourmet">Gourmet
                                                        </option>
                                                        <option value="Fiscal">Fiscal
                                                        </option>
                                                        <option value="Folha">Folha
                                                        </option>
                                                        <option value="Emissor">Emissor
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <br>
                                                    <a id="btnFiltrar" class="btn btn-primary"
                                                        style="margin-top: 7px; color: white !important">Filtrar</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                    <div id="chamados" class="row animated fadeInRight">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6" style="padding-bottom:5px;">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    <h6>CONCLUÍDOS</h6>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="qtdConcluido">
                                                            </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <div class="mb-0 font-weight-bold text-gray-800" id="mediaConcluido">
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-smile-beam fa-2x text-gray-600"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6" style="padding-bottom:5px;">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    <h6>CONCLUÍDAS FORA DO PRAZO</h6>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="qtdConcluidoForaPrazo">
                                                            </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <div class="mb-0 font-weight-bold text-gray-800" id="mediaConcluidoForaPrazo">
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-sad-tear fa-2x text-gray-600"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!--RANKING POR QTD-->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="card shadow">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <div class="m-0 font-weight-bold"><span class="text-primary">Ranking de categorias
                                            (Qtd.)</span><br />
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                            <div id="chart_chamados_categoria_qtd" style="height: 250px"></div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                            <div id="chart_categoria_qtd" style="height: 250px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/RANKING POR QTD-->
                    </div>

                    <div class="row" style="margin-top: 10px !important">
                        <!--RANKING POR TEMPO-->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="card shadow">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <div class="m-0 font-weight-bold"><span class="text-primary">Ranking de categorias
                                            (Tempo)</span><br />
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                            <div id="chart_chamados_categoria_tempo" style="height: 250px"></div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                            <div id="chart_categoria_tempo" style="height: 250px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/RANKING POR TEMPO-->
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
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js">
    </script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js">
    </script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/jquery-easing/jquery.easing.min.js"></script>
    <script src="../assets/js/sb-admin-2.min.js"></script>
    <script src="../assets/js/jquery.flexdatalist.js"></script>
    <script src="../assets/js/jquery.shortcuts.js"></script>
    <script src="../assets/js/toastr.min.js"></script>
    <script src="../assets/js/date.js"></script>
    <script src="../assets/js/chosen.jquery.min.js"></script>
    <script src="../js/links.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="../js/dashboard2.js"></script>
</body>

</html>