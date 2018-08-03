<?php
include '../validacoes/verificaSession.php';
require_once '../include/ConsultacURL.class.php';
require_once '../include/Database.class.php';
require_once '../vendor/autoload.php';
try{
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
$db = Database::conexao();
$curl = new ConsultacURL();

if(isset($_POST['situacao'])){
    $situacoes = explode(",", $_POST['situacao']);
}
$order = getOrder();
$group = getGroup();
if(isset($_POST['versao'])){
    $versao = str_replace(".","",$_POST['versao']);
}else{
    $versao="4350";
}
$url = "api.gtech.site/companies?q[version_int_lt]=".$versao."&q[active_eq]=true&q[sorts]=".$group.".asc,".$order;//&q[cont_days_access_eq]=5
$resultados =& json_decode($curl->connection($url));

foreach ($resultados as $resultado){
    if ($resultado->state == null){
        $resultado->state = "Estado não identificado";
    }
    if ($resultado->system == null){
        $resultado->system = "Sistema não identificado";
    }
    if($resultado->is_blocked){
        $resultado->situacao = 'bloqueado';
    }
    if($resultado->active){
        $resultado->situacao = 'ativo';
    }
    if(!$resultado->is_blocked && !$resultado->active){
        $resultado->situacao = 'desistente';
    }
    if($resultado->test_system){
        $resultado->situacao = 'teste';
    }
}

foreach ($resultados as $key => $resultado){
    if (!in_array($resultado->situacao, $situacoes)) { 
        unset($resultados[$key]);
    }
}
$resultados = array_values(array_filter($resultados));
ini_set("pcre.backtrack_limit", "5000000");
ob_start();
echo '<div class="row">';
echo    '<div class="text-center">';
echo        '<div class="row">';
echo            '<h2>';
echo                '<center>Relatório de empresas inertes</center>';
echo            '</h2>';
echo        '</div>';
echo    '</div>';
echo '</div>';
// echo '<div class="row">';
// echo    '<hr>';
// echo '</div>';
$i = 1;
$groupkey = null;
$contGroup = 0;
$totalGroup = 0;
$totalGeral = 0;
foreach ($resultados as $key => $resultado){
    $sql = "SELECT `telefone`, `celular` FROM `empresa` WHERE `nome` = '{$resultado->name}' ";
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $arr = [];
    if ($query->rowcount() > 0) {
        $resultado->phone2 = $result['telefone'];
        $resultado->celphone = $result['celular'];
    }else
        $resultado->phone2 = null;
    
        if($group == 'state'){
            if($groupkey != $resultado->state){
                if($groupkey != null)
                    echo '<pagebreak/>';
                $groupkey = $resultado->state;
                $printGroup = true;
                $contGroup = 0;
                $totalGroup = 0;
            }
            $contGroup++;
            $totalGroup += $resultado->payment;
        }
        if($group == 'system'){
            if($groupkey != $resultado->system){
                if($groupkey != null)
                    echo '<pagebreak/>';
                $groupkey = $resultado->system;
                $printGroup = true;
                $contGroup = 0;
                $totalGroup = 0;
            }
            $contGroup++;
            $totalGroup += $resultado->payment;
        }
        if($group == 'last_login'){
            if($groupkey != $resultado->count_days_dont_access){
                if($groupkey != null)
                    echo '<pagebreak/>';
                $groupkey = $resultado->count_days_dont_access;
                $printGroup = true;
                $contGroup = 0;
                $totalGroup = 0;
            }
            $contGroup++;
            $totalGroup += $resultado->payment;
        }
        echo '<div class="row">';
        if($printGroup){
            echo '<div class="row">';
            echo    '<h3>'.$groupkey.'</h3>';
            echo    '<hr>';
            echo '</div>';
            $printGroup = false;
        }
    echo '<tr>
            <th>|Nº:'.$i.'</th>
            <th>|Empresa:'.$resultado->name.'</th>
          </tr>
          <table style="margim-left:50" class="table table-bordered">
                <thead>
                    <tr>';
                    echo'<th style="padding: 5px;">Cidade</th>';
                    if($group != 'state')
                        echo'<th style="padding: 5px;">Estado</th>';
                    echo'<th style="padding: 5px;">Situação</th>';
                    echo'<th style="padding: 5px;">Responsável</th>';
                    echo'<th style="padding: 5px;">Telefone</th>';
                    echo'<th style="padding: 5px;">Telefone 2</th>';
                    echo'<th style="padding: 5px;">Celular</th>';
                    echo'<th style="padding: 5px;">Versão</th>';
                    if($group != 'system')
                        echo'<th style="padding: 5px;">Sistema</th>';
                    echo'<th style="padding: 5px;">Mensalidade</th>';
                    if($group != 'last_login')
                        echo'<th style="padding: 5px;">Ult. acesso</th>';
                echo'</tr>
                </thead>
                <tbody>
                    <tr>';
                    echo'<td style="padding: 5px;">'.blankWhenNull($resultado->city).'</td>';
                    if($group != 'state')
                        echo'<td style="padding: 5px;">'.blankWhenNull($resultado->state).'</td>';
                    echo'<td style="padding: 5px;">'.blankWhenNull($resultado->situacao).'</td>';
                    echo'<td style="padding: 5px;">'.blankWhenNull($resultado->responsible).'</td>';
                    echo'<td style="padding: 5px;">'.blankWhenNull($resultado->phone).'</td>';
                    echo'<td style="padding: 5px;">'.blankWhenNull($resultado->phone2).'</td>';
                    echo'<td style="padding: 5px;">'.blankWhenNull($resultado->celphone).'</td>';
                    echo'<td style="padding: 5px;">'.blankWhenNull($resultado->version).'</td>';
                    if($group != 'system')
                        echo'<td style="padding: 5px;">'.blankWhenNull($resultado->system).'</td>';
                    echo'<td style="padding: 5px;">R$'.number_format(blankWhenNull($resultado->payment), 2, ',', '.').'</td>';
                    if($group != 'last_login')
                        echo'<td style="padding: 5px;">'.blankWhenNull($resultado->count_days_dont_access).'</td>';
                    echo'</tr>
                </tbody>
            </table>';
            if($group == 'last_login'){
                if($groupkey != $resultados[$key+1]->count_days_dont_access){
                    echo '<div class="row">';
                    echo    '<hr>';
                    echo    '<p>Total grupo: '.$contGroup.' Empresas</p>';
                    echo    '<p>Valor total mensalidade grupo: R$'.number_format($totalGroup, 2, ',', '.').'</p>';
                    echo '</div>';
                }
            }else{
                if($groupkey != $resultados[$key+1]->$group){
                    echo '<div class="row">';
                    echo    '<hr>';
                    echo    '<p>Total grupo: '.$contGroup.' Empresas</p>';
                    echo    '<p>Valor total mensalidade grupo: R$'.number_format($totalGroup, 2, ',', '.').'</p>';
                    echo '</div>';
                }
            }
            $totalGeral += $resultado->payment;
            if($resultado == end($resultados)){
                echo '<div class="row">';
                echo    '<hr>';
                echo    '<p>Total geral: '.$i.' Empresas</p>';
                echo    '<p>Valor total mensalidade geral: R$'.number_format($totalGeral, 2, ',', '.').'</p>';
                echo '</div>';
            }
    echo '</div>';
    $i++;
}
}catch(Exception $e){
    die("Error: " . $e->getMessage());
}
try {
    $html = ob_get_contents();
    ob_end_clean();
    $mpdf->SetTitle("Empresas Inertes");
    $mpdf->SetHTMLFooter('<table width="100%">
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
    $filename = 'Empresas inertes.pdf';
    $mpdf->Output($dire.$filename, 'F');
    $_SESSION['reportName'] = $filename;
    echo 'success';
    exit;
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

function blankWhenNull($param){
    return isset($param) ? $param : ""; 
}

function getOrder(){
    if(isset($_POST['order'])){
        if($_POST['order'] == 'alfabetica')
            return 'name.asc';
        if($_POST['order'] == 'mensalidade')
            return 'payment.desc';
        if($_POST['order'] == 'dias')
            return 'last_login.desc';
        if(!isset($order))
            return 'name.asc';    
    }
}
function getGroup(){
    if(isset($_POST['group'])){
        if($_POST['group'] == 'estado')
            return 'state';
        if($_POST['group'] == 'dias')
            return 'last_login';
        if($_POST['group'] == 'sistema')
            return 'system';
        if($_POST['group'] == 'situacao')
            return 'situacao';
        if(!isset($group))
            return 'name';
    }
}
?>