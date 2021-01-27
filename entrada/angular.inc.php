<?php
	session_start();

  // include_once('../conn.inc.php');

	$sLocalidade = $_SESSION[sys][login][localidade];

	// Abre conexao com o banco de dados firebird
	$dbh = connFB($sLocalidade);

	$data = file_get_contents("php://input");
	//
	$objData = json_decode($data);

	print_r($objData);

	switch ($objData->acao) {

		case "atendenteCarga":
			$aRtn = atendenteCarga($dbh);
			break;

		default:
			# code...
			$aRtn = Array(code => -1, data => [], msg => "Informe um parâmetro!");
			break;
	};


	ibase_close($dbh);

	echo json_encode( $aRtn );

exit;
return false;

// ****************
function connFB($sLocalidade){
	$servidor = $_SESSION[sys][login][localidade][db];
	$login    = $_SESSION[sys][login][localidade][login];
	$senha    = $_SESSION[sys][login][localidade][senha];

	//conexão com o banco, se der erro mostrara uma mensagem.
	if (!($dbh=ibase_connect("$servidor", "$login", "$senha", "None", 0, 3)))
		die('Erro ao conectar: ' .  ibase_errmsg());

	return $dbh;
}



// *******************
function atendenteCarga($dbh){
	return Array(code => $i, data => $aDados, msg => $sRtn);
}

?>
