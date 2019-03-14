<?php
require_once '../include/ConsultacURL.class.php';
$curl = new ConsultacURL();
$term = urlencode($_GET['keyword']);
$url = "http://api.gtech.site/companies/find_companies?term=".$term;
$result = $curl->connection($url);
echo json_encode($result);