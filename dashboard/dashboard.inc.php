<?php
  // include_once('../conn.inc.php');


  return false;


  $sAcao = $_REQUEST[acao];
  $oObj  = $_REQUEST[obj];

  switch ($sAcao) {
    case "dash_resumo1":
      $aRtn = dash_resumo1($oObj);
      break;

    case "glt_dash_combos":
      $aRtn = glt_dash_combos();
      break;

    default:
      $aRtn = Array(code => -1, data => [], msg => "Informe um parâmetro!");
  }

  echo json_encode( $aRtn );

  exit;
  return false;





//***
function glt_dash_resumo1(){

  $sSql = "SELECT DISTINCT EXTRACT(YEAR_MONTH FROM `glt15_data`) as periodo,
                  `glt10_ramal`, `glt10_atendente`, `glt05_tipo`, glt07_sigla, glt05_desc, count(`glt05_tipo`) as qtd
           FROM glt15_registros, glt05_tipos
           WHERE glt05_tipo = glt05_codigo
           AND (glt15_hora > '09:00:00' AND glt15_hora < '18:30:00')
           GROUP BY 1, 2, 3, 4, 5
           ORDER BY glt07_sigla, periodo desc, qtd desc, glt10_ramal";

  $res = query( $sSql );

  $aRtn = [];
  $iQtd = 0;

  while ($data = mysqli_fetch_object($res)) {
      $aRtn[] = array(
                        'periodo'      => formataPeriodo($data->periodo),
                        'sigla'      => $data->glt07_sigla,
                        'glt10_ramal'  => $data->glt10_ramal,
                        'glt10_atendente' => htmlspecialchars($data->glt10_atendente),
                        'glt05_tipo'   => $data->glt05_tipo,
                        'glt05_desc'   => htmlspecialchars($data->glt05_desc),
                        'qtd'          => $data->qtd
                    );
      $iQtd++;
  }

   return Array(code => $iQtd, data => $aRtn, msg => "glt_dash_resumo1()");
}



?>
