<!DOCTYPE html>
<html>
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
		<link href="../datatables/datatables.min.css" rel="stylesheet">
    	<link href="../datatables/responsive.dataTables.min.css" rel="stylesheet">
    	<link href="../datatables/rowReorder.dataTables.min.css" rel="stylesheet">
		<link href="../assets/css/jquery-ui.css" rel="stylesheet">
		<link href="../assets/css/toastr.css" rel="stylesheet"/>
		<link href="../assets/css/animate.css" rel="stylesheet"/>
		<link href="../assets/css/style.css" rel="stylesheet"/>
		<link href="../assets/css/jquery.flexdatalist.css" rel="stylesheet" />
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
                        <h1 class="h3 mb-0 text-gray-800">Categorias</h1>
                        <div id="plantao"></div>
                    </div>
                	<div class="row">
                        <div class="col-md-6 col-sm-6 col-lg-6 sidebar-outer" stile="border-left:2px solid black;">
                            <table id="tabela" class="table table-hover" style="width:100%;">
                                <thead>
                                    <tr>
										<th>id</th>
                                        <th>categoria</th>
                                        <th>descrição</th>
                                    </tr>
                                <tbody id ="tbody">
                                </tbody> 
                            </table>
                            <div class="col-sm-12 text-center" id="loading"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="card" style="background-color:#f4f4f4;">
                                <div class="card-body animated fadeInRight" id="card">
									<div class="form-group">
										<label for="descricao">Id</label>
										<input type="text" class="form-control col-4 col-md-4 col-lg-4 disabled" readonly id="categoria_id" name="categoria_id">
									</div>
                                    <div class="form-group">
                                        <label for="categoria">Categoria</label>
                                        <select type="text" class="form-control" id="categoria">
                                            <option value="ERROS">ERROS</option>
                                            <option value="DÚVIDAS">DÚVIDAS</option>
                                            <option value="OUTROS">OUTROS</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="descricao">Descrição</label>
                                        <input type="text" class="form-control" id="descricao">
                                    </div>
                                    <div class="form-group col-sm-12 col-md-12 col-lg-12 text-right">
										<button id="novo" class="btn btn-group-lg btn-primary">Novo</button>
                                        <button id="salvar" class="btn btn-group-lg btn-success">Salvar</button>
										<button id="excluir" class="btn btn-group-lg btn-danger disabled">Excluir</button>
                                    </div>
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
		
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
		<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="../assets/jquery-easing/jquery.easing.min.js"></script>
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
        <script src="../js/tabelas/categorias.js"></script>
	</body>
</html>