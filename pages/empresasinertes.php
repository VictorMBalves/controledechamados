<?php include '../validacoes/verificaSession.php'?>
<!Doctype html>
<html>
    <head>
        <title>Chamados</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Controle de chamados German Tech">
		<meta name="author" content="Victor Alves">
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
		<link href="../datatables/datatables.min.css" rel="stylesheet">
    	<link href="../datatables/responsive.dataTables.min.css" rel="stylesheet">
    	<link href="../datatables/rowReorder.dataTables.min.css" rel="stylesheet">
		<link href="../assets/css/jquery-ui.css" rel="stylesheet">
		<link href="../assets/css/toastr.css" rel="stylesheet"/>
		<link href="../assets/css/animate.css" rel="stylesheet"/>
        <link href="../assets/css/style.css" rel="stylesheet"/>
		<link href="../assets/css/jquery.flexdatalist.css" rel="stylesheet" />
        <style>
            table {
                overflow-x: auto;
                width: 100%; /* Optional */
                border-collapse:collapse;
                white-space: nowrap; 
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
                        <h1 class="h3 mb-0 text-gray-800">Empresas inertes API</h1>
                        <div id="plantao"></div>
                    </div>
                    <div  class="card" style="margin:15px;padding:5px; background-color:#f4f4f4;">
                        <div class="card-header" style="border-bottom:none;"data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Filtros	
                        </div>
                        <div class="collapse" id="collapseExample">
                            <div class="card-body animated fadeInRight">
                                <div class="row" id="filtros">
                                    <div class="form-group col-12 col-sm-2 com-md-2 col-lg-2">
                                        <label for="Situação">Situação:</label>
                                            <select id="situacao" type="text" class="form-control">
                                                <option>Todas</option>
                                                <option>Bloqueada</option>
                                                <option>Ativo</option>
                                            </select>
                                    </div>
                                    <div class="form-group col-12 col-sm-2 com-md-2 col-lg-2">
                                        <label for="versão">Versão a partir de:</label>
                                            <input id="versao" type="text" name="versao" class="form-control" placeholder="Ex: 4.40.0">
                                    </div>
                                    <div class="row col-12 col-sm-2 com-md-2 col-lg-2" style="margin-left:5px;">
                                        <div class="form-group  col-12 col-sm-12 com-md-12 col-lg-12">
                                            <input type="checkbox" class="form-check-input" id="ignoreBlocked" data-toggle="tooltip" data-placement="top" title="Ignorar empresas bloqueadas">
                                            <label for="ignoreBlocked" class="form-check-label" >Ignorar empresas bloqueadas</label>
                                        </div>
                                        <div class="form-group  col-12 col-sm-12 com-md-12 col-lg-12">
                                            <input type="checkbox" class="form-check-input" id="ignorePhoneNull">
                                            <label for="ignorePhoneNull" class="form-check-label" >Ignorar empresas sem telefone</label>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button id="buscar" name="buscar" class="btn btn-group-lg btn-primary" data-toggle="tooltip" data-placement="top" title="Busca na API conforme a versão informada">Buscar</button>
                                        <button id="refresh" type="reset" class="btn btn-group-lg btn-success" data-toggle="tooltip" data-placement="top" title="Recria a tabela com os filtros informados"><i class="fas fa-sync-alt"></i></button>
                                        <!-- <button id="gerarReport" type="reset" class="btn btn-group-lg btn-success" data-toggle="tooltip" data-placement="top" title="Gera relatório detalhado">Gerar relatório</button> -->
                                    </div>
                                </div> 
                                <div id="resultadobusca"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
                    <div class="animated fadeInRight">
                        <table id="tabela" class="table table-responsive table-hover">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Empresa</th>
                                    <th>CNPJ</th>
                                    <th>Cidade</th>
                                    <th>Estado</th>
                                    <th>Situação</th>
                                    <th>Responsável</th>
                                    <th>Telefone</th>
                                    <th>Telefone 2</th>
                                    <th>Celular</th>
                                    <th>Versão</th>
                                    <th>Sistema</th>
                                    <th>Mensalidade</th>
                                    <th>Dias sem acessar o sistema</th>
                                </tr>
                                <tbody id ="tbody">
                                </tbody>
                            </thead>
                            <div class="col-sm-12 text-center" id="loading"></div>
                        </table>
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
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
		<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
		<script src="../assets/js/sb-admin-2.min.js"></script>
		<script src="../assets/js/jquery.shortcuts.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../js/links.js"></script>
		<script src="../datatables/jquery.dataTables.min.js"></script>
		<script src="../datatables/dataTables.bootstrap4.min.js"></script>
		<script src="../datatables/responsive.min.js"></script>
		<script src="../datatables/rowReorder.min.js"></script>
		<script src="../assets/js/jquery.flexdatalist.js"></script>	
        <script src="../js/tabelas/dadosempresainerteapi.js"></script>
        <script src="../js/gerarReportEmpInertes.js"></script>
    </body>
</html>




