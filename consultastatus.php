
<?php
$url = "https://nfce.fazenda.pr.gov.br/nfce/NFeStatusServico3";
$xml = '<soap12:Envelope 
 xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
 <soap12:Header>
     <nfeCabecMsg 
         xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NfeStatusServico3">
         <cUF>41</cUF>
         <versaoDados>3.10</versaoDados>
     </nfeCabecMsg>
 </soap12:Header>
 <env:Body 
     xmlns:env="http://www.w3.org/2003/05/soap-envelope">
     <nfeDadosMsg 
         xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NfeStatusServico3">
         <consStatServ 
             xmlns="http://www.portalfiscal.inf.br/nfe" versao="3.10">
             <tpAmb>1</tpAmb>
             <cUF>41</cUF>
             <xServ>STATUS</xServ>
         </consStatServ>
     </nfeDadosMsg>
 </env:Body>
 </soap12:Envelope>';



// $cert_file = 'german.pem';
// $cert_password = '1234';
 
// $ch = curl_init();
 
// $options = array( 
//     CURLOPT_RETURNTRANSFER => true,
//     //CURLOPT_HEADER         => true,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_SSL_VERIFYHOST => false,
//     CURLOPT_SSL_VERIFYPEER => false,
     
//     CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
//     //CURLOPT_VERBOSE        => true,
//     CURLOPT_URL => $url ,
//     CURLOPT_SSLCERT => $cert_file ,
//     CURLOPT_SSLCERTPASSWD => $cert_password ,
// );


// $ch = curl_init(); 
// curl_setopt_array($ch , $options);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_TIMEOUT, 10);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// $data = curl_exec($ch); 
// echo $data;
// if(curl_errno($ch))
//     print curl_error($ch);
// else
//     curl_close($ch);



$url = "https://nfce.fazenda.pr.gov.br/nfce/NFeStatusServico3";
$cert_file = 'german.pem';
$cert_password = '1234';
$headers = array(
    "Content-type: text/xml",
    "Content-length: " . strlen($xml),
    "Connection: close",
);
$ch = curl_init();
    
$options = array( 
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER         => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
        
    CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
    //CURLOPT_VERBOSE        => true,
    CURLOPT_URL => $url ,
    CURLOPT_SSLCERT => $cert_file ,
    CURLOPT_SSLCERTPASSWD => $cert_password ,
    CURLOPT_POSTFIELDS => $xml,
    CURLOPT_HTTPHEADER => $headers

);
    
curl_setopt_array($ch , $options);
    
$output = curl_exec($ch);
    
if(!$output)
{
    echo "Curl Error : " . curl_error($ch);
}
else
{
    echo htmlentities($output);
}
?>