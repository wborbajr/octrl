<?php
// uso
// http://www.omniinformatica.com.br/oCtrl/base/comum/cep/busca.inc.php?cep=86070545

// outro exemplo
// https://viacep.com.br/

$cep = $_REQUEST[cep];

$cep = str_replace("-", "", $cep); // retira traços, caso tenha

$token = '4fba31302590f20ca8a1f3b254ee3725';
$url = 'http://www.cepaberto.com/api/v2/ceps.json?cep=' . $cep;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token token="' . $token . '"'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$oRtn = json_decode( curl_exec($ch) );

$sTipo = $oRtn->logradouro;
$sTipo = substr($sTipo, 0, strpos($sTipo, " "));
$oRtn->tipo = $sTipo;

$sTipo = $oRtn->logradouro;
$oRtn->logradouro = substr($sTipo, strpos($sTipo, " ")+1);

echo json_encode($oRtn);
?>
