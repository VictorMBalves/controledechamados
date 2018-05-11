<?php

require_once '../include/Database.class.php';
$db = Database::conexao();

if (isset($_POST['empresa'])){
  $empresa = $_POST['empresa'];
}
if (isset($_POST['sistema'])){
  $sistema = $_POST['sistema'];
}
if (isset($_POST['versao'])) {
    $versao = $_POST['versao'];
}
if (isset($_POST['nf'])) {
    $nf = $_POST['nf'];
}
if (isset($_POST['nfc'])) {
    $nfc = $_POST['nfc'];
}
if (isset($_POST['cte'])) {
    $cte = $_POST['cte'];
}
if (isset($_POST['mdf'])) {
    $mdf = $_POST['mdf'];
}
if (isset($_POST['nfs'])) {
    $nfs = $_POST['nfs'];
}
if (isset($_POST['conbloq'])) {
    $conbloq = $_POST['conbloq'];
}
if (isset($_POST['sat'])) {
    $sat = $_POST['sat'];
}
if (isset($_POST['emissor'])) {
    $emissor = $_POST['emissor'];
}

$sql = $db->prepare("UPDATE empresa SET  nota_fiscal = '$nf', nota_fiscal_consumidor = '$nfc', conhecimento_trasporte = '$cte', manifesto_eletronico = '$mdf', nota_fiscal_servico = '$nfs', consulta_bloqueio = '$conbloq', cupom_fiscal_eletronico_sat = '$sat', emissor_documentos_fiscais_eletronicos = '$emissor', sistema = '$sistema', versao = '$versao' WHERE nome = '$empresa'")
or die(mysql_error());
$sql->execute();

echo '<div class="list-group">';
  if($emissor == 'true'){
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-ok">&nbsp</span>Emissor de Documento Fiscal Eletrônico</a>';
    echo '</div>';
  }else{
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item disabled"><span class="glyphicon glyphicon-remove">&nbsp</span>Emissor de Documento Fiscal Eletrônico</a>';
    echo '</div>';
  }
  if($nf == 'true'){
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-ok">&nbsp</span>Nota Fiscal Eletrônica</a>';
    echo '</div>';
  }else{
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item disabled"><span class="glyphicon glyphicon-remove">&nbsp</span>Nota Fiscal Eletrônica</a>';
    echo '</div>';
  }
  if($nfc == 'true'){
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-ok">&nbsp</span>Nota Fiscal Consumidor</a>';
    echo '</div>';
  }else{
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item disabled"><span class="glyphicon glyphicon-remove">&nbsp</span>Nota Fiscal Consumidor</a>';
    echo '</div>';
  }
  if($cte == 'true'){
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-ok">&nbsp</span>Conhecimento de Transporte</a>';
    echo '</div>';
  }else{
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item disabled"><span class="glyphicon glyphicon-remove">&nbsp</span>Conhecimento de Transporte</a>';
    echo '</div>';
  }
  if($mdf == 'true'){
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-ok">&nbsp</span>Manifesto Eletrônico</a>';
    echo '</div>';
  }else{
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item disabled"><span class="glyphicon glyphicon-remove">&nbsp</span>Manifesto Eletrônico</a>';
    echo '</div>';
  }
  if($nfs == 'true'){
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-ok">&nbsp</span>Nota Fiscal Serviço</a>';
    echo '</div>';
  }else{
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item disabled"><span class="glyphicon glyphicon-remove">&nbsp</span>Nota Fiscal Serviço</a>';
    echo '</div>';
  }
  if($sat == 'true'){
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-ok">&nbsp</span>Cupom Fiscal Eletrônico - SAT</a>';
    echo '</div>';
  }else{
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item disabled"><span class="glyphicon glyphicon-remove">&nbsp</span>Cupom Fiscal Eletrônico - SAT</a>';
    echo '</div>';
  }
  if($conbloq == 'true'){
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-ok">&nbsp</span>Consulta/Bloqueio</a>';
    echo '</div>';
  }else{
    echo '<div class="col-md-6">';
    echo '<a class="list-group-item disabled"><span class="glyphicon glyphicon-remove">&nbsp</span>Consulta/Bloqueio</a>';
    echo '</div>';
  }
echo '</div>';
?>