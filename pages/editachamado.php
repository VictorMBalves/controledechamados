<?php
  include '../validacoes/verificaSession.php';
  require_once '../include/Database.class.php';
  require_once '../include/Permissao.class.php';
  $db = Database::conexao();
  $id=$_GET['id_chamado'];
  $sql = $db->prepare("SELECT * FROM chamado WHERE id_chamado=$id");
  $sql->execute();
  $row = $sql->fetch(PDO::FETCH_ASSOC);
  if($row['status'] == 'Finalizado'){
		echo "<h1>Chamado Nº{$id} já encerrado<h1>";
	return;
  }
  $empresa = $row['empresa'];
  $sql2 = $db->prepare("SELECT backup FROM empresa WHERE nome = '$empresa'");
  $sql2->execute();
  $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
?>
<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Controle de chamados German Tech">
		<meta name="author" content="Victor Alves">
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<title>Chamados</title>
		<!-- Custom fonts for this template-->
		<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<!-- Custom styles for this template-->
		<link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
		<!--Toastr notification-->
		<link href="../assets/css/toastr.css" rel="stylesheet"/>
		<link href="../assets/css/animate.css" rel="stylesheet"/>
	</head>

	<body>
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
            <h1 class="h3 mb-0 text-gray-800">Editar chamado Nº <?php echo $id;?> </h1>
           	<div id="plantao"></div>
          </div>
		  <div  class="card">
			<div class="card-body animated fadeInRight" style="background-color:#f4f4f4;">
				<div class="form-horizontal">
					<input style="display:none;" name="id_chamado" id="id_chamado" value="<?php echo $id; ?>"/>
					<div class="row">
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="empresa">Empresa solicitante:</label>
							<input value='<?php echo $row['empresa'];?>' id="empresa" name="empresa" type="text" class="form-control disabled" disabled>
						</div>
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="contato">Contato:</label>
							<input value='<?php echo $row['contato'];?>' id="contato" name="contato" type="text" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="formacontato">Forma de contato:</label>
							<select name="formacontato" type="text" id="formaContato" class="form-control">
								<option>
									<?php echo $row['formacontato'];?>
								</option>
								<option></option>
								<option value="Cliente ligou">Cliente ligou
								</option>
								<option value="Ligado para o cliente">Ligado para o cliente
								</option>
								<option value="Whatsapp">Whatsapp
								</option>
								<option value="Team Viewer">Team Viewer
								</option>
								<option value="Skype">Skype
								</option>
							</select>
						</div>
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="telefone">Telefone</label>
							<input value='<?php echo $row['telefone'];?>' id="telefone" data-mask="(999)9999-9999" name="telefone" type="text" class="form-control label2"
								onkeypress="return SomenteNumero(event)" required="">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="versao">Versão:</label>
							<input type="text" id="versao" name="versao" class="form-control" required="" value="<?php echo $row['versao'] ?>">
						</div>
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="sistema">Sistema:</label>
							<select name="sistema" type="text" id="sistema" class="form-control" required="">
								<option>
									<?php echo $row['sistema'];?>
								</option>
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
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
						<label for="backup">Backup:</label>
							<select id="backup" name="backup" class="form-control" required="">
									<?php 
										if ($row2['backup'] == 0) {
											echo "<option value='0'>Google drive não configurado</option>";
										} else {
											echo "<option value='1'>Google drive configurado</option>";
										}
									?>
								<option>
								</option>
								<option value="1">Google drive configurado
								</option>
								<option value="0">Google drive não configurado
								</option>
							</select>
						</div>
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
						<label for="categoria">Categoria:</label>
							<select name="categoria" id="categoria" type="text" class="form-control forma" required="">
								<option>
									<?php echo $row['categoria'];?>
								</option>
								<option></option>
								<option value="Erro">Erro
								</option>
								<option value="Duvida">Duvida
								</option>
								<option value="Atualização sistema">Atualização sistema
								</option>
								<option value="Sugestão de melhoria">Sugestão de melhoria
								</option>
								<option value="Retorno">Retorno</option>
								<option value="Outros">Outros
								</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="descproblema">Descrição do problema:</label>
						<textarea name="descproblema" id="descproblema" type="text" class="form-control label1" required=""><?php echo $row['descproblema'];?></textarea>
					</div>
					<div class="col-md-12 text-center">
						<button id="submit" name="singlebutton" class="btn btn-group-lg btn-primary">Alterar</button>
						<button id="cancel" type="reset" name="singlebutton" class="btn btn-group-lg btn-warning">Cancelar</button>
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

		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<!-- <script src="../vendor/jquery/jquery.min.js"></script> -->
		<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- Core plugin JavaScript-->
		<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
		<!-- Custom scripts for all pages-->
		<script src="../assets/js/sb-admin-2.min.js"></script>
		<!-- <script src="../vendor/chart.js/Chart.min.js"></script> -->
		<script src="../assets/js/jquery.shortcuts.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../js/links.js"></script>
		<script src="../js/editaChamado.js"></script>
	</body>

</html>
