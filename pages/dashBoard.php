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
                        <div class="col-sm-4 col-lg-4 col-xs-4 col-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">totalizador</div>
                                <div class="panel-body">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8 col-lg-8 col-xs-8 col-8">
                            <div id="chart_div" style="width: 900px; height: 500px;"></div>
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
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawVisualization);

            function drawVisualization() {
                var jsonData = $.ajax({
                    url: "loadPeriodoChart.php",
                    dataType: "json",
                    async: false
                    }).responseText;

                console.log(jsonData)
                console.log($.parseJSON(jsonData))

                var data = google.visualization.arrayToDataTable($.parseJSON(jsonData));
                var options = {
                    title: 'Chamados por atendente',
                    // subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                    vAxis: {title: 'Nº de chamados'},
                    hAxis: {title: 'Data'},
                    seriesType: 'bars',
                    animation:{
                        duration: 1000,
                        easing: 'out',
                    },
                    crosshair: { focused: { color: '#3bc', opacity: 0.8 } }
                    // series: {5: {type: 'line'}}
                };

               var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
               chart.draw(data, options);
            }
        </script>
	</body>
</html>