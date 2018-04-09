<?php
date_default_timezone_set('America/Sao_Paulo');
include 'include/dbconf.php';
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();
$mes = $_POST['mes'];
$mesestenso = retornames($mes);
$usuarios = explode(",",$_POST['usuarios']);
$ano = date('Y');
$dias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
$data1 = "2018-{$mes}-01";
$data2 = "2018-{$mes}-{$dias}";
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

for($i = 0; $i < count($datas); $i++) {
    if($i == 0 || isSegunda($datas[$i]['data'])){
        $datas[$i]['periodo'] = 'INICIO';
    }else if(isDomingo($datas[$i]['data'])){
        $datas[$i]['periodo'] = 'FIM';
    }else if($i == (count($datas)-1)){
        $datas[$i]['periodo'] = 'FIM';
    }else{
        $datas[$i]['periodo'] = 'ENTRE';
    }
}
ob_start();

echo '<center>
        <samp>
            <div class="image">
                <img src="imagem/logo.png">
                <h3>ESCALA SOBREAVISO '.$mesestenso.' '.$ano.'</h3>
            </div>
            <div class="dados" margin="20%">
                <table cellpadding="10">
                    <tr>
                        <th>NOME</th>
                        <th>SEMANA</th>
                        <th>ASSINATURA</th>
                    </tr>
                    <tbody>';
$y = 0;
for($x = 0; $x < count($usuarios); $x++){
    if($y == count($datas)){
        break;
    }
    echo '<tr>';
    echo '<td>'.$usuarios[$x].'</td>';
    for($i = $y; $i < count($datas); $i++){
        $y = array_search($datas[$i],$datas)+1;
        if($i == 0 || $datas[$i]['periodo'] == "INICIO"){
            echo "<td><i>".formatarData($datas[$i]['data']);
        }
        if(isDomingo($datas[$i]['data']) || $datas[$i]['periodo'] == "FIM"){
            echo " - ".formatarData($datas[$i]['data'])."</i></td>";
            break;
        }
    }
    echo '<td>__________________________________________</td>';
    echo '</tr>';
}
echo "</tbody>";
echo "</table>
<h5>Segunda à Sexta Feira: 12:01 às 13:29 e 18:01 às 22:00. Sábados, Domingos e Feriados: 08:00 às 22:00.</h5>
    </center>
    <table align='left' style='margin-left:550px; margin-right:200px; table-layout: auto; width: 30%; border-collapse: collapse; border: 1px solid black;'> 
        <tbody align='left'>
            <tr><td width='400' style='border: 1px solid black;'>TOTAL DIARIO seg a sex</td><td width='100' style='border: 1px solid black;'>05:27:00</td></tr>
            <tr><td width='400' style='border: 1px solid black;'>SABÁDO</td><td width='100' style='border: 1px solid black;'>14:00:00</td></tr>
            <tr><td width='400' style='border: 1px solid black;'>DOMINGO</td><td width='100' style='border: 1px solid black;'>14:00:00</td></tr>
            <tr><td width='400' style='border: 1px solid black;'>TOTAL SEMANA</td><td width='100' style='border: 1px solid black;'>55:15:00</td></tr>
        </tbody>
    </table>
    </samp>
</div>";
try{
    $html = ob_get_contents();
    ob_end_clean();
    $mpdf->SetTitle("Escala_Mensal");
    $stylesheet = file_get_contents('css/escalamento.css');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($html,2);
    // Write some HTML code:
    $dire = 'tmp/';
    $filename = 'escalamensal.pdf';
    $mpdf->Output($dire.$filename, 'F');
}catch(Exception $e){
    echo $e;
}


function isDomingo($date) 
{
    $day = date("D", strtotime($date));
    return $day == 'Sun' ? true : false;
}
function isSegunda($date) 
{
    $day = date("D", strtotime($date));
    return $day == 'Mon' ? true : false;
}

function formatarData($data)
{
    $datainicio = date_create($data);
    return date_format($datainicio, 'd/m/Y');
}
function retornames($mes){
    if($mes == "01"){
        return "JANEIRO";
    }else if($mes == "02"){
        return "FEVEREIRO";
    }else if($mes == "03"){
        return "MARÇO";
    }else if($mes == "04"){
        return "ABRIL";
    }else if($mes == "05"){
        return "MAIO";
    }else if($mes == "06"){
        return "JUNHO";
    }else if($mes == "07"){
        return "JULHO";
    }else if($mes == "08"){
        return "AGOSTO";
    }else if($mes == "09"){
        return "SETEMBRO";
    }else if($mes == "10"){
        return "OUTUBRO";
    }else if($mes == "11"){
        return "NOVEMBRO";
    }else{
        return "DEZEMBRO";
    }
}
?>