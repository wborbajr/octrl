<?php
  ini_set('max_execution_time', 30);

  session_start();

  error_reporting(E_ERROR);

  // loginValida();

/*
	Somente funções
*/

function fbQuery($sql, $iArray = '', $sLocal = ''){
  //
  if ($sLocal) {
    $servidor = $_SESSION[sys][FBConn][$sLocal][db];
    $login    = $_SESSION[sys][FBConn][$sLocal][login];
    $senha    = $_SESSION[sys][FBConn][$sLocal][senha];
  } else {
    $servidor = $_SESSION[sys][login][localidade][db];
    $login    = $_SESSION[sys][login][localidade][login];
    $senha    = $_SESSION[sys][login][localidade][senha];
  }

    // if (!$servidor) {
    //   header("location: ../", "_top");
    // }

    //conexão com o banco, se der erro mostrara uma mensagem.
    $cfunc = 'fbird_connect';
    $dbh = $cfunc("$servidor", "$login", "$senha", 'WIN1252', 75, 3, '');

    if (!$dbh) {
      return Array(msg => 'Erro ao conectar. ' . $dbh . ' --- ERROR: ' .  fbird_errmsg());
    }

  	//Executa a instrução SQL
  	// $res = ibase_query($dbh, $sql);
    $res = fbird_query($sql, $dbh);

    if (!$res) {

      fbird_free_result($res);
      fbird_close( $dbh );

      return Array(msg => 'Erro ao executar: ' . $sql . ' --- ERROR: ' .  fbird_errmsg());
      exit;
    }

    if ($iArray) {
      $rtn = fbird_fetch_assoc($res);

      // $rtn = array();
      // while ($row = fbird_fetch_object($res)) {
      //     $rtn[] = trim($row->FNAME);
      // }
    } else $rtn = $res;

    fbird_free_result($res);
    fbird_close( $dbh );

  return $rtn;
}




function queryFB($sql, $iArray = '', $sLocal = ''){
  //
  if ($sLocal) {
    $servidor = $_SESSION[sys][FBConn][$sLocal][db];
    $login    = $_SESSION[sys][FBConn][$sLocal][login];
    $senha    = $_SESSION[sys][FBConn][$sLocal][senha];
  } else {
    $servidor = $_SESSION[sys][login][localidade][db];
    $login    = $_SESSION[sys][login][localidade][login];
    $senha    = $_SESSION[sys][login][localidade][senha];
  }

    // if (!$servidor) {
    //   header("location: ../", "_top");
    // }

    //conexão com o banco, se der erro mostrara uma mensagem.
    if (!($dbh=ibase_connect("$servidor", "$login", "$senha", "WIN1252", 0, 3)))
      die('Erro ao conectar: ' .  ibase_errmsg());

  	//Executa a instrução SQL
  	$res = ibase_query($dbh, $sql);

    if (!$res) {
      return Array(msg => 'Erro ao executar: ' . $sql . ' --- ERROR: ' .  ibase_errmsg());
      exit;
    }

    if ($iArray) {
      //gera um loop com as linhas encontradas
      $rtn = ibase_fetch_assoc($res, IBASE_TEXT);
    } else $rtn = $res;

    // ibase_close($dbh);

  return $rtn;
}

function qPrepare($sql, $iArray = '', $sLocal = ''){

  if ($sLocal == '') {
    $db_path = $_SESSION[sys][login][localidade][db];
    $db_user = $_SESSION[sys][login][localidade][login];
    $db_pass = $_SESSION[sys][login][localidade][senha];
  } else {
    $db_path = $_SESSION[sys][FBConn][$sLocal][db];
    $db_user = $_SESSION[sys][FBConn][$sLocal][login];
    $db_pass = $_SESSION[sys][FBConn][$sLocal][senha];
  }

  // use php error handling
  try {
      $dbh = ibase_connect( $db_path, $db_user, $db_pass, "None", 0, 3 );
      // Failure to connect
      if ( !$dbh ) {
          throw new Exception( 'Failed to connect to database because: ' . ibase_errmsg(), ibase_errcode() );
      }

      $th = ibase_trans( $dbh, IBASE_READ+IBASE_COMMITTED+IBASE_REC_NO_VERSION);
      if ( !$th ) {
          throw new Exception( 'Unable to create new transaction because: ' . ibase_errmsg(), ibase_errcode() );
      }

      $qs = $sql; // insert ou update
      $qh = ibase_query( $th, $qs );

      if ( !$qh ) {
          throw new Exception( 'Unable to process query because: ' . ibase_errmsg(), ibase_errcode() );
      }

      $rows = array();

      if ($iArray)
        while ( $row = ibase_fetch_object( $qh ) ) {
            $rows[] = $row->NODE;
        }

      $rtn = $rows;

      // $rows[] now holds results. If there were any.

      // Even though nothing was changed the transaction must be
      // closed. Commit vs Rollback - question of style, but Commit
      // is encouraged. And there shouldn't <gasp>used the S word</gasp>
      // be an error for a read-only commit...

      if ( !ibase_commit( $th ) ) {
          throw new Exception( 'Unable to commit transaction because: ' . ibase_errmsg(), ibase_errcode() );
      }

      // Good form would dictate error traps for these next two...
      // ...but these are the least likely to break...
      // and my fingers are getting tired.
      // Release PHP memory for the result set, and formally
      // close the database connection.
      ibase_free_result( $qh );
      ibase_close( $dbh );
  } catch ( Exception $e ) {
      ibase_rollback($th);
      echo "Caught exception [$sql]: $e\n";
  }

  return $rtn;
}

function queryFB2 ($sql) {
  $servidor = $_SESSION[sys][login][localidade][db];
  $login    = $_SESSION[sys][login][localidade][login];
  $senha    = $_SESSION[sys][login][localidade][senha];

  // if (!$servidor) {
  //   header("location: ../", "_top");
  // }

  //conexão com o banco, se der erro mostrara uma mensagem.
  if (!($dbh=ibase_connect("$servidor", "$login", "$senha", "None", 0, 3)))
    die('Erro ao conectar: ' .  ibase_errmsg());

  //Executa a instrução SQL
  $rid = ibase_query($dbh, $sql);

    if ($rid===false) errorHandle(ibase_errmsg(),$sql);
    $coln = ibase_num_fields($rid);
    $blobFields = array();
    for ($i=0; $i < $coln; $i++) {
        $col_info = ibase_field_info($rid, $i);
        if ($col_info["type"]=="BLOB") $blobFields[$i] = $col_info["name"];
    }
    while ($row = ibase_fetch_row ($rid)) {
        foreach ($blobFields as $field_num=>$field_name) {
            $blobid = ibase_blob_open($row[$field_num]);
            $row[$field_num] = ibase_blob_get($blobid,102400);
            ibase_blob_close($blobid);
        }
        $dataArr[] = $row;
    }
    ibase_close ($connection);
    return $dataArr;
}


/*


INCLUSAO BASICA DO CLIENTE
--------------------------


insert into TB_CLIENTE
(id_cliente, NOME, id_pais, id_cidade, status)
values
(3,'XPTO','1058','4113700','A')

INCLUSAO DO CPF NA TABELA CPF RELATIVA AO CLIENTE
-------------------------------------------------

insert into TB_CLI_PF
(id_cliente, cpf)
values
(3,'064.969.059-16')



INCLUSAO DA OS
--------------

insert into TB_OS
(ID_OS, ID_CLIENTE, ID_VENDEDOR, ID_STATUS, ID_TECNICO_RESP)
values
(2,2,1,1,0)

INCLUSAO DO ITEM DA OS
----------------------

INSERT INTO TB_OS_ITEM
(ID_ITEMOS,ID_IDENTIFICADOR,ID_OS,ITEM_CANCEL,VLR_UNIT)
VALUES
(10,1,2,'N',3.99)


UPDATE TB_OS_ITEM
SET QTD_ITEM = 2.00
WHERE ID_ITEMOS = 10



INCLUSAO DO OBJETO NA OS JA CRIADA
----------------------------------

insert into TB_OS_OBJETO_OS
(ID_OS, ID_OBJETO,DEFEITO)
VALUES
(2,1,'defeito manual')


ATUALIZCAO DA GERAL DA OS
--------------------------

UPDATE TB_OS
SET OBSERVACAO = 'KAKAKAKAKAKAKAK'
WHERE ID_OS = 3 AND ID_CLIENTE = 3






--------- INCLUSAO 100% MANUAL -------------



insert into TB_CLIENTE
(id_cliente, NOME, id_pais, id_cidade, status)
values
(100,'XPTO','1058','4113700')

insert into TB_CLI_PF
(id_cliente, cpf)
values
(100,'064.969.059-19')

insert into TB_OS
(ID_OS, ID_CLIENTE, ID_VENDEDOR, ID_STATUS, ID_TECNICO_RESP)
values
(100,100,1,1,0)

INSERT INTO TB_OS_ITEM
(ID_ITEMOS,ID_IDENTIFICADOR,ID_OS,ITEM_CANCEL,VLR_UNIT)
VALUES
(100,1,100,'N',3.99)

UPDATE TB_OS_ITEM
SET QTD_ITEM = 6.00
WHERE ID_ITEMOS = 100

insert into TB_OS_OBJETO_OS
(ID_OS, ID_OBJETO,DEFEITO)
VALUES
(100,1,'defeito manual')


UPDATE TB_OS
SET OBSERVACAO = 'deu boa'
WHERE ID_OS = 100 AND ID_CLIENTE = 100



CORRIGINDO CPF

UPDATE TB_CLI_PF
SET CPF = '377.093.175-02'
WHERE Id_cliente = 100





*/


// Esta função se conecta, executa o sql e encerra a conexão
function query($sql, $iArray = '') {

	loginValida();

  $bMySQLi = 1;
  $local = 0; // local (1) ou internet (0)

  if ($local) {
		$host="localhost";
		$user="root";
		$pass="#senha";
		$database = "omni_gelite";
  } else {
		$host="192.168.0.4"; // url do banco na rede
		$user="root"; // usuario do banco da rede
		$pass="@senha"; // senha do usuário na rede
		$database = "omni_pear"; // nome do banco de dados
  }


	if ($bMySQLi) {

		$mysqli = new mysqli($host, $user, $pass, $database);

		if ($mysqli->errno)
			die("Unable to connect to the database:<br />" . $mysqli->error);

		$res = $mysqli->query($sql);

		if ($iArray) {
			$rtn = $res->fetch_array();

		} else $rtn = $res;

		$mysqli->close();

	} else {

		$db = mysql_connect( $host, $user, "$pass") or die("Erro!! ".mysql_error());
		mysql_select_db("$database", $db) or die("Erro!! ".mysql_error());

		// Definindo o charset como utf8 para evitar problemas com acentuação
		$charset = mysql_set_charset('utf8');

		//  if (mysql_error()) {  }

		$rtn = mysql_query($sql, $db) or die("ERRO!<hr>$sql<hr>".mysql_error());

		if ($rtn)
		if ($iArray!='') $rtn = mysql_fetch_array($rtn);

		mysql_close($db);

	}

	return $rtn;
}


function padzeros($sTxt, $iQtd = 2) {
	$sTxt = trim( $sTxt );
	// $iLen = strlen( $sTxt ) +$iQtd;
	// $sRtn = '000000000000000000'.$sTxt;
	// $sRtn = substr($sRtn, -$iQtd, $iQtd);
	// return $sRtn;
  return str_pad( $sTxt, $iQtd, '0', STR_PAD_LEFT );
}

function InverteData($sData){
	// return substr($sData, 6, 4) . '-' . substr($sData, 3, 2) . '-' . substr($sData, 0, 2);
  list($sD1, $sD2, $sD3) = split('[/.-]', $sData);
  if ("$sD3-$sD2-$sD1" == "--")
   return "";
  else
    return "$sD3-$sD2-$sD1";

}

function loginValida(){
	if (! $_SESSION[sys][login][login] ) header("location: ./login.php");
	return true;
}




//
function format_data($sTxt){
  // return utf8_decode( addslashes( $sTxt ));
  return utf8_encode($sTxt);
	// return $sTxt;
	// return '';
}

//
function format_data_valor($sTxt){
  return number_format( '0'.$sTxt, 2, ',', '');
}

//
function show_data($sTxt){
	echo "<script>$(document).ready(function(){ $sTxt }); </script>";
}


//
function retornaJS($sTxt){
//	echo "<script>$('body').html('<h2 align=center>$sTxt</h2>');</script>";
	echo '0';
}


# Transforma data
# $data_os: String Ymd
# retorna: dmY
function amdTOdma($sData) { // by reiwolf

    if (($sData == '') || ($sData == '--')) {
      return "";
    }

    list($sAno, $sMes, $sDia ) = split('[/.-]', $sData);
    if ("$sDia-$sMes-$sAno" == "--")
     return "";
    else
     return "$sDia-$sMes-$sAno";
}

# Transforma data
# $data_os: String dmY
# retorna: Ymd
function dmaTOamd($sData) { // by reiwolf

    if (($sData == '') || ($sData == '--')) {
      return "";
    }

    list($sDia, $sMes, $sAno) = split('[/.-]', $sData);
    if ("$sAno-$sMes-$sDia" == "--")
      return "";
    else
      return "$sAno-$sMes-$sDia";
}

//
function _ln2br($sTxt){
	$order   = array("\r\n", "\n", "\r");
	$replace = '<br />';
  $sRtn    = str_replace($order, $replace, $sTxt);

	return utf8_encode($sRtn);
}



function log_acesso($usuario, $msg){

	$data = date("d-m-y");
	$hora = date("H:i:s");
	$ip = $_SERVER['REMOTE_ADDR'];

	//Nome do arquivo:
	$arquivo = "logs/Acesso_$data.txt";

	//Texto a ser impresso no log:
	$texto = "[$hora][$ip]> $msg [$usuario]\n";

	$manipular = fopen("$arquivo", "a+b");
	fwrite($manipular, $texto);
	fclose($manipular);

}



function log_acao($msg){

	// $usuario = $_SESSION[login][nome];
  $usuario = $_SESSION[sys][login][usuario] . ' - #' . $_SESSION[sys][login][id];
	$data = date("d-m-y");
	$hora = date("H:i:s");
	$ip = $_SERVER['REMOTE_ADDR'];

	//Nome do arquivo:
	$arquivo = "logs/Acao_$data.txt";

	//Texto a ser impresso no log:
	$texto = "[$hora][$ip]> $msg [$usuario]\n";

	$manipular = fopen("$arquivo", "a+b");
	fwrite($manipular, $texto);
	fclose($manipular);

}


?>
