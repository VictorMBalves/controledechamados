<?php
require_once '/var/www/html/chamados/current/include/Database.class.php';
$db = Database::conexao();

$sql = "SELECT 
            id_chamadoespera, 
            usuario, 
            status, 
            empresa, 
            contato, 
            telefone, 
            data as databanco,
            DATE_FORMAT(data,'%d/%m/%Y %H:%i') as dataFormatada,
            enderecado, 
            historico, 
            notification, 
            descproblema,
            dataagendamento,
            DATE_FORMAT(dataagendamento,'%d/%m/%Y %H:%i') as dataagendamentoformat
        FROM chamadoespera 
        WHERE status <> 'Finalizado' 
        AND usuario_id != 56
        AND data < DATE_ADD(NOW(), INTERVAL -10 MINUTE) AND (dataagendamento IS NULL OR dataagendamento < DATE_ADD(NOW(), INTERVAL -10 MINUTE))
        ORDER BY status, data DESC";
$query = $db->prepare($sql);
$query->execute();
$resultado = $query->fetchall(PDO::FETCH_ASSOC);

foreach($resultado as $chamado){
    $curl = curl_init();

    curl_setopt_array($curl, array(
            CURLOPT_URL => "https://hooks.slack.com/services/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",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{'text': ':clock1: Há um chamado para empresa ".$chamado['empresa']." com mais de 10 minutos de atraso!!!'}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: 26044770-ef0c-424d-814a-a8cd9f10bc2d",
                "cache-control: no-cache"
            ),
        )
    );

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
    echo $response;
    }
}
?>