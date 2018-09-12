<?php include '../validacoes/verificaSession.php'?>
<!Doctype html>
<html>
    <head>
        <title>Controle de chamados</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="../imagem/favicon.ico" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <link href="../datatables/datatables.min.css" rel="stylesheet">
        <link href="../datatables/responsive.dataTables.min.css" rel="stylesheet">
        <link href="../datatables/rowReorder.dataTables.min.css" rel="stylesheet">
    </head>
    <body>
        <?php include '../include/menu.php'; ?>
        <div class="container-fluid" style="margin-top:60px; margin-bottom:50px;">
            <?php include '../include/cabecalho.php';?>
            <table id="myTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Telefone</th>
                        <th>Versão</th>
                        <th>Sistema</th>
                    </tr>
                    <tbody>
                    </tbody>
                </thead>
                <div class="col-sm-12 text-center" id="loading"></div>
            </table>
        </div>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="../assets/js/date.js"></script>
        <script src="../js/links.js"></script>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../datatables/datatables.min.js"></script>
        <script src="../datatables/responsive.min.js"></script>
        <script src="../datatables/rowReorder.min.js"></script>
        <script src="../js/tabelas/dadosempresaapi.js"></script>
    </body>
</html>
