<?php
include('../conn.inc.php');

$sFonte = "./Bilhetagem_cwb.txt";

$sLocal = substr($sFonte, -7, 3);

echo $sLocal; // cwb

print_r(cargaRegistros($sLocal));

// Informar local... cwb, lnd ou ntl
function cargaRegistros($sLocal){

    // Não encontrado ou url vazia
    if ($sLocal == ''){
      return json_encode(Array(code => -1, data => Array(), msg => "Localidade não informada!"));
    }

    $sLocal = strtolower($sLocal); // minusculo

    // com base no local, localiza na tabela o caminho onde se encontra a fonte de dados txt
    $sSql = "SELECT glt07_sigla, glt07_desc, glt07_url FROM glt07_localidades WHERE glt07_sigla = '$sLocal';";
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
    $lines = file($sFonte);
    $iQtdlines = count($lines);
    $aLinhas = [];

    $iQtd = 0;
    $iTotal = 0;

    // echo "<hr>$iQtdlines<hr>";
    // return false;

    // Percorre o array, mostrando o fonte HTML com numeração de linhas.
    foreach ($lines as $line_num => $line) {
      $line = trim($line);

      if (($line != '') && (strlen($line) == 80) && (substr($line, 0, 4) != 'Date')){

        $iTotal++;
        /*
        $aLinhas[] = InverteDA(substr($line,  0,  8)) .'|'. // data
                     substr($line,  9,  8) .'|'. // hora
                     substr($line, 18,  2) .'|'. // linha entrada
                     substr($line, 21,  4) .'|'. // ramal / atendente
                     substr($line, 33,  5) .'|'. // ring
                     substr($line, 39,  8) .'|'. // tempo
                     substr($line, 48, 20) .'|'. // fone
                     substr($line, 69,  1);      // tipo
        */
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

        // echo $iQtd . ") " . $sql . "<br />";

        if (query($sql))
         ++$iQtd;
      }

    }

    // echo "Chegou até aqui!";
    // return false;



    // echo "Inseridos $iQtd registros novos";
    $aRtn['Total'] = $iQtdlines;
    $aRtn['Analisado'] = $iTotal;
    $aRtn['Update'] = $iQtd;
    return json_encode( $aRtn );

}

?>
