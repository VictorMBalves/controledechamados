<!Doctype html>
<html>
	<head>
		<title>Controle de chamados</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link href="../css/utils.css" rel="stylesheet">
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link rel="stylesheet" href="../assets/css/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link href="../datatables/datatables.min.css" rel="stylesheet">
    	<link href="../datatables/responsive.dataTables.min.css" rel="stylesheet">
    	<link href="../datatables/rowReorder.dataTables.min.css" rel="stylesheet">
		<link href="../assets/css/toastr.css" rel="stylesheet"/>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.0/themes/prism.min.css">
    </head>
	
    <body>
		<div class="wrapper">
			<?php
				include '../validacoes/verificaSession.php';
				include '../include/menu.php';
			?>
			<div class="content col-lg-12">
				<div class="col-md-6 col-sm-6 col-lg-6 sidebar-outer" stile="border-left:2px solid black;">
					<h1>Registro de exceções ECF</h1>
                    <table id="tabela" class="table table-responsive table-hover">
						<thead>
							<tr>
								<th>Empresa</th>
								<th>Motivo</th>
								<th>Data</th>
							</tr>
						<tbody id ="tbody">
						</tbody> 
					</table>
					<div class="col-sm-12 text-center" id="loading"></div>
				</div>
				<div class="col-md-6">
                    <div>
						<input type="text" class="form-control" id="error_task_id" style="display:none;">
                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                            <label for="company">Empresa</label>
                            <input type="text" class="form-control" id="company" disabled>
                        </div>
						<div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label for="responsible">Cliente</label>
                            <input type="text" class="form-control" id="responsible" disabled>
                        </div>
						<div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label for="phone">Telefone</label>
                            <input type="text" class="form-control" id="phone" disabled>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                            <label for="message_error">Mensagem de erro</label>
                            <input type="text" class="form-control" id="message_error" disabled>
                        </div>
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label for="reason">Motivo</label>
                            <input type="text" class="form-control" id="reason" disabled>
                        </div>
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label for="date_erro">Data</label>
                            <input type="text" class="form-control" id="date_erro" disabled>
                        </div>
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label for="system">Sistema</label>
                            <input type="text" class="form-control" id="system" disabled>
                        </div>
                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                            <label for="last_version">Versão atual</label>
                            <input type="text" class="form-control" id="last_version" disabled>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                            <label for="log">Log</label>
                            <pre style="max-height:200px !important;">
                                <code class="language-java" id="log">
                                </code>
                            </pre>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-12 text-right">
                            <button id="createCall" class="btn btn-group-lg btn-primary">Criar chamado em espera</button>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		<div id="modalConsulta">
		</div>
		<div id="modalCadastro">
		</div>

		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../js/md5.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../assets/js/jquery.shortcuts.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../datatables/datatables.min.js"></script>
		<script src="../datatables/responsive.min.js"></script>
		<script src="../datatables/rowReorder.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../js/links.js"></script>
		<script src="../js/tabelas/dashException.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.0/prism.min.js"></script>
	</body>
</html>