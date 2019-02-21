<?php
	include '../validacoes/verificaSession.php';
	require_once '../include/Database.class.php';
    $db = Database::conexao();
	$id=$_GET['id_chamado'];
	$sql = $db->prepare("SELECT * FROM chamado WHERE id_chamado = :id");
	$sql->bindParam(":id", $id, PDO::PARAM_INT);
	$sql->execute();
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	if($row['status'] == 'Finalizado'){
		echo '<h1>Chamado Nº'.$id.' já encerrado<h1>';
		return;
	}
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
<link href="../assets/css/style.css" rel="stylesheet"/>
		<link href="../assets/css/jquery.flexdatalist.css" rel="stylesheet" />
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
            <h1 class="h3 mb-0 text-gray-800">Finalizar chamado Nº <?php echo $id;?> </h1>
           	<div id="plantao"></div>
          </div>
		  <div  class="card" style="background-color:#f4f4f4;">
			<div class="card-body animated fadeInRight">
				<div class="form-horizontal">
					<input style="display:none;" name="id_chamado" id="id_chamado" value="<?php echo $id; ?>"/>
					<div class="row">
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="empresafin">Empresa solicitante:</label>
							<input value='<?php echo $row['empresa'];?>' id="empresafin" name="empresafin" type="text" class="form-control disabled" disabled>
						</div>
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="contatofin">Contato:</label>
							<input value='<?php echo $row['contato'];?>' id="contatofin" name="contatofin" type="text" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="formacontatofin">Forma de contato:</label>
							<select name="formacontatofin" type="text" id="formaContatofin" class="form-control">
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
							<label for="telefonefin">Telefone</label>
							<input value='<?php echo $row['telefone'];?>' id="telefonefin" data-mask="(999)9999-9999" name="telefonefin" type="text" class="form-control label2"
								onkeypress="return SomenteNumero(event)" required="">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="versaofin">Versão:</label>
							<input type="text" id="versaofin" name="versaofin" class="form-control" required="" value="<?php echo $row['versao'] ?>">
						</div>
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="sistemafin">Sistema:</label>
							<select name="sistemafin" type="text" id="sistemafin" class="form-control" required="">
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
						<label for="backupfin">Backup:</label>
							<select id="backupfin" name="backupfin" class="form-control" required="">
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
						<label for="categoriafin">Categoria:</label>
							<select name="categoriafin" id="categoriafin" type="text" class="form-control forma" required="">
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
						<label for="descproblemafin">Descrição do problema:</label>
						<textarea name="descproblemafin" id="descproblemafin" type="text" class="form-control label1" required=""><?php echo $row['descproblema'];?></textarea>
					</div>
					<div class="form-group">
					<label for="descsolucaofin">Solução:</label>  
						<textarea name="descsolucaofin" id="descsolucaofin" type="text" class="form-control"></textarea>
					</div>
					<div class="text-center">
						<button id="finalizar" name="finalizar" class="btn btn-group-lg btn-primary">Finalizar</button>
						<button id="cancel" type="reset" name="cancelar" class="btn btn-group-lg btn-warning">Cancelar</button>
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
  	<div id="modalCadastro">
	</div>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<!-- <script src="../vendor/jquery/jquery.min.js"></script> -->
	<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Core plugin JavaScript-->
	<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
	<!-- Custom scripts for all pages-->
	<script src="../assets/js/sb-admin-2.min.js"></script>
	<script src="../assets/js/jquery.flexdatalist.js"></script>	
	<!-- <script src="../vendor/chart.js/Chart.min.js"></script> -->
	<script src="../assets/js/jquery.shortcuts.js"></script>
	<script src="../assets/js/toastr.min.js"></script>
	<script src="../assets/js/date.js"></script>
	<script src="../js/links.js"></script>
	<script src="../js/finalizaChamadoFa.js" ></script> 
	<script>
		function Erro(){
			notificationError('Acesso restrito');
		}
	</script>
	</body>
</html>
