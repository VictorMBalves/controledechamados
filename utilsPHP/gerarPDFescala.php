<?php
    if(isset($_POST['mes'])){
        require_once '../include/Database.class.php';
        $db = Database::conexao();
        $mes = $_POST['mes'];
        $sql = "SELECT * FROM escalasobreaviso WHERE mes = '$mes'";
        $query = $db->prepare($sql);
        $query->execute();
        $resultados = $query->fetchall();

        if($resultados != null){
            gerarPDF($_POST['mes'],$resultados);
        }else{
            echo "null";
        }
    }
    function gerarPDF($mes,$resultados)
    {
        $ano = date('Y');
        $mesestenso = retornames($mes);
        require_once '../vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        ob_start();
        echo '<center>
                <samp>
                    <div class="image">
                        <img src="../imagem/logo.png">
                        <h3>ESCALA SOBREAVISO ' . $mesestenso . ' ' . $ano . '</h3>
                    </div>
                    <div class="dados" margin="20%">
                        <table cellpadding="10">
                            <tr>
                                <th>NOME</th>
                                <th>SEMANA</th>
                                <th>ASSINATURA</th>
                            </tr>
                            <tbody>';
                            foreach ($resultados as $usuario) {
                                echo '<tr>';
                                echo '<td>' . $usuario['usuario'] . '</td>';
                                echo "<td><i>" . formatarData($usuario['inicioperido']);
                                echo " - " . formatarData($usuario['fimperiodo']) . "</i></td>";
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

        try {
            $html = ob_get_contents();
            ob_end_clean();
            $mpdf->SetTitle("Escala_Mensal");
            $stylesheet = file_get_contents('../css/escalamento.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->WriteHTML($html, 2);
            // Write some HTML code:
            $dire = '../tmp/';
            $filename = 'escalamensal.pdf';
            $mpdf->Output($dire.$filename, 'F');
        } catch (Exception $e) {
            echo $e;
        }
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