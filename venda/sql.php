<?php
session_start();
include_once('../conn.inc.php');

$sTabela  = "V_ESTOQUE";

$sCampos = "ID_IDENTIFICADOR,COD_LST,SERVICO,ID_ESTOQUE,PROD_SERV,UNI_MEDIDA,FRACIONADO,DT_CADAST,HR_CADAST,PRC_CUSTO,PRC_VENDA,ULT_VENDA,MARGEM_LB,POR_COMISSAO,STATUS,ULT_FORNEC,FORNECEDOR,ID_TIPOITEM,TIPO_ITEM,ADICIONAL1,ADICIONAL2,ID_INDEXADOR,INDEXADOR,VALOR,ID_GRUPO,GRUPO,DESC_CMPL,COD_BARRA,REFERENCIA,PRC_MEDIO,QTD_COMPRA,QTD_ATUAL,QTD_MINIM,QTD_INICIO,QTD_RESERV,QTD_POSVEN,ULT_COMPRA,PESO,IPI,CF,CST,CST_IPI,CST_PIS,CST_COFINS,PIS,COFINS,IAT,IPPT,COD_NCM,CSOSN,MVA,ID_NIVEL1,NIVEL1,ID_NIVEL2,NIVEL2,ID_CTI,GRADE_SERIE,ISS_ALIQ,ID_FORNEC_PREF,FORNECEDOR_PREF,ANP,FCI,PRC_ATACADO,CFOP_NF,COD_CEST,CENQ,CST_CFE,CSOSN_CFE";
$aCampos  = explode(",",$sCampos);
// $sDefault = $aCampos[2];

// echo "passou!";
// return $oObj;
$sCampos = "*";
$sql = "SELECT $sCampos FROM $sTabela ORDER BY SERVICO;";

// echo "$sql";

//Executa a instrução SQL
$res = queryFB($sql);

$aDados = [];
$sRtn = '';

$i = 0;
while($row = ibase_fetch_assoc($res, IBASE_TEXT)) // ibase_fetch_assoc($res,IBASE_TEXT)
{

  $aLinha = [];
  for ($i=0; $i < sizeof($aCampos); $i++) {
    // $alinha[ $aCampos[$i] ] = $row[ $aCampos[$i] ];
    $sCampo = $aCampos[$i];
    // $aDados[$sCampo] = $row[ $sCampo ];
    $aDados[] = $sCampo;
  }
  // array_push($aDados,$aLinha);

  $i++;
  // $sRtn .= "<option value='$row->ID' $bSelected>".format_data($row->DESC)."</option>";
};

// if ($i==0){
//   $sRtn = "<option value=-1>Não encontrado</option>";
// } else {
//   if ($sDefault == '') {
//     $sRtn = "<option value=0>** Selecione algo **</option>" . $sRtn;
//   }
// }

echo json_encode(Array(code => $i,data => $aDados,msg => $sRtn));

?>
