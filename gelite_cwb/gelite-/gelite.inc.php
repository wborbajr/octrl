<?php
  include_once('../conn.inc.php');

  $sAcao = $_REQUEST[acao];
  $xParam0 = $_REQUEST[opc0];
  $xParam1 = $_REQUEST[opc1];
  $xParam2 = $_REQUEST[opc2];
  $xParam3 = $_REQUEST[opc3];

  // echo $sAcao;

	switch ($sAcao) {

    case "cargaRegistros":
      $aRtn = cargaRegistros($xParam0);
  		break;

    case "glt_dash_combos":
      $aRtn = glt_dash_combos();
  		break;

    case "glt_dash_resumo1":
      $aRtn = glt_dash_resumo1();
  		break;

    case "glt_dash_resumo2":
      $aRtn = glt_dash_resumo2();
      break;

    case "glt_dash_resumo3":
      $aRtn = glt_dash_resumo3();
      break;

    case "glt_dash_resumo4":
      $aRtn = glt_dash_resumo4();
      break;

    case "glt_dash_resumo5":
      $aRtn = glt_dash_resumo5($xParam0, $xParam1, $xParam2, $xParam3);
      break;

    case "sql":
      $aRtn = sql($xParam0);
  		break;

		default:
			$aRtn = Array(code => -1, data => [], msg => "Informe um parâmetro!");
	}

echo json_encode( $aRtn );

exit;
return false;



//***
function cargaRegistros($sLocal){

    // Não encontrado ou url vazia
    if ($sLocal == ''){
      return json_encode(Array(code => -1, data => Array(), msg => "Localidade não informada!"));
    }

    $sLocal = strtolower($sLocal); // minusculo

    // com base no local, localiza na tabela o caminho onde se encontra a fonte de dados txt
    $sSql = "SELECT glt07_sigla, glt07_desc, glt07_url FROM omni_pear.glt07_localidades WHERE glt07_sigla = '$sLocal';";
    $data = query($sSql, 1);

    // Não encontrado ou url vazia
    if ($data['glt07_url'] == ''){
      return json_encode(Array(code => -1, data => Array(), msg => "Localidade, $sLocal, não encontrada!"));
    }

    // Local e nome do arquivo a ser importado
    $sFonte = $data['glt07_url'] . "Bilhetagem_".$sLocal.".txt";

    // Arquivo de dados, não encontrado no caminho espeficificado
    if (! file_exists($sFonte)){
      return json_encode(Array(code => -1, data => Array(), msg => "Fonte de dados, $sFonte, não encontrada!"));
    }

    // Lê um arquivo em um array.  Nesse exemplo nós obteremos o código fonte de
    // uma URL via HTTP
    $aRtn = [];
    $lines = file($sFonte);
    $iQtdlines = count($lines);
    $aLinhas = [];

    $iQtd = 0;
    $iTotal = 0;

    // Percorre o array, mostrando o fonte HTML com numeração de linhas.
    foreach ($lines as $line_num => $line) {
      $line = trim($line);

      if (($line != '') && (strlen($line) == 80) && (substr($line, 0, 4) != 'Date')){

        $iTotal++;

        $aLinhas[] = InverteDA(substr($line,  0,  8)) .'|'. // data
                     substr($line,  9,  8) .'|'. // hora
                     substr($line, 18,  2) .'|'. // linha entrada
                     substr($line, 21,  4) .'|'. // ramal / atendente
                     substr($line, 33,  5) .'|'. // ring
                     substr($line, 39,  8) .'|'. // tempo
                     substr($line, 48, 20) .'|'. // fone
                     substr($line, 69,  1);      // tipo

        $sql = "SELECT glt10_atendente FROM glt10_ramais WHERE glt10_ramal = '".substr($line, 21,  4)."'";
        $aRamal = query($sql, 1);

        $sql = "INSERT INTO `glt15_registros` (
                        `glt07_sigla`, `glt15_data`, `glt15_hora`, `glt15_ln`, `glt10_ramal`,
                        `glt10_atendente`, `glt15_ring`, `glt15_duracao`, `glt15_fone`,
                        `glt05_tipo`
                      ) VALUES ( ".
                        "'$sLocal',".
                        "'".InverteDA(substr($line,  0,  8))."',".
                        "'".substr($line,  9,  8)."',".
                        "'".substr($line, 18,  2)."',".
                        "'".substr($line, 21,  4)."',".
                        "'".$aRamal[glt10_atendente]."',".
                        "'".substr($line, 33,  5)."',".
                        "'".substr($line, 39,  8)."',".
                        "'".substr($line, 48, 20)."',".
                        "'".substr($line, 69,  1)."'".
                        ");";

        // if (query($sql))
         ++$iQtd;
      }

    }

    // echo "Inseridos $iQtd registros novos";
    $aRtn['Total'] = $iQtdlines;
    $aRtn['Analisado'] = $iTotal;
    $aRtn['Update'] = $iQtd;
    $aRtn['Linhas'] = $aLinhas;
    return Array(code => 0, data => $aRtn, msg => "cargaRegistros()");
}


//***
function glt_dash_combos(){

    $aRtn[Tipos]  = '';
    $aRtn[Ramais] = '';
    $aRtn[Datas]  = '';
    $aRtn[Localidades]  = '';

    // Localidades
    $sql = "SELECT `glt07_sigla`, `glt07_desc`, `glt07_url` FROM `glt07_localidades`;";
    $res = query($sql);

    while ($data = mysqli_fetch_array($res))
      $aRtn[Localidades][] = array( 'sigla'   =>  $data[0],
                              'desc' => ($data[1]),
                              'url' => ($data[2]) );

    // Tipos de entradas
    $sql = "SELECT glt05_codigo, glt05_desc FROM `glt05_tipos`;";
    $res = query($sql);

    while ($data = mysqli_fetch_array($res))
      $aRtn[Tipos][] = array( 'id'   =>  $data[0],
                              'desc' => ($data[1]) );

    // Ramais / Atendentes
    $sql = "SELECT glt10_ramal, glt10_atendente FROM `glt10_ramais`;";
    $res = query($sql);

    while ($data = mysqli_fetch_array($res))
      $aRtn[Ramais][] = array( 'id'   =>  $data[0],
                               'desc' => ($data[1]) );

    // Datas em que hoveram entradas
    $sql = "SELECT DISTINCT EXTRACT(YEAR_MONTH FROM `glt15_data`) FROM `glt15_registros` ORDER BY 1 desc;";
    $res = query($sql);

    while ($data = mysqli_fetch_array($res))
      $aRtn[Datas][] = array( 'data'   =>  ($data[0]) );

    return Array(code => 0, data => $aRtn, msg => "glt_dash_combos");
}




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
                        'periodo'      => $data->periodo,
                        'sigla'      => $data->glt07_sigla,
                        'glt10_ramal'  => $data->glt10_ramal,
                        'glt10_atendente' => htmlspecialchars($data->glt10_atendente),
                        'glt05_tipo'   => $data->glt05_tipo,
                        'glt05_desc'   => utf8_decode($data->glt05_desc),
                        'qtd'          => $data->qtd
                    );
      $iQtd++;
  }

   return Array(code => $iQtd, data => $aRtn, msg => "glt_dash_resumo1()");
}




//***
function glt_dash_resumo2(){

  $sSql = "SELECT `glt07_sigla`, EXTRACT(YEAR_MONTH FROM `glt15_data`) as periodo, `glt05_tipo`, glt05_desc, count(`glt07_sigla`) as qtd
           FROM glt15_registros, glt05_tipos
           WHERE glt05_tipo = glt05_codigo
           AND (glt15_hora > '09:00:00' AND glt15_hora < '18:30:00')
           GROUP BY 1, 2, 3, 4
           ORDER BY glt07_sigla, periodo desc, qtd desc, glt10_ramal";

  $res = query( $sSql );

  $aRtn = [];
  $iQtd = 0;

  while ($data = mysqli_fetch_object($res)) {
      $aRtn[] = array(
                        'sigla'      => $data->glt07_sigla,
                        'periodo'      => $data->periodo,
                        'glt05_tipo'   => $data->glt05_tipo,
                        'glt05_desc'   => utf8_decode($data->glt05_desc),
                        'qtd'          => $data->qtd
                    );
      $iQtd++;
  }

   return Array(code => $iQtd, data => $aRtn, msg => "glt_dash_resumo1()");
}





//***
// Ligações recebidas
function glt_dash_resumo3(){

  $sSql = "SELECT distinct `glt07_sigla`, EXTRACT(YEAR_MONTH FROM `glt15_data`) as periodo,
                  glt05_tipo, `glt10_ramal`, `glt10_atendente`, count(`glt07_sigla`) as qtd
           FROM glt15_registros, glt05_tipos
           WHERE glt05_tipo = glt05_codigo
           AND (glt15_hora > '09:00:00' AND glt15_hora < '18:30:00')
           AND glt05_tipo IN (1, 2)
           GROUP BY 1, 2, 3, 5
           ORDER BY glt07_sigla, periodo desc, qtd desc";

  $res = query( $sSql );

  $aRtn = [];
  $iQtd = 0;

  while ($data = mysqli_fetch_object($res)) {
      $aRtn[] = array(
                        'sigla'      => $data->glt07_sigla,
                        'periodo'      => $data->periodo,
                        'periodo_desc' => formataPeriodo($data->periodo),
                        'glt10_ramal'  => $data->glt10_ramal,
                        'glt10_atendente' => htmlspecialchars($data->glt10_atendente),
                        'glt05_tipo'   => $data->glt05_tipo,
                        'qtd'          => $data->qtd
                    );
      $iQtd++;
  }

   return Array(code => $iQtd, data => $aRtn, msg => "glt_dash_resumo3()");
}



//***
// Ligações recebidas
function glt_dash_resumo4(){

  $sSql = "SELECT glt07_sigla, EXTRACT(YEAR_MONTH FROM `glt15_data`) as periodo, glt05_tipo, count(glt05_tipo) as qtd
            FROM glt15_registros
            WHERE glt05_tipo IN (1,2)
            AND (glt15_hora > '09:00:00' AND glt15_hora < '18:30:00')
            GROUP BY 1,2,3
            ORDER BY 1, periodo DESC";

  $res = query( $sSql );

  $aRtn = [];
  $iQtd = 0;
  $iQtdAux = 0;
  $sAux = '';

  while ($data = mysqli_fetch_object($res)) {

     if ($sAux == '')
       $sAux = $data->glt07_sigla;

     if ($sAux != $data->glt07_sigla){
       $sAux = $data->glt07_sigla;
       $iQtdAux = 0;
     }

     if (($sAux == $data->glt07_sigla) && ($iQtdAux >= 6))
        continue;

      $aRtn[] = array(
                        'sigla'        => $data->glt07_sigla,
                        'periodo'      => $data->periodo,
                        'periodo_desc' => formataPeriodo($data->periodo),
                        'glt05_tipo'   => $data->glt05_tipo,
                        'qtd'          => $data->qtd
                    );
      $iQtd++;
      $iQtdAux++;
  }

   return Array(code => $iQtd, data => $aRtn, msg => "glt_dash_resumo4()");
}




//***
// Ligações recebidas
function glt_dash_resumo5($sCidade, $sPeriodo, $sRamal, $sTipo){

  $sSql = "SELECT distinct `glt07_sigla`, `glt15_data`, glt15_hora, glt15_ring,
                  glt15_duracao, glt05_tipo, `glt15_fone`, glt05_desc
           FROM glt15_registros, glt05_tipos
           WHERE glt05_tipo = glt05_codigo
           AND (glt15_hora > '09:00:00' AND glt15_hora < '18:30:00')
           AND  glt07_sigla = '$sCidade'
           AND EXTRACT(YEAR_MONTH FROM `glt15_data`) = '$sPeriodo'
           AND glt10_ramal = '$sRamal'
           AND glt05_tipo = '$sTipo'";

  $res = query( $sSql );

  $aRtn = [];
  $iQtd = 0;

  while ($data = mysqli_fetch_object($res)) {
      $aRtn[] = array(
                        'sigla'  => $data->glt07_sigla,
                        'data'   => $data->glt15_data,
                        'hora'   => $data->glt15_hora,
                        'ring'   => $data->glt15_ring,
                        'duracao'=> $data->glt15_duracao,
                        'tipo'   => $data->glt05_tipo,
                        'tipo_desc'   => $data->glt05_desc,
                        'fone'   => $data->glt15_fone
                    );
      $iQtd++;
  }

   return Array(code => $iQtd, data => $aRtn, msg => 'glt_dash_resumo5()');
}


//***
function formataPeriodo($sData){

  $aMes = array(
                  '01' => 'Jan',
                  '02' => 'Fev',
                  '03' => 'Mar',
                  '04' => 'Abr',
                  '05' => 'Mai',
                  '06' => 'Jun',
                  '07' => 'Jul',
                  '08' => 'Ago',
                  '09' => 'Set',
                  '10' => 'Out',
                  '11' => 'Nov',
                  '12' => 'Dez'
               );

  $sRtn = $aMes[substr($sData, 4, 2)] . ' / ' . substr($sData, 2, 2);

  return $sRtn;
}

 ?>
