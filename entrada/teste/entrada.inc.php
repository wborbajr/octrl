<?php
	session_start();

  include_once('../conn.inc.php');

	$sAcao = $_REQUEST['acao'];
	$oObj  = $_REQUEST['obj'];

	$aRtn = $_REQUEST;
	$aRtn = array('retorno' => $_SESSION[sys][login][localidade]);

	switch ($sAcao) {
		case "clie_busca":
			$aRtn = clie_busca($oObj);
			break;

		case "atendenteCarga":
			$aRtn = atendenteCarga();
			break;

		default:
			# code...
			$aRtn = Array(code => -1, data => [], msg => "Informe um parâmetro!");
			break;
	};

	echo json_encode( $aRtn );

exit;
return false;


// *******************
function clie_busca($sValor){
	$oRtn 	 = Array(code => 0, data => [$sValor], msg => "clie_busca()");

	if (!$sValor) {
		return Array(code => -1, data => [$sValor], msg => "ERRO! Documento não informado.");
	}

	$sCampos = "r.ID_CLIENTE, r.DT_CADASTRO, r.NOME, r.END_CEP, r.END_TIPO, r.END_NUMERO, r.END_LOGRAD, r.END_BAIRRO, r.END_COMPLE, r.ID_CIDADE, r.CIDADE, r.UF, r.DT_PRICOMP, r.DT_ULTCOMP, r.CONTATO, r.STATUS, r.LIMITE, r.DDD_RESID, r.FONE_RESID, r.DDD_COMER, r.FONE_COMER, r.DDD_CELUL, r.FONE_CELUL, r.DDD_FAX, r.FONE_FAX, r.EMAIL_CONT, r.EMAIL_NFE, r.OBSERVACAO, r.ID_TIPO, r.DESCRICAO, r.CONVENIO, r.ADICIONAL1, r.ADICIONAL2, r.CNPJ, r.NOME_FANTA, r.INSC_ESTAD, r.INSC_MUNIC, r.SOC_GERENTE, r.CPF, r.IDENTIDADE, r.NOME_PAI, r.NOME_MAE, r.PROFISSAO, r.DT_NASCTO, r.NATUR, r.RENDA, r.LOCAL_TRAB, r.DATA_ADM, r.NOME_CONJU, r.NASC_CONJU, r.CPF_CONJU, r.NUM_DEPEN, r.CASA_PROPR, r.CASA_FINAN, r.ID_PAIS, r.NOME_PAIS, r.VENDEDOR, r.CPF_CNPJ, r.RG_IE, r.MENSAGEM, r.PROX_CONTATO, r.EMAIL_ADIC, r.ID_ESTRANG";
	$aCampos = explode(",",$sCampos);

	$sCondicao = "r.CPF_CNPJ = '$sValor'";
	// $sCondicao = "CPF_CNPJ = '794.839.509-10'";

	$sql = "SELECT $sCampos FROM V_CLIENTES r WHERE $sCondicao;";

	// $sql = "SELECT ID_CLIENTE FROM V_CLIENTES WHERE $sCondicao;";

	$data = queryFB($sql,1);

	// $i = 0;
	// while (list($key, $val) = each($data))
	// {
	  // echo "$key => $val<br>";
		// $aDados[$key] = $val;
		// $aDados[] = array($key => $val);
		// $aDados[$key] = $val;
  // };

	// print_r($aDados);

	// $aDados = array('ID_CLIENTE' => $data[ID_CLIENTE]);
	// for ($i=0; $i < count($aCampos); $i++) {
	// 	$sCampo = $aCampos[$i];
	// 	$aDados[$aCampos[$i]] = array_values($data, $sCampo);
	// }

	// ok
	$aDados[] = array(
		'ID_CLIENTE' => $data[ID_CLIENTE],
		'DT_CADASTRO' => $data[DT_CADASTRO],
		'NOME' => $data[NOME],
		'END_CEP' => $data[END_CEP],
		'END_TIPO' => $data[END_TIPO],
		'END_NUMERO' => $data[END_NUMERO],
		'END_LOGRAD' => $data[END_LOGRAD],
		'END_BAIRRO' => $data[END_BAIRRO],
		'END_COMPLE' => $data[END_COMPLE],
		'ID_CIDADE' => $data[ID_CIDADE],
		'UF' => $data[UF],
		'DT_PRICOMP' => $data[DT_PRICOMP],
		'DT_ULTCOMP' => $data[DT_ULTCOMP],
		'CONTATO' => $data[CONTATO],
		'STATUS' => $data[STATUS],
		'LIMITE' => $data[LIMITE],
		'DDD_RESID' => $data[DDD_RESID],
		'DDD_COMER' => $data[DDD_COMER],
		'FONE_COMER' => $data[FONE_COMER],
		'DDD_CELUL' => $data[DDD_CELUL],
		'FONE_CELUL' => $data[FONE_CELUL],
		'DDD_FAX' => $data[DDD_FAX],
		'FONE_FAX' => $data[FONE_FAX],
		'EMAIL_CONT' => $data[EMAIL_CONT],
		'EMAIL_NFE' => $data[EMAIL_NFE],
		'OBSERVACAO' => $data[OBSERVACAO],
		'ID_TIPO' => $data[ID_TIPO],
		// 'DESCRICAO' => $data[DESCRICAO],
		'CONVENIO' => $data[CONVENIO],
		'ADICIONAL1' => $data[ADICIONAL1],
		'ADICIONAL2' => $data[ADICIONAL2],
		'CNPJ' => $data[CNPJ],
		'NOME_FANTA' => $data[NOME_FANTA],
		'INSC_ESTAD' => $data[INSC_ESTAD],
		'SOC_GERENTE' => $data[SOC_GERENTE],
		'CPF' => $data[CPF],
		'IDENTIDADE' => $data[IDENTIDADE],
		'NOME_PAI' => $data[NOME_PAI],
		'NOME_MAE' => $data[NOME_MAE],
		// 'PROFISSAO' => $data[PROFISSAO],
		'DT_NASCTO' => $data[DT_NASCTO],
		'NATUR' => $data[NATUR],
		'RENDA' => $data[RENDA],
		'LOCAL_TRAB' => $data[LOCAL_TRAB],
		'DATA_ADM' => $data[DATA_ADM],
		'NOME_CONJU' => $data[NOME_CONJU],
		'NASC_CONJU' => $data[NASC_CONJU],
		'CPF_CONJU' => $data[CPF_CONJU],
		'NUM_DEPEN' => $data[NUM_DEPEN],
		'CASA_PROPR' => $data[CASA_PROPR],
		'CASA_FINAN' => $data[CASA_FINAN],
		'ID_PAIS' => $data[ID_PAIS],
		'NOME_PAIS' => $data[NOME_PAIS],
		'VENDEDOR' => $data[VENDEDOR],
		'CPF_CNPJ' => $data[CPF_CNPJ],
		'RG_IE' => $data[RG_IE],
		'MENSAGEM' => $data[MENSAGEM],
		'PROX_CONTATO' => $data[PROX_CONTATO],
		'EMAIL_ADIC' => $data[EMAIL_ADIC],
		'ID_ESTRANG' => $data[ID_ESTRANG]
	);


	// $oRtn[msg] = $sql;
	// $oRtn[data] = json_encode($aDados);

	return Array(code => 1, data => $aDados, msg => "");
};



// *******************
function atendenteCarga(){

	$sql = "SELECT * FROM V_FUNC_ATENDENTE ORDER BY NOME;";

	$res = queryFB($sql);
	$aDados = [];

	$i = 0;
	while($row = ibase_affected_rows($res)) // ibase_fetch_assoc($res, IBASE_TEXT)
	{
		$aDados[] = array(
												'ID_FUNCIONARIO' => $row[0],
												'NOME' => $row[1]
											);
    $i++;
  };

	return Array(code => $i, data => $aDados, msg => "atendenteCarga");
}


?>
