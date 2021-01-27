<?php
/*
	Somente funções
* /
	mb_internal_encoding("UTF-8");
	mb_http_output( "iso-8859-1" );
	header("Content-Type: text/html; charset=ISO-8859-1",true);
*/
	error_reporting(E_ALL ^ E_NOTICE); // Elimita saida de mensagens de erros.
	// error_reporting(0); // Em desenvolvimento, mostra TODAS as mensagens de erro.

// Esta função se conecta, executa o sql e encerra a conexão
function query($sql, $iArray = '') {

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
		$database = "omni_ctrl"; // nome do banco de dados
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
	$iLen = strlen( $sTxt ) +$iQtd;
	$sRtn = '000000000000000000'.$sTxt;
	$sRtn = substr($sRtn, -$iQtd, $iQtd);
	return $sRtn;
}

function InverteDA($sData){
	return substr($sData, 6, 2) . '/' . substr($sData, 3, 2) . '/' . substr($sData, 0, 2);
}


?>
