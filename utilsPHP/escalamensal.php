<?php
    require_once '../include/Database.class.php';
    $db = Database::conexao();

    date_default_timezone_set('America/Sao_Paulo');
    $mes = $_POST['mes'];
    $mesestenso = retornames($mes);
    $users = explode(",", $_POST['usuarios']);
    $usuarios = [];
    $ano = date('Y');
    // $gerarPDF = true;
    $dias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
    $data1 = "{$ano}-{$mes}-01";
    $data2 = "{$ano}-{$mes}-{$dias}";
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

    for ($i = 0; $i < count($users); $i++) {
        $usu = explode("<", $users[$i]);
        $usuarios[$i]['nome'] = $usu[0];
    }

    for ($i = 0; $i < count($datas); $i++) {
        if ($i == 0 || isSegunda($datas[$i]['data'])) {
            $datas[$i]['periodo'] = 'INICIO';
        } else if (isDomingo($datas[$i]['data'])) {
            $datas[$i]['periodo'] = 'FIM';
        } else if ($i == (count($datas) - 1)) {
            $datas[$i]['periodo'] = 'FIM';
        } else {
            $datas[$i]['periodo'] = 'ENTRE';
        }
    }

    $y = 0;

    for ($x = 0; $x < count($usuarios); $x++) {
        $usuarios[$x]['mes'] = $mes;
        $usuarios[$x]['ordem'] = ($x + 1);
        if ($y == count($datas)) {
            break;
        }
        for ($i = $y; $i < count($datas); $i++) {
            $y = array_search($datas[$i], $datas) + 1;
            if ($i == 0 || $datas[$i]['periodo'] == "INICIO") {
                $usuarios[$x]['inicioperiodo'] = $datas[$i]['data'];
            }
            if ($i == (count($datas)-1) || isDomingo($datas[$i]['data']) || $datas[$i]['periodo'] == "FIM") {
                $usuarios[$x]['fimperiodo'] = $datas[$i]['data'];
                break;
            }
        }
    }


    $sql = "SELECT * FROM escalasobreaviso WHERE  mes = '$mes'";
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchall();

    if($result != null){
        $sql = "DELETE FROM escalasobreaviso WHERE mes = '$mes'";
        $query = $db->prepare($sql);
        $query->execute();
    }

    foreach($usuarios as $usuario){
        if(!isset($usuario['fimperiodo']) || !isset($usuario['inicioperiodo']))
            continue;
        $nome = $usuario['nome'];
        $fimperiodo = $usuario['fimperiodo'];
        $inicioperiodo = $usuario['inicioperiodo'];
        $ordem = $usuario['ordem'];
        $sql = "INSERT INTO escalasobreaviso (mes, inicioperido, fimperiodo, ordem, usuario) VALUES ('$mes','$inicioperiodo','$fimperiodo','$ordem','$nome')";
        $query = $db->prepare($sql);
        $query->execute();
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

function retornames($mes)
{
    if ($mes == "01") {
        return "JANEIRO";
    } else if ($mes == "02") {
        return "FEVEREIRO";
    } else if ($mes == "03") {
        return "MARÇO";
    } else if ($mes == "04") {
        return "ABRIL";
    } else if ($mes == "05") {
        return "MAIO";
    } else if ($mes == "06") {
        return "JUNHO";
    } else if ($mes == "07") {
        return "JULHO";
    } else if ($mes == "08") {
        return "AGOSTO";
    } else if ($mes == "09") {
        return "SETEMBRO";
    } else if ($mes == "10") {
        return "OUTUBRO";
    } else if ($mes == "11") {
        return "NOVEMBRO";
    } else {
        return "DEZEMBRO";
    }
}
?>