<?php
    require_once '../include/ConsultacURL.class.php';
    $curl = new ConsultacURL();
    echo $curl->connection("http://api.gtech.site/companies/");
?>
