<?php include '../validacoes/verificaSession.php'?>
<!Doctype html>
<html>
    <head>
        <title>Controle de chamados</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="../imagem/favicon.ico" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="../datatables/datatables.min.css">
        <link rel="stylesheet" href="../datatables/responsive.dataTables.min.css" >
        <link rel="stylesheet" href="../datatables/rowReorder.dataTables.min.css" >
        <link href="../assets/css/toastr.css" rel="stylesheet"/>
        <style>
            div.dt-buttons {
                float: right;
                margin-left:10px;
            }
        </style>
    </head>
    <body>
        <?php include '../include/menu.php'; ?>
        <div class="container-fluid" style="margin-top:60px; margin-bottom:50px;">
            <h3>Empresas inertes</h3>
            <div class="form-inline" id="filtros">
                <div class="form-group">
                    <label for="Situação">Situação:</label>
                        <select id="situacao" type="text" class="form-control">
                            <option>Todas</option>
                            <option>Bloqueada</option>
                            <option>Sem acessar</option>
                        </select>
                </div>
                <div class="form-group">
                    <label for="versão">Versão a partir de:</label>
                        <input id="versao" type="text" name="versao" class="form-control" placeholder="Ex: 4.40.0">
                </div>
                <div class="form-group">
                    <input type="checkbox" id="ignorePhoneNull" data-toggle="tooltip" data-placement="top" title="Ignorar empresas sem telefone">
                </div>
                <div class="form-group">
                    <button id="buscar" name="buscar" class="btn btn-group-lg btn-primary" data-toggle="tooltip" data-placement="top" title="Busca na API conforme a versão informada">Buscar</button>
                    <button id="refresh" type="reset" class="btn btn-group-lg btn-success" data-toggle="tooltip" data-placement="top" title="Recria a tabela com os filtros informados"><span class="glyphicon glyphicon-refresh"></span></button>
                </div>
            </div> 
            <div id="resultadobusca"></div>
            <div class="row">
                <hr>
            </div>
            <table id="tabela" class="table table-responsive table-hover">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Situação</th>
                        <th>Telefone</th>
                        <th>Versão</th>
                        <th>Sistema</th>
                    </tr>
                    <tbody id ="tbody">
                    </tbody>
                </thead>
                <div class="col-sm-12 text-center" id="loading"></div>
            </table>
        </div>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="../assets/js/toastr.min.js"></script>
        <script src="../assets/js/jquery.maskedinput.min.js"></script>
		<script src="../js/links.js"></script>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../datatables/datatables.min.js"></script>
        <script src="../datatables/responsive.min.js"></script>
        <script src="../datatables/rowReorder.min.js"></script>
        <script src="../js/tabelas/dadosempresainerteapi.js"></script>
    </body>
</html>
