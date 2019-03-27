<?php
	include '../validacoes/verificaSession.php';
	require_once '../include/Database.class.php';
	$db = Database::conexao();
	$id = $_GET['id'];
	$sql = $db->prepare("SELECT
							cha.status,
							cha.descproblema,
							cha.descsolucao,
							cha.id_chamadoespera,
							DATE_FORMAT(cha.datainicio,'%d/%m/%Y %H:%i') as datainicio, 
							DATE_FORMAT(cha.datafinal,'%d/%m/%Y %H:%i') as datafinal,
							usu.nome as usuarionome,
							usu.email as usuarioemail,
							cha.categoria_id,
							cha.categoria
						FROM chamado cha
						INNER JOIN usuarios usu ON usu.id = cha.usuario_id 
						WHERE cha.id_chamado=$id");
	$sql->execute();
	$chamado = $sql->fetch(PDO::FETCH_ASSOC);
	if($chamado){
		if($chamado['id_chamadoespera'] != null){
			$idEspera = $chamado['id_chamadoespera'];
			$sql = $db->prepare("SELECT 
									cha.descproblema,
									DATE_FORMAT(cha.datacadastro,'%d/%m/%Y %H:%i') as data,	
									usu.nome as usuarionome,
									usu.email as usuarioemail 
								FROM chamadoespera cha
								INNER JOIN usuarios usu ON usu.id = cha.usuario_id  
								WHERE cha.id_chamadoespera=$idEspera");
			$sql->execute();
			$chamadoespera = $sql->fetch(PDO::FETCH_ASSOC);
			if($chamadoespera){
				$sql = $db->prepare("SELECT 
										his.id as id,
										his.id_chamadoespera as id_chamadoespera,
										DATE_FORMAT(his.dataregistro,'%d/%m/%Y %H:%i') as data,
										his.descricaohistorico as descricaohistorico, 
										usu.email as emailusuario, 
										usu.nome as usuario 
									FROM historicochamado his 
									INNER JOIN usuarios usu ON usu.id = his.usuario_id  
									WHERE his.id_chamadoespera = $idEspera  
									ORDER BY his.dataregistro");
				$sql->execute();
				$historicos = $sql->fetchall(PDO::FETCH_ASSOC);
			}
		}
	}
	$showTime = false;
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
    <link href="../assets/css/toastr.css" rel="stylesheet" />
    <link href="../assets/css/animate.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
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
                <div class="container-fluid collapse" style="margin-bottom:20px;" id="avisos">
                </div>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Timeline chamado Nº<?php echo $id;?></h1>
                        <div id="plantao"></div>
                    </div>
                    <?php
						if($chamadoespera){
							echo '<div class="row no-gutters">';
											echo spacer();
											echo getTimeline('bg-info');
											echo'<!-- timeline item 1 event content -->
											<div class="col-sm py-2">
													<div class="card border-info shadow animated fadeInRight">
															<div class="card-body">
																	<div class="float-right text-info small">'.$chamadoespera['data'].'</div>
																	<h4 class="card-title text-info">Abertura do chamado em espera</h4>
																	<p class="card-text"><img class="img-profile rounded-circle m-1" src="https://www.gravatar.com/avatar/'.md5($chamadoespera['usuarioemail']).'" width="30px"><strong>'.$chamadoespera['usuarionome'].'</strong> abriu o chamado em espera com <strong>descrição do problema</strong>:</p>
																	<div class="card-text ml-5">'.$chamadoespera['descproblema'].'</div>
															</div>
													</div>
											</div>
									</div>';
						}

						if($historicos){
							foreach($historicos as $historico){
								echo '<div class="row no-gutters">';
								if($showTime){
									echo spacer();
									echo getTimeline('bg-warning');
								}
								echo '<div class="col-sm py-2">';
												if($showTime){
													echo '<div class="card border-warning shadow animated fadeInRight">';
												}else{
													echo '<div class="card border-warning shadow animated fadeInLeft">';
												}
												echo'<div class="card-body">
																	<div class="float-right text-warning small">'.$historico['data'].'</div>
																	<h4 class="card-title text-warning">Histórico de contato</h4>
																	<p class="card-text"><img class="img-profile rounded-circle m-1" src="https://www.gravatar.com/avatar/'.md5($historico['emailusuario']).'" width="30px"><strong>'.$historico['usuario'].'</strong> adicionou um <strong>histórico de contato</strong>:</p>
																	<div class="card-text ml-5">'.$historico['descricaohistorico'].'</div>
															</div>
													</div>
											</div>';
								if(!$showTime){
									echo getTimeline('bg-warning');
									echo spacer();
								}
								echo '</div>';
								$showTime = !$showTime;
							}
						}

						if($chamado){
							echo '<div class="row no-gutters">';
							if($showTime){
								echo spacer();
								echo getTimeline('bg-info');
							}
							echo '<div class="col-sm py-2">';
												if($showTime){
													echo '<div class="card border-info shadow animated fadeInRight">';
												}else{
													echo '<div class="card border-info shadow animated fadeInLeft">';
												}
												echo'<div class="card-body">
															<div class="float-right text-info small">'.$chamado['datainicio'].'</div>
															<h4 class="card-title text-info">Início do atendimento</h4>
															<p class="card-text"><img class="img-profile rounded-circle m-1" src="https://www.gravatar.com/avatar/'.md5($chamado['usuarioemail']).'" width="30px"><strong>'.$chamado['usuarionome'].'</strong> iniciou o atendimento do <strong>chamado</strong>:</p>
															<div class="card-text ml-5">'.$chamado['descproblema'].'</div>
													</div>
											</div>
										</div>';
							if(!$showTime){
								echo getTimeline('bg-info');
								echo spacer();
							}
							$showTime = !$showTime;
							echo '</div>';
							if($chamado['status'] == "Finalizado"){
								echo '<div class="row no-gutters">';
								if($showTime){
									echo spacer();
									echo getTimeline('bg-success');
								}
								echo '<div class="col-sm py-2">';
											if($showTime){
												echo '<div class="card border-success shadow animated fadeInRight">';
											}else{
												echo '<div class="card border-success shadow animated fadeInLeft">';
											}
											echo'	<div class="card-body">
														<div class="float-right text-success small">'.$chamado['datafinal'].'</div>
														<h4 class="card-title text-success">Fim do atendimento</h4>
														<p class="card-text"><img class="img-profile rounded-circle m-1" src="https://www.gravatar.com/avatar/'.md5($chamado['usuarioemail']).'" width="30px"><strong>'.$chamado['usuarionome'].'</strong> finalizou o atendimento do <strong>chamado</strong>:</p>
														<div class="card-text ml-5">'.$chamado['descsolucao'].'</div>';
														if($chamado['categoria_id']){
															$idCategorias = $chamado['categoria_id'];
															$categorias = [];
															$sql = $db->prepare("SELECT * FROM categoria WHERE id in ($idCategorias)");
															$sql->execute();
															$categorias = $sql->fetchall(PDO::FETCH_ASSOC);
															echo '<div class="row m-1" data-toggle="tooltip" data-placement="bottom" title="Categorias do chamado">';
																foreach($categorias as $categoria){
																	$style = "";
																	$icon = "";
																	switch($categoria['categoria']){
																		case 'ERROS':
																			$style = "badge-danger";
																			$icon = "<i class='fas fa-bug'></i>";
																			break;
																		case 'DÚVIDAS':
																			$style = "badge-warning";
																			$icon = "<i class='fas fa-question'></i>";
																			break;
																		default:
																			$style = "badge-info";
																			$icon = "<i class='fas fa-cubes'></i>";
																			break;
																	}
																	echo '<span class="badge '.$style.' m-1 text-uppercase">'.$icon.' '.$categoria['descricao'].'</span>';
																}
																if($chamado['categoria'])
																	echo '<span class="badge badge-info m-1 text-uppercase">'.$icon.' '.$chamado['categoria'].'</span>';
															echo'</div>';
														}
											echo'	</div>
										</div>
									</div>';
								if(!$showTime){
									echo getTimeline('bg-success');
									echo spacer();
								}
								echo '</div>';
							}
						}
					?>
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
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/jquery-easing/jquery.easing.min.js"></script>
    <script src="../assets/js/sb-admin-2.min.js"></script>
    <script src="../assets/js/jquery.flexdatalist.js"></script>
    <script src="../assets/js/jquery.shortcuts.js"></script>
    <script src="../assets/js/toastr.min.js"></script>
    <script src="../assets/js/date.js"></script>
    <script src="../js/links.js"></script>
</body>

</html>

<?php 
	function getTimeline($color){
		echo '
			<!-- timeline item 1 center dot -->
			<div class="col-sm-1 text-center flex-column d-none d-sm-flex">
					<div class="row h-50">
							<div class="col border-right">&nbsp;</div>
							<div class="col">&nbsp;</div>
					</div>
					<h5 class="m-2">
							<span class="badge badge-pill '.$color.' border">&nbsp;</span>
					</h5>
					<div class="row h-50">
							<div class="col border-right">&nbsp;</div>
							<div class="col">&nbsp;</div>
					</div>
			</div>';
	}

	function spacer(){
		echo '<div class="col-sm"> <!--spacer--> </div>';
	}
?>