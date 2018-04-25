<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8" />
		<link rel="shortcut icon" href="../imagem/favicon.ico" />
		<title>Controle de Chamados German Tech</title>
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		<script src='../js/jquery.min.js'></script>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/links.js" ></script>
		<style>
		/*table, tr, td, th{
		border:1px solid black;
		}*/

		.rel {
			margin-left: 15px;
			margin-right: 15px;
		}

		th,
		td {
			padding: 5px;
			border: 0.5px solid black;
			border-left: 0px;
			border-right: 0px;
		}

		th {
			background-color: #eee;
		}

		table {
			width: 100%;
		}

		.foot {
			width: 500px;
		}

		.assin {
			float: right;
			margin-right: 150px;
			margin-top: 80px;
			width: 400px;
			weight: 150px;
		}

		</style>
	</head>
<body onload="self.print();self.close();">
<!--  -->
	<?php
	include '../validacoes/verificaSession.php';
	//CALL API DE FERIADOS
	$ano = Date('Y');
	$cidade = '4127700'; //TOLEDO-PR
	$token = 'dmljdG9ybWF0aGV1c2JvdGFzc29saUBnbWFpbC5jb20maGFzaD0yNDU1NjUxMTE';
	$url = 'https://api.calendario.com.br/?json=true&ano=' . $ano . '&ibge=' . $cidade . '&token=' . $token . '=';
	//manda o token no header

	$ch = curl_init();
	//envia a URL como parâmetro para o cURL;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get status code
	curl_close($ch);
	$feriados = json_decode($result);

	$verificadorData = date_format(date_create('2000-01-01'), 'd/m/Y');
	include '../include/dbconf.php';
	$data1 = $_POST['data1'];
	$data2 = $_POST['data2'];
	$usuario = $_SESSION['UsuarioNome'];

	$query = $conn->prepare("select * from
	(select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) data from
	(select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
	(select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
	(select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
	(select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
	(select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
	where data between '$data1' and '$data2'");
	$query->execute();
	$datas = $query->fetchall();
	for ($i = 0; $i < count($datas); $i++) {

		$datas[$i]['isFeriado'] = false;
		$datas[$i]['isDomingo'] = isDomingo($datas[$i]['data']);
		$datas[$i]['isSabado'] = isSabado($datas[$i]['data']);
		$datas[$i]['descricao'] = 'Dia util';
		$datas[$i]['duracao'] = '00:00:00';
		$datas[$i]['horas'] = isSabado($datas[$i]['data']) ? '14:00:00' : isDomingo($datas[$i]['data']) ? '14:00:00' : '05:27:00';
		$dataplantao = $datas[$i]['data'];

		foreach ($feriados as $feriado) {
			if (formatarData($dataplantao) == $feriado->date && ($feriado->type_code == 1)) {
				$datas[$i]['descricao'] = $feriado->name;
				$datas[$i]['isFeriado'] = true;
				$datas[$i]['horas'] = $datas[$i]['isFeriado'] ? '14:00:00' : '05:27:00';
			}
		}

		$query = $conn->prepare("SELECT id_plantao, empresa, contato, descsolucao, descproblema, data, horainicio, horafim FROM plantao where data = '$dataplantao' and usuario = '$usuario' ORDER BY data asc");
		$query->execute();
		$plantoes = $query->fetchall();
		foreach ($plantoes as $plantao) {
			$dataPlantao = formatarData($plantao['data']);
			$horarioInicio = new DateTime($plantao['horainicio']);
			$horarioTermino = new DateTime($plantao['horafim']);

			if ($datas[$i]['isFeriado']) {
				$datas[$i] = calcularHoras($datas[$i], $verificadorData, $dataPlantao, $horarioInicio, $horarioTermino, true, false, false);
				$verificadorData = $dataPlantao;
				continue;
			}

			if (isDomingo($datas[$i]['data'])) {
				$datas[$i] = calcularHoras($datas[$i], $verificadorData, $dataPlantao, $horarioInicio, $horarioTermino, false, true, false);
				$verificadorData = $dataPlantao;
				continue;
			}
			if (isSabado($datas[$i]['data'])) {
				$datas[$i] = calcularHoras($datas[$i], $verificadorData, $dataPlantao, $horarioInicio, $horarioTermino, false, false, true);
				$verificadorData = $dataPlantao;
				continue;
			}
			$datas[$i] = calcularHoras($datas[$i], $verificadorData, $dataPlantao, $horarioInicio, $horarioTermino, false, false, false);
			$verificadorData = $dataPlantao;
		}
	}

	function calcularHoras($datas, $verificadorData, $dataPlantao, $horarioInicio, $horarioTermino, $isFeriado, $isDomingo, $isSabado)
	{
		if ($verificadorData == $dataPlantao) {
			$duracao = $horarioInicio->diff($horarioTermino);
			$duracao = $duracao->format("%H:%I:%S");
			$datas['duracao'] = sum_the_time($datas['duracao'], $duracao);
			$duracao = date_create($duracao);
			$HORAS = date_create($datas['horas']);
			$totalHotas = $HORAS->diff($duracao);
			$totalHotas = $totalHotas->format("%H:%I:%S");
			$datas['horas'] = $totalHotas;
		} else {
			$duracao = $horarioInicio->diff($horarioTermino);
			$duracao = $duracao->format("%H:%I:%S");
			$datas['duracao'] = $duracao;
			$duracao = date_create($duracao);
			$HORAS = date_create($datas['horas']);
			$HORAS = $HORAS->diff($duracao);
			$HORAS = $HORAS->format("%H:%I:%S");
			$duracao = $duracao->format("%H:%I:%S");
			$datas['horas'] = $HORAS;
			$datas['isFeriado'] = $isFeriado;
			$datas['isDomingo'] = $isDomingo;
			$datas['isSabado'] = $isSabado;
		}
		return $datas;
	}

	function sum_the_time($time1, $time2)
	{
		$times = array($time1, $time2);
		$seconds = 0;
		foreach ($times as $time) {
			list($hour, $minute, $second) = explode(':', $time);
			$seconds += $hour * 3600;
			$seconds += $minute * 60;
			$seconds += $second;
		}
		$hours = floor($seconds / 3600);
		$seconds -= $hours * 3600;
		$minutes = floor($seconds / 60);
		$seconds -= $minutes * 60;

		$result = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
		return $result;
	}
	function isDomingo($date)
	{
		$day = date("D", strtotime($date));
		if ($day == 'Sun') {
			return true;
		} else {
			return false;
		}
	}
	function isSabado($date)
	{
		$day = date("D", strtotime($date));
		if ($day == 'Sat') {
			return true;
		} else {
			return false;
		}
	}
	function formatarData($data)
	{
		$datainicio = date_create($data);
		$dataFormatada = date_format($datainicio, 'd/m/Y');
		return $dataFormatada;
	}

	?>
	<div class="row">
	<h1>
	<div class="text-center">
	<div class="row">
	Relatório de sobreaviso:
	</div>
	</div>
	</h1>
	<br>
	</div>
	<div class="text-center">
	<h4> <p> Relatório referente ao período de <strong><?php echo formatarData($data1) ?></strong> á <strong><?php echo formatarData($data2) ?></strong> </p></h5>
	</div>
	<div class="row">
	<hr/>
	</div>
	<div class="rel text-ceter">
	<table class="table-striped">
	<tr>
	<th>ID</th>
	<th>Data</th>
	<th>Empresa</th>
	<th>Contato</th>
	<th>Horário ínicio</th>
	<th>Horário término</th>
	<th>Desc. Problema</th>
	<th>Desc. Solução</th>
	</tr>
	<tbody>
	<?php
	include '../include/db.php';
	$sql = "SELECT id_plantao, empresa, contato, descsolucao, descproblema, data, horainicio, horafim FROM plantao where data BETWEEN '$data1' and '$data2' and usuario = '$usuario' ORDER BY data asc";
	$query = $conn->query($sql);
	while ($dados = $query->fetch_object()) {
		echo '<tr>';
		echo '<td>' . $dados->id_plantao . '</td>';
		echo '<td>';
		echo formatarData($dados->data);
		echo '</td>';
		echo '<td>' . $dados->empresa . '</td>';
		echo '<td>' . $dados->contato . '</td>';
		echo '<td>';
		echo $dados->horainicio . ':00';
		echo '</td>';
		echo '<td>';
		echo $dados->horafim . ':00';
		echo '</td>';
		echo '<td>' . $dados->descproblema . '</td>';
		echo '<td>' . $dados->descsolucao . '</td>';
		echo '</tr>';
	}
	?>
	</tbody>
</table>
</div>
<div class="row">
<hr/>
</div>
<div class="align-left">
<div class="col-sm-6" style="padding:0px;">
<table class="table-striped">
<tr>
<th>Data</th>
<th>Horas Sobreaviso</th>
<th>Horas Extras</th>
</tr>
<tbody>
<?php
foreach ($datas as $data) {
    echo '<tr>';
    echo '<td>' . formatarData($data['data']);
    if ($data['isFeriado']) {
        echo ' ' . $data['descricao'];
    } else if ($data['isDomingo']) {
        echo ' Domingo';
    } else if ($data['isSabado']) {
        echo ' Sábado';
    } else {
        echo '';
    }
    '</td>';
    echo '<td>' . $data['horas'] . '</td>';
    echo '<td>' . $data['duracao'] . '</td>';
    echo '</tr>';
}
?>
</tbody>
<tr>
<th>TOTAL SOBREAVISO</th>
<th><?php
$resultadoTotal = '00:00:00';
foreach ($datas as $data) {
    $resultadoTotal = sum_the_time($data['horas'], $resultadoTotal);
}
echo $resultadoTotal;
?>
</th>
<th></th>
</tr>
</table>
</div>
</div>
<footer class="footer">
	<div class="align-left">
		<div class="col-sm-6" style="padding:0px; border-left:1px solid black;">
			<table class="table-striped">
				<tr>
					<th>Segunda à Sexta Feira: 12:01 às 13:29 e 18:01 às 22:00. Sábados, domingos e feriados: 08:00 às 22:00.</th>
				</tr>
				<tr>
					<td>TOTAL DIARIO SEGUNDA A SEXTA&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<strong>05:27:00</strong>
					</td>
				</tr>
				<tr>
					<td>SABÁDO&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<strong>14:00:00</strong>
					</td>
				</tr>
				<tr>
					<td>DOMINGO&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<strong>14:00:00</strong>
					</td>
				</tr>
				<tr>
					<td>TOTAL SEMANA&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<strong>51:14:00</strong>
					</td>
				</tr>
				<tr>
					<td>
						<center>
							<div class="assin">
								<hr style="border-color:black;" />
								<center>
									<h3>
										<?php echo $_SESSION['UsuarioNome']; ?>
									</h3>
								</center>
							</div>
						</center>
					</td>
				</tr>
			</table>
		</div>
	</div>
</footer>
</body>

</html>
