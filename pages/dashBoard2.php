<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();
    $sql = $db->prepare('SELECT id, nome, nivel, disponivel FROM usuarios');
    $sql->execute();
    $usuarios = $sql->fetchall(PDO::FETCH_ASSOC);
    $data_incio = date('Y-m-d');
    $data_fim = date('Y-m-d');

    $sql = $db->prepare("SELECT * FROM categoria order by descricao");
    $sql->execute();
    $categorias = $sql->fetchall(PDO::FETCH_ASSOC);
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
    <link href="../datatables/datatables.min.css" rel="stylesheet">
    <link href="../datatables/responsive.dataTables.min.css" rel="stylesheet">
    <link href="../datatables/rowReorder.dataTables.min.css" rel="stylesheet">
    <style>
    .chart {
        width: 100%;
        min-height: 450px;
    }

    .dataTables_wrapper {
        width: 100%;
    }

    .google-visualization-table-tr-even,
    .google-visualization-table-tr-odd {
        cursor: pointer;
    }

    #chart_categoria_qtd g g g rect,
    #chart_categoria_qtd g g g rect {
        cursor: pointer
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
                            <div class="card shadow">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample"
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                    data-toggle="collapse" role="button" aria-expanded="true"
                                    aria-controls="collapseCardExample">
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                        <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6" style="text-align: right">
                                        <button class="btn btn-primary btn-sm" id="btnDia">Dia</button>
                                        <button class="btn btn-primary btn-sm" id="btnOntem">Ontem</button>
                                        <button class="btn btn-primary btn-sm" id="btnSemana">Semana</button>
                                        <button class="btn btn-primary btn-sm" id="btnMes">Mês</button>
                                    </div>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse" id="collapseCardExample">
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
                                                <div class="form-group col-md-2">
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
                                                <div class="form-group col-md-2">
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
                                                <div class="form-group col-md-3">
                                                    <label for="cnpj">Empresa</label>
                                                    <input name="cnpj" type="text" class="form-control flexdatalist"
                                                        placeholder="Empresa" id="empresafiltro">
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <br>
                                                    <a id="btnFiltrar" class="btn btn-primary"
                                                        style="margin-top: 7px; color: white !important">Filtrar</a>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="categoria">Categoria</label> <input type="checkbox" id="exceto" name="exceto" value="exceto" data-toggle="tooltip" data-placement="top" title="Diferente de"><br>
                                                    <select name="categoria" data-placeholder=" " multiple id="categoria" type="text" class="form-control chosen-select">
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <div class="form-row">
                                                
                                            </div> -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="chamados" class="row animated fadeInRight" style="margin-top: 10px">
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4" style="padding-bottom:5px; cursor: pointer;" id="cardConcluido">
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
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"
                                                            id="qtdConcluido">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <div class="mb-0 font-weight-bold text-gray-800"
                                                            id="mediaConcluido">
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
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4" style="padding-bottom:5px; cursor: pointer;" id="cardConcluidoAtrasado" >
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
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"
                                                            id="qtdConcluidoForaPrazo">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <div class="mb-0 font-weight-bold text-gray-800"
                                                            id="mediaConcluidoForaPrazo">
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
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4" style="padding-bottom:5px;">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px;">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    <h6>TEMPO MÉDIO DE ATENDIMENTO</h6>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"
                                                            id="tempoMedioAtendimento">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-clock fa-2x text-gray-600"></i>
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
                                    <div class="col-9 col-sm-9 col-md-9 col-lg-9">
                                        <div class="m-0 font-weight-bold"><span class="text-primary">Ranking por
                                                categorias </span><br />
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <select name="filtroTipoRanking" type="text" id="filtroTipoRanking"
                                            class="form-control chosen-select">
                                            <option value="Quantidade">Quantidade
                                            </option>
                                            <option value="Tempo">Tempo
                                            </option>

                                        </select>
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

                    <div class="row" id="rowTableChamados"
                        style="margin-top: 10px !important; display: none; font-size: 12px;">
                        <!--TABELA CHAMADOS-->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="card shadow">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <div class="m-0 font-weight-bold"><span class="text-primary"
                                            id="textTabela1"></span>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row">
                                        <table style="width:100%"
                                            class="table table-striped table-bordered table-hover table-ranking">
                                            <thead>
                                                <tr>
                                                    <td style="width:5%">Número</td>
                                                    <td style="width:20%">Empresa</td>
                                                    <td style="width:10%">Solicitante</td>
                                                    <td style="width:13%">Sistema</td>
                                                    <td style="width:7%">Atendente</td>
                                                    <td style="width:25%">Descrição</td>
                                                    <td style="width:12%">Data Inicío</td>
                                                    <td style="width:8%">Duração</td>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody style="width:100%" id="tbody_ranking">

                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/TABELA CHAMADOS-->
                    </div>

                    <div class="row" style="margin-top: 10px !important;">
                        <!--RANKING POR ATENDENTE-->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="card shadow">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <div class="col-9 col-sm-9 col-md-9 col-lg-9">
                                        <div class="m-0 font-weight-bold"><span class="text-primary">Ranking por
                                                atendentes</span><br />
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <select name="filtroTipoRankingAtendente" type="text"
                                            id="filtroTipoRankingAtendente" class="form-control chosen-select">
                                            <option value="Quantidade">Quantidade
                                            </option>
                                            <option value="Tempo">Tempo
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                            <div id="chart_atendentes_qtd" style="height: 250px"></div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                            <div id="chart_atendentes_categoria" style="height: 250px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/RANKING POR ATENDENTE-->
                    </div>

                    <div class="row" id="rowTableChamadosAtendente"
                        style="margin-top: 10px !important; display: none; font-size: 12px;">
                        <!--TABELA CHAMADOS ATENDENTE-->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="card shadow">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <div class="m-0 font-weight-bold"><span class="text-primary"
                                            id="textTabela2"></span>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row">
                                        <table style="width:100%"
                                            class="table table-striped table-bordered table-hover table-ranking-atendente">
                                            <thead>
                                                <tr>
                                                    <td style="width:5%">Número</td>
                                                    <td style="width:20%">Empresa</td>
                                                    <td style="width:10%">Solicitante</td>
                                                    <td style="width:13%">Sistema</td>
                                                    <td style="width:7%">Atendente</td>
                                                    <td style="width:25%">Descrição</td>
                                                    <td style="width:12%">Data Inicío</td>
                                                    <td style="width:8%">Duração</td>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody style="width:100%" id="tbody_ranking">

                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/TABELA CHAMADOS-->
                    </div>

                    <div class="row" style="margin-top: 10px !important;">
                        <!--QUANTIDADE POR HORA-->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="card shadow">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <div class="m-0 font-weight-bold"><span class="text-primary">Quantidade de chamados
                                            por hora</span><br />
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div id="chart_qtd_chamados_hora" style="height: 250px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/QUANTIDADE POR HORA-->
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
    <script src="../datatables/jquery.dataTables.min.js"></script>
    <script src="../datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../datatables/responsive.min.js"></script>
    <script src="../datatables/rowReorder.min.js"></script>
    <script src="../js/links.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="../js/dashboard2.js"></script>
</body>

</html>