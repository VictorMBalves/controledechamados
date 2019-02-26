<?php
require_once '../include/ConsultacURL.class.php';
$curl = new ConsultacURL();
$url = "http://api.gtech.site/companies/find_companies?term=".$_GET['keyword'];
$result = $curl->connection($url);
echo json_encode($result);