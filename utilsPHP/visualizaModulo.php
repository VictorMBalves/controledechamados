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

echo '<div class="row text-center">';
  echo'<div class="list-group col-12 col-sm-12 col-md-6 col-lg-6">';
      if($emissor == 'true'){
        echo '<a class="list-group-item list-group-item-info">Emissor de Documento Fiscal Eletrônico</a>';
      }else{
        echo '<a class="list-group-item list-group-item-action disabled"><i class="fas fa-times"></i>&nbspEmissor de Documento Fiscal Eletrônico</a>';
      }
      if($nf == 'true'){
        echo '<a class="list-group-item list-group-item-info"><i class="fas fa-check"></i>&nbspNota Fiscal Eletrônica</a>';
      }else{
        echo '<a class="list-group-item list-group-item-action disabled"><i class="fas fa-times"></i>&nbspNota Fiscal Eletrônica</a>';
      }
      if($nfc == 'true'){
        echo '<a class="list-group-item list-group-item-info"><i class="fas fa-check"></i>&nbspNota Fiscal Consumidor</a>';
      }else{
        echo '<a class="list-group-item list-group-item-action disabled"><i class="fas fa-times"></i>&nbspNota Fiscal Consumidor</a>';
      }
    if($cte == 'true'){
      echo '<a class="list-group-item list-group-item-info"><i class="fas fa-check"></i>&nbspConhecimento de Transporte</a>';
    }else{
      echo '<a class="list-group-item list-group-item-action disabled"><i class="fas fa-times"></i>&nbspConhecimento de Transporte</a>';
    }
    echo'</div>';
    echo'<div class="list-group col-12 col-sm-12 col-md-6 col-lg-6">';
      if($mdf == 'true'){
        echo '<a class="list-group-item list-group-item-info"><i class="fas fa-check"></i>&nbspManifesto Eletrônico</a>';
      }else{
        echo '<a class="list-group-item list-group-item-action disabled"><i class="fas fa-times"></i>&nbspManifesto Eletrônico</a>';
      }
      if($nfs == 'true'){
        echo '<a class="list-group-item list-group-item-info"><i class="fas fa-check"></i>&nbspNota Fiscal Serviço</a>';
      }else{
        echo '<a class="list-group-item list-group-item-action disabled"><i class="fas fa-times"></i>&nbspNota Fiscal Serviço</a>';
      }
      if($sat == 'true'){
        echo '<a class="list-group-item list-group-item-info"><i class="fas fa-check"></i>&nbspCupom Fiscal Eletrônico - SAT</a>';
      }else{
        echo '<a class="list-group-item list-group-item-action disabled"><i class="fas fa-times"></i>&nbspCupom Fiscal Eletrônico - SAT</a>';
      }
      if($conbloq == 'true'){
        echo '<a class="list-group-item list-group-item-info"><i class="fas fa-check"></i>&nbspConsulta/Bloqueio</a>';
      }else{
        echo '<a class="list-group-item list-group-item-action disabled"><i class="fas fa-times"></i>&nbspConsulta/Bloqueio</a>';
      }
  echo'</div>';
echo '</div>';
?>