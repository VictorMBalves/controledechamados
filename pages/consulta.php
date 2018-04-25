<?php
    include '../validacoes/verificaSession.php';
    include '../include/dbconf.php';
    $conn->exec('SET CHARACTER SET utf8');
    $id=$_GET['id_chamado'];
    $sql = $conn->prepare("SELECT * FROM chamado WHERE id_chamado=$id");
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $empresa = $row['empresa'];
    $sql2 = $conn->prepare("SELECT backup FROM empresa WHERE nome = '$empresa'");
    $sql2->execute();
    $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
?>

<!Doctype html>
<html>
    <head>
		<title>Controle de Chamados</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html;charset=utf-8" /> 
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
	</head>

    <body>
        <?php include '../include/menu.php'; ?>
        <div class="container" style="margin-top:60px; margin-bottom:50px;">
            <?php include '../include/cabecalho.php'; ?>
            <div class="alert alert-success" role="alert">
                <center>Consulta Chamado Nº:
                    <?php echo $id?>
                </center>
            </div>
            <form class="form-horizontal" action="chamados.php" method="POST">
                <div class="form-group">
                    <label class="col-md-2 control-label">Empresa solicitante:</label>
                    <div class="col-sm-10">
                        <input value='<?php echo $row['empresa'];?>'name="empresa" type="text" disabled class="form-control disabled" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="contato">Contato:</label>
                    <div class="col-sm-10">
                        <input value='<?php echo $row['contato'];?>' id="nome" name="contato" type="text" disabled class="form-control disabled"
                            required/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="formacontato">Forma de contato:</label>
                    <div class=col-sm-4>
                        <select name="formacontato" class="form-control disabled" disabled>
                            <option>
                                <?php echo $row['formacontato'];?>
                            </option>
                        </select>
                    </div>
                    <label class="col-md-2 control-label" for="versao">Versão:</label>
                    <div class="col-sm-4">
                        <input type="text" name="versao" class="form-control disabled" value="<?php echo $row['versao']?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="cep">Telefone:</label>
                    <div class="col-sm-4">
                        <input value='<?php echo $row['telefone'];?>' disabled name="telefone" type="text" class="form-control disabled" onkeypress="return SomenteNumero(event)">
                    </div>
                    <label class="col-md-2 control-label">Sistema:</label>
                    <div class="col-sm-4">
                        <select name="sistema" class="form-control forma disabled" disabled>
                            <option>
                                <?php  echo $row['sistema'];?>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="backup">Backup:</label>
                    <div class="col-sm-4">
                        <select name="backup" class="form-control label2 disabled" disabled="">
                            <option>
                                <?php 
                                    if ($row2['backup'] == 0) {
                                        echo "Google drive não configurado";
                                    } else {
                                        echo "Google drive configurado";
                                    }
                                ?>
                            </option>
                        </select>
                    </div>
                    <label class="col-md-2 control-label">Categoria:</label>
                    <div class="col-sm-4">
                        <select name="categoria" disabled class="form-control forma disabled">
                            <option value="Manager">
                                <?php  echo $row['categoria'];?>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Data inicio: </label>
                    <div class="col-sm-4">
                        <input class="form-control disabled" disabled value='<?php echo $row['datainicio']?>'>
                    </div>
                    <label class="col-md-2 control-label">Data término:</label>
                    <div class="col-sm-4">
                        <input class="form-control forma disabled" disabled value='<?php echo $row['datafinal']?>'>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Responsavel:</label>
                    <div class="col-sm-10">
                        <input class="form-control label1 disabled" disabled value='<?php echo $row['usuario']?>'>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Descrição do problema:</label>
                    <div class="col-sm-10">
                        <textarea name="descproblema" class="form-control disabled" disabled><?php echo $row['descproblema'];?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Solução:</label>
                    <div class="col-sm-10">
                        <textarea name="descsolucao" class="form-control disabled" disabled><?php echo $row['descsolucao'];?></textarea>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button id="singlebutton" name="singlebutton" class="btn btn-group-lg btn-primary">Retornar</button>
                </div>
            </form>
        </div>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="../js/links.js"></script>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script>
            function erro() {
                alert('Acesso negado! Redirecinando a pagina principal.');
                window.location.assign("chamadoespera.php");
            }
        </script>
    </body>
</html>