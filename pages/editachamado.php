<?php
  include '../validacoes/verificaSession.php';
  require_once '../include/Database.class.php';
  $db = Database::conexao();
  $id=$_GET['id_chamado'];
  $sql = $db->prepare("SELECT cha.empresa,
						cha.contato,
						cha.formacontato,
						cha.telefone,
						cha.versao,
						cha.sistema,
						cha.descproblema,
						cha.descsolucao,
						cha.categoria_id
					FROM chamado cha WHERE id_chamado=$id");
  $sql->execute();
  $chamado = $sql->fetch(PDO::FETCH_ASSOC);
  if($chamado['status'] == 'Finalizado'){
		echo "<h1>Chamado Nº{$id} já encerrado<h1>";
		return;
  }

  $idCategorias = $chamado['categoria_id'];
  $categorias = [];

  if($idCategorias){
	$sql = $db->prepare("SELECT * FROM categoria WHERE id in ($idCategorias)");
  	$sql->execute();
  	$categorias = $sql->fetchall(PDO::FETCH_ASSOC);
  }
  
?>
<!Doctype html>
<html>
	<head>
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
		<link href="../assets/css/component-chosen.min.css" rel="stylesheet" />
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
            <h1 class="h3 mb-0 text-gray-800">Editar chamado Nº <?php echo $id;?> </h1>
           	<div id="plantao"></div>
          </div>
		  <div  class="card" style="background-color:#f4f4f4;">
			<div class="card-body animated fadeInRight" >
				<div class="form-horizontal">
					<input style="display:none;" name="id_chamado" id="id_chamado" value="<?php echo $id; ?>"/>
					<div class="row">
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="empresaEdit">Empresa solicitante:</label>
							<input value='<?php echo $chamado['empresa'];?>' id="empresaEdit" name="empresaEdit" type="text" class="form-control disabled" disabled>
						</div>
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="contatoEdit">Contato:</label>
							<input value='<?php echo $chamado['contato'];?>' id="contatoEdit" name="contatoEdit" type="text" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="formacontatoEdit">Forma de contato:</label>
							<select name="formacontatoEdit" type="text" id="formaContatoEdit" class="form-control">
								<option>
									<?php echo $chamado['formacontato'];?>
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
							<label for="telefoneEdit">Telefone</label>
							<input value='<?php echo $chamado['telefone'];?>' id="telefoneEdit" data-mask="(999)9999-9999" name="telefoneEdit" type="text" class="form-control label2"
								onkeypress="return SomenteNumero(event)" required="">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="versaoEdit">Versão:</label>
							<input type="text" id="versaoEdit" name="versaoEdit" class="form-control" required="" value="<?php echo $chamado['versao'] ?>">
						</div>
						<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
							<label for="sistemaEdit">Sistema:</label>
							<select name="sistemaEdit" type="text" id="sistemaEdit" class="form-control" required="">
								<option>
									<?php echo $chamado['sistema'];?>
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
					<div class="form-group">
						<label for="categoriafin">Categoria:</label>
						<select name="categoriafilter" data-placeholder=" " multiple id="categoriafilter" type="text" class="form-control chosen-select" required="">
							  <?php 
							 	foreach ($categorias as $categoria) {
									$id = $categoria['id'];
									$desc = $categoria['descricao'];
									$cat = $categoria['categoria'];
									echo "<option selected value='{$id}'>[{$cat}] {$desc} </option>";
								}
							  ?>
						</select>
					</div>
					<div class="form-group">
						<label for="descproblemaEdit">Descrição do problema:</label>
						<textarea name="descproblemaEdit" id="descproblemaEdit" type="text" class="form-control label1" required=""><?php echo $chamado['descproblema'];?></textarea>
					</div>
					<div class="col-md-12 text-center">
						<button id="alterar" name="singlebutton" class="btn btn-group-lg btn-primary">Salvar</button>
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
  	<div id="modalCadastro">
	</div>
	<div id="modalCadastroEspera">
    </div>

		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
		<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="../assets/jquery-easing/jquery.easing.min.js"></script>
		<script src="../assets/js/sb-admin-2.min.js"></script>
		<script src="../assets/js/jquery.flexdatalist.js"></script>	
		<script src="../assets/js/jquery.shortcuts.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../assets/js/chosen.jquery.min.js"></script>
		<script src="../js/links.js"></script>
		<script src="../js/editaChamado.js"></script>
	</body>

</html>
