<?php
include '../validacoes/verificaSession.php';
$dire = '../tmp/';
$filename = $_SESSION['reportName'];
if (file_exists($dire.$filename)) {
    header('Content-type: application/force-download');
    header('Content-Disposition: attachment; filename='.$filename);
    readfile($dire.$filename);
}
unlink($dire.$filename);
?>