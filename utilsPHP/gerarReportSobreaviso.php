<?php
include '../validacoes/verificaSession.php';
require_once '../vendor/autoload.php';
require_once '../include/Database.class.php';
$db = Database::conexao();       
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);

$verificadorData = date_format(date_create('2000-01-01'), 'd/m/Y');
$data1 = $_POST['data1'];
$data2 = $_POST['data2'];
$usuario = $_SESSION['UsuarioNome'];

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

$query = $db->prepare("select * from
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
        if (formatarData($dataplantao) == $feriado->date && ($feriado->type_code == 1 || $feriado->name == 'Corpus Christi')) {
            $datas[$i]['descricao'] = $feriado->name;
            $datas[$i]['isFeriado'] = true;
            $datas[$i]['horas'] = $datas[$i]['isFeriado'] ? '14:00:00' : '05:27:00';
        }
    }

    $query = $db->prepare("SELECT id_plantao, empresa, contato, descsolucao, descproblema, data, horainicio, horafim FROM plantao where data = '$dataplantao' and usuario = '$usuario' ORDER BY data asc");
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

ob_start();

    echo '<div class="row">';
    echo    '<div class="text-center">';
    echo        '<div class="row">';
    echo            '<h2>';
    echo                '<center>Relatório de sobreaviso</center>';
	echo            '</h2>';
    echo        '</div>';
    echo    '</div>';
	echo '</div>';
	echo '<div class="text-center">';
	echo    '<center><small>Relatório referente ao período de <strong>'.formatarData($data1).'</strong> á <strong>'.formatarData($data2).'</strong></small><center>';
    echo '</div>';
    echo '<div class="row">';
    echo    '<hr>';
    echo '</div>';
	echo '<table class="table table-bordered">
                <tr>
                    <th style="padding: 5px;">ID</th>
                    <th style="padding: 5px;">Data</th>
                    <th style="padding: 5px;">Empresa</th>
                    <th style="padding: 5px;">Contato</th>
                    <th style="padding: 5px;">Horário ínicio</th>
                    <th style="padding: 5px;">Horário término</th>
                    <th style="padding: 5px;">Desc. Problema</th>
                    <th style="padding: 5px;">Desc. Solução</th>
                </tr>
	            <tbody>';
                $sql = "SELECT id_plantao, empresa, contato, descsolucao, descproblema, data, horainicio, horafim FROM plantao where data BETWEEN '$data1' and '$data2' and usuario = '$usuario' ORDER BY data asc";
                $query = $db->prepare($sql);
                $query->execute();
                $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resultado as $key => $dados) {
                    echo '<tr style="padding: 5px;">';
                    echo '<td style="padding: 5px;">' . $dados['id_plantao'] . '</td>';
                    echo '<td style="padding: 5px;">';
                    echo formatarData($dados['data']);
                    echo '</td>';
                    echo '<td style="padding: 5px;">' . $dados['empresa'] . '</td>';
                    echo '<td style="padding: 5px;">' . $dados['contato'] . '</td>';
                    echo '<td style="padding: 5px;">';
                    echo $dados['horainicio'] . ':00';
                    echo '</td>';
                    echo '<td style="padding: 5px;">';
                    echo $dados['horafim'] . ':00';
                    echo '</td>';
                    echo '<td style="padding: 5px;">' . $dados['descproblema'] . '</td>';
                    echo '<td style="padding: 5px;">' . $dados['descsolucao']. '</td>';
                    echo '</tr>';
                }
    echo    '</tbody>
        </table>
        <div class="row">
            <hr/>
        </div>
        <div class="row">
            <div>
                <table class="table table-bordered">
                    <tr>
                        <th style="padding: 5px;">Data</th>
                        <th style="padding: 5px;">Horas Sobreaviso</th>
                        <th style="padding: 5px;">Horas Extras</th>
                    </tr>
                    <tbody>';
                    foreach ($datas as $data) {
                        echo '<tr>';
                        echo '<td style="padding: 5px;">' . formatarData($data['data']);
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
                        echo '<td style="padding: 5px;">' . $data['horas'] . '</td>';
                        echo '<td style="padding: 5px;">' . $data['duracao'] . '</td>';
                        echo '</tr>';
                    }
                        echo '<tr>
                        <th style="padding: 5px;">TOTAL SOBREAVISO</th>
                        <th style="padding: 5px;">';
                        $resultadoTotal = '00:00:00';
                        foreach ($datas as $data) {
                            $resultadoTotal = sum_the_time($data['horas'], $resultadoTotal);
                        }
                        echo $resultadoTotal;
                        echo'</th>
                        <th></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div width="500px">
                <table class="table table-hover">
                    <tr>
                        <th>Segunda à Sexta Feira: 12:01 às 13:29 e 18:01 às 22:00. Sábados, domingos e feriados: 08:00 às 22:00.</th>
                    </tr>
                    <tr>
                        <td>TOTAL DIARIO SEGUNDA A SEXTA</td>
                        <th>05:27:00</th>
                    </tr>
                    <tr>
                        <td>SABÁDO</td>
                        <th>14:00:00</th>
                    </tr>
                    <tr>
                        <td>DOMINGO</td>
                        <th>14:00:00</th>
                    </tr>
                    <tr>
                        <td>TOTAL SEMANA</td>
                        <th>51:14:00</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="text-center">
            <div class="row">
                <br>
                <br>
                <br>
                <div style="margin-left:35%; width:30%;">
                    <hr style="color:black;border-color:black;"/>
                </div>
                <h5>
                    '.$_SESSION['UsuarioNome'].'
                </h5>
            </div>
        </div>';
try {
    $html = ob_get_contents();
    ob_end_clean();
    $mpdf->SetTitle("Sobreaviso");
    $mpdf->SetHTMLFooter('
            <table width="100%">
                <tr>
                    <td width="33%">{DATE j/m/Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;"><img src="../imagem/favicon-0.png"> Controle de chamados</td>
                </tr>
            </table>');
    $stylesheet = file_get_contents('../assets/css/bootstrap.min.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($html, 2);
    // Write some HTML code:
    $dire = '../tmp/';
    $filename = 'sobreaviso.pdf';
    $mpdf->Output($dire.$filename, 'F');

    if (file_exists($dire.$filename)) {
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename);
        readfile($dire.$filename);
    }
    unlink($dire.$filename);
} catch (Exception $e) {
    echo $e;
}
?>