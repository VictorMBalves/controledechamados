<?php
    $day = date('w');
    $week_start = date('Y-m-d', strtotime('-'.$day.' days'));
    $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
?>
<!Doctype html>
<html>
	<head>
		<title>Controle de chamados</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link href="../assets/css/ladda.css" rel="stylesheet"/>
		<link href="../css/utils.css" rel="stylesheet">
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<link rel="stylesheet" href="../assets/css/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link href="../assets/css/toastr.css" rel="stylesheet"/>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	</head>
	<body>
		<div class="wrapper">
			<?php
				include '../validacoes/verificaSession.php';
				include '../include/menu.php';
			?>
			<div class="content col-lg-12 ">
                
				<div class="panel panel-default">
                    <div class="panel-heading">Gráficos</div>
                    <div class="panel-body">
                        <div class="col-sm-6 col-lg-6 col-xs-6 col-6">
                            <form id="form1" class="form-horizontal">
                                <h4>Chamados atendidos na semana por atendente</h4>
                                <hr/>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="dtInicial1">Data inicial</label>
                                    <div id="dtInicial1-div" class="col-sm-3">
                                        <input id="dtInicial1" name="dtInicial1" type="date" class="form-control" value="<?php echo $week_start?>">
                                    </div>
                                    <label class="col-md-2 control-label" for="dtFinal1">Data final</label>
                                    <div id="dtFinal1-div" class="col-sm-3">
                                        <input id="dtFinal1" name="dtFinal1" type="date" class="form-control" value="<?php echo $week_end?>">
                                    </div>
                                    <button onclick="drawVisualization()" class="btn btn-success" data-style="zoom-out" data-size="s">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </div>
                                <hr/>
                                <div class="col-sm-12 col-lg-12 col-xs-12 col-12" id="chart_div" style="height:500px;"></div>
                            </form>
                        </div>
                        <div class="col-sm-6 col-lg-6 col-xs-6 col-6">
                            <form id="form2" class="form-horizontal">
                                <h4>Chamados atendidos na semana por categoria</h4>
                                <hr/>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="dtInicial2">Data inicial</label>
                                    <div id="dtInicial2-div" class="col-sm-3">
                                        <input id="dtInicial2" name="dtInicial2" type="date" class="form-control" value="<?php echo $week_start?>">
                                    </div>
                                    <label class="col-md-2 control-label" for="dtFinal2">Data final</label>
                                    <div id="dtFinal2-div" class="col-sm-3">
                                        <input id="dtFinal2" name="dtFinal2" type="date" class="form-control" value="<?php echo $week_end?>">
                                    </div>
                                    <button onclick="drawVisualization2()" class="btn btn-success" data-style="zoom-out" data-size="s"><span class="glyphicon glyphicon-search"></span></button>
                                </div>
                                <hr/>
                                <div id="chart_div2" style="height:500px;"></div>
                            </form>
                        </div>
                    </div>
                </div>
			</div>
		</div>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="../assets/js/date.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../assets/js/jquery.shortcuts.js"></script>
		<script src="../assets/js/toastr.min.js"></script>
		<script src="../js/links.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="../assets/js/ladda/spin.min.js"></script>
        <script type="text/javascript" src="../assets/js/ladda/ladda.min.js"></script>
        <script type="text/javascript">

            $( document ).ready(function() {
                Ladda.bind( 'button', { timeout: 3000 } );
            });
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawVisualization);
            google.charts.setOnLoadCallback(drawVisualization2);

            function drawVisualization() {
                event.preventDefault();
                var dados = $('#form1').serialize();
                var jsonData = $.ajax({
                    url: "loadPeriodoAtendenteChart.php",
                    dataType: "json",
                    data: dados,
                    async: false
                    }).responseText;

                if($.parseJSON(jsonData).length <= 1){
                    notificationWarningOne("Nenhum registro no período informado")
                    return;
                }

                var data = google.visualization.arrayToDataTable($.parseJSON(jsonData));

                var options = {
                    title: 'Chamados atendidos na semana por atendente',
                    chartArea: {width: '50%'},
                    lineWidth: 1,
                    bar: {groupWidth: "90%"},
                    hAxis: {
                        title: 'Nº de chamados atendidos',
                        minValue: 0,
                        textStyle: {
                            bold: true,
                            fontSize: 12,
                            color: '#4d4d4d'
                        },
                        titleTextStyle: {
                            bold: true,
                            fontSize: 18,
                            color: '#4d4d4d'
                        },
                    },
                    vAxis: {
                        title: 'Dia',
                        textStyle: {
                            fontSize: 14,
                            bold: true,
                            color: '#848484'
                        },
                        titleTextStyle: {
                            fontSize: 14,
                            bold: true,
                            color: '#848484'
                        }
                    },
                    // theme: 'material'
                };
                var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                chart.draw(data, options);
                notificationSuccess("Sucesso", "Gráfico gerado com sucesso")
                return false;
            }

                function drawVisualization2() {
                    event.preventDefault();
                    var dados = $('#form2').serialize();
                    var jsonData = $.ajax({
                        url: "loadPeriodoCategoriaChart.php",
                        dataType: "json",
                        data:dados,
                        async: false
                        }).responseText;

                    if($.parseJSON(jsonData).length <= 1){
                        notificationWarningOne("Nenhum registro no período informado")
                        return;
                    }

                    var data = google.visualization.arrayToDataTable($.parseJSON(jsonData));

                    var options = {
                        title: 'Chamados atendidos na semana por categoria',
                        chartArea: {width: '50%'},
                        bar: {groupWidth: "90%"},
                        lineWidth: 1,
                        hAxis: {
                            title: 'Nº de chamados atendidos',
                            minValue: 0,
                            textStyle: {
                                bold: true,
                                fontSize: 12,
                                color: '#4d4d4d'
                            },
                            titleTextStyle: {
                                bold: true,
                                fontSize: 18,
                                color: '#4d4d4d'
                            }
                        },
                        vAxis: {
                            title: 'Dia',
                            textStyle: {
                                fontSize: 14,
                                bold: true,
                                color: '#848484'
                            },
                            titleTextStyle: {
                                fontSize: 14,
                                bold: true,
                                color: '#848484'
                            }
                        },
                        // theme: 'material'
                    };
                    var chart = new google.visualization.BarChart(document.getElementById('chart_div2'));
                    chart.draw(data, options);
                    notificationSuccess("Sucesso", "Gráfico gerado com sucesso")
                    return false;
                }
        </script>
	</body>
</html>