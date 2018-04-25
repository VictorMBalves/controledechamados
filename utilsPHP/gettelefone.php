<?php
    include '../include/db.php';
    function retorna($nome, $conn)
    {
        $sql = "SELECT `telefone`, `celular`,`backup`
        FROM `empresa` WHERE `nome` = '{$nome}' ";

        $query = $conn->query($sql);

        $arr;
        if ($query->num_rows) {
            while ($dados = $query->fetch_object()) {
                $arr['telefone'] = $dados->telefone;
                $arr['celular'] = $dados->celular;
                $arr['backup'] = $dados->backup;
            }
        }
        return json_encode($arr);
    }

    if (isset($_GET['empresa'])) {
        echo retorna($_GET['empresa'], $conn);
    }
?>