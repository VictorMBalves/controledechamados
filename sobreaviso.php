<!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta charset="utf-8" />
            <link rel="shortcut icon" href="imagem/favicon.ico" />
            <title>Controle de Chamados German Tech</title>
            <script src='js/jquery.min.js'></script>
            <link href="css/bootstrap.min.css" rel="stylesheet">
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/links.js" ></script>
            <style>
                /*table, tr, td, th{
                    border:1px solid black;
                }*/
                .rel{
                    margin-left:15px;
                    margin-right:15px;
                }
                th, td{
                  padding:5px;
                  border: 0.5px solid black;
                  border-left:0px;
                  border-right:0px;
                }
                th{
                    background-color:#eee;
                }
                table{
                    width:100%;
                }
                .foot{
                    width:500px;
                }
                .assin{
                    float:right;
                    margin-right:150px;
                    margin-top:80px;
                    width:400px;
                    weight:150px;
                }

            </style>
        </head>
        <body >
        <!-- onload="self.print();self.close();" -->
<?php
header("Content-type: text/html; charset=utf-8");
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) {
    session_start();
}
// Verifica se não há a variável da sessão que identifica o usuário
if ($_SESSION['UsuarioNivel'] == 1) {
    echo '<script>erro()</script>';
} else {
    if (!isset($_SESSION['UsuarioID'])) {
        // Destrói a sessão por segurança
        session_destroy();
        // Redireciona o visitante de volta pro login
        header("Location: index.php");
        exit;
    }
}
function formatarData($data)
{
    $datainicio = date_create($data);
    $dataFormatada = date_format($datainicio, 'd/m/Y');
    return $dataFormatada;
}

$email = md5($_SESSION['Email']);

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
//retorna os dados da empresa em JSON encode
//print_r("<pre>".$result."</pre>");
//return $result;

$feriados = json_decode($result);

/*
 *GLOBAIS
 */
//Verificador de data
$verificadorData = date_format(new DateTime('2000-01-01'), 'd/m/Y');
//Hora Sobreaviso
$HSA = new DateTime('05:27:00');
//Hora Extra 50% Sobreaviso
$HE50SA = new DateTime('14:00:00');
//Hora Extra 100% Sobreaviso
$HE100SA = new DateTime('14:00:00');
/////////////////////
include 'include/dbconf.php';
$data1 = $_POST['data1'];
$data2 = $_POST['data2'];
$usuario = $_SESSION['UsuarioNome'];
$query = $conn->prepare("SELECT DISTINCT data FROM plantao where data BETWEEN '$data1' and '$data2' and usuario = '$usuario' ORDER BY data desc");
$query->execute();
$datas = $query->fetchall();
$i = 0;
for($i = 0; $i < count($datas); $i++) {
    $dataplantao = $datas[$i]['data'];
    $query = $conn->prepare("SELECT id_plantao, empresa, contato, descsolucao, descproblema, data, horainicio, horafim FROM plantao where data = '$dataplantao' and usuario = '$usuario' ORDER BY id_plantao desc");
    $query->execute();
    $plantoes = $query->fetchall();
    foreach ($plantoes as $plantao) {
        $datas[$i]['isFeriado'] = false;
        $dataplan = formatarData($plantao['data']);
        foreach ($feriados as $feriado) {
          if ($dataplan == $feriado->date) {
              $dataPlantao = date_format(new DateTime($plantao['data']), 'd/m/Y');
              $horarioInicio = new DateTime($plantao['horainicio']);
              $horarioTermino = new DateTime($plantao['horafim']);

              if ($verificadorData == $dataPlantao) {
                $duracao = $horarioInicio->diff($horarioTermino);
                $duracao = $duracao->format("%H:%I:%S");
                $duracao = new DateTime($duracao);
                $hora = new DateTime($datas[$i]['horas']);
                $datas[$i]['horas'] = $hora->diff($duracao);
                $datas[$i]['isFeriado'] = true;
                $datas[$i]['isDomingo'] = false;
                $duriction = new DateTime($datas[$i]['duracao']);
                $duriction=$duriction->add($duracao);
                $result = $duriction->format("%H:%I:%S");
                $datas[$i]['duracao'] = $result;
              } else {
                  $duracao = $horarioInicio->diff($horarioTermino);
                  $duracao = $duracao->format("%H:%I:%S");
                  $datas[$i]['duracao'] = $duracao;
                  $duracao = new DateTime($duracao);
                  $HE100SA = $HE100SA->diff($duracao);

                  $HE100SA = $HE100SA->format("%H:%I:%S");
                  $duracao = $duracao->format("%H:%I:%S");

                  $datas[$i]['horas'] = $HE100SA;
                  $datas[$i]['isFeriado'] = true;
                  $datas[$i]['isDomingo'] = false;
                  $verificadorData = $dataPlantao;
              }
            }
        continue;
        }
        if($datas[$i]['isFeriado']){
          continue;
        }
        $dataPlantao = date_format(new DateTime($plantao['data']), 'd/m/Y');
        $horarioInicio = new DateTime($plantao['horainicio']);
        $horarioTermino = new DateTime($plantao['horafim']);

       
        if ($verificadorData == $dataPlantao) {
            $duracao = $horarioInicio->diff($horarioTermino);
            $duracao = $duracao->format("%H:%I:%S");
            $duracao = new DateTime($duracao);
            $hora = new DateTime($datas[$i]['horas']);
            $datas[$i]['horas'] = $hora->diff($duracao);
            $datas[$i]['isDomingo'] = false;
            $datas[$i]['isFeriado'] = false;
            $duriction = new DateTime($datas[$i]['duracao']);
            $duriction = $duriction->add($duracao);
            $result = $duriction->format("%H:%I:%S");
            $datas[$i]['duracao'] = $result;
        } else {
            $duracao = null;
            $HSA = new DateTime('05:27:00');
            $duracao = $horarioInicio->diff($horarioTermino);
            $duracao = $duracao->format("%H:%I:%S");
            $datas[$i]['duracao'] = $duracao;
            $duracao = new DateTime($duracao);
            $HSA = $HSA->diff($duracao);
            $HSA = $HSA->format("%H:%I:%S");
            $datas[$i]['isDomingo'] = false;
            $datas[$i]['isFeriado'] = false;
            $datas[$i]['horas'] = $HSA;
            $verificadorData = $dataPlantao;
        }
      }    
}

function isDomingo($data)
{
    if (date('N', strtotime($data)) == 7) {
        return true;
    } else {
        return false;
    }
}

?>

                <div class="container">
             <div class="row">
                <h1>
            <div class="row">
                Relatório de sobreaviso:
                </h1>
            </div>
            <br>
             </div>
                <div class="text-center">
                   <h4> <p> Relatório referente do período <strong><?php echo $data1 ?></strong> ao <strong><?php echo $data2 ?></strong> </p></h5>
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
include 'include/db.php';
$sql = "SELECT id_plantao, empresa, contato, descsolucao, descproblema, data, horainicio, horafim FROM plantao where date(datainicio) BETWEEN '$data1' and '$data2' OR data BETWEEN '$data1' and '$data2' and usuario = '$usuario' ORDER BY id_plantao desc";
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
}?>
                    </tbody>

                </table>
            </div>
            <div class="row">
                    <hr/>
                </div>
            <div class="footer">
                    <table class="foot">
                    <tr>
                        <th>Segunda à Sexta Feira: 12:01 às 13:29 e 18:01 às 22:00. Sábados, domingos e feriados: 08:00 às 22:00.</th>
                    </tr>
                    <tr>
                        <td>TOTAL DIARIO SEGUNDA A SEXTA&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>05:27:00</strong></td>
                    </tr>
                    <tr>
                        <td>SABÁDO&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>14:00:00</strong></td>
                    </tr>
                    <tr>
                        <td>DOMINGO&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>14:00:00</strong></td>
                    </tr>
                    <tr>
                        <td>TOTAL SEMANA&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>51:14:00</strong></td>
                    </tr>
                    <div class="assin">
                        <hr style="border-color:black;"/>
                        <center><h3><?php echo $_SESSION['UsuarioNome']; ?></h3></center>
                    </div>
                    </table>
                    <div class="align-left">
                      <div class="col-sm-6">
                    <table class="table-striped">
                    <tr>
                        <th>Data</th>
                        <th>Sobreaviso</th>
                        <th>Horas</th>
                    </tr>
                    <tbody>
                      <?php
                        foreach($datas as $data){
                          echo'<tr>';
                          echo'<td>'.formatarData($data['data']); echo $data['isFeriado'] ? ' FERIADO' : ''.'</td>';
                          echo'<td>'.$data['horas'].'</td>';
                          echo'<td>'.$data['duracao'].'</td>';
                          echo'</tr>';
                        }
                        ?>
                    </div>
                      </div>
            </div>

        </body>
    </html>
