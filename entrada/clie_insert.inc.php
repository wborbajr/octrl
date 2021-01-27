<?php
	session_start();

  /* Processos de 'Grupo' */

	$aRtn = Array( code => -1, data => [], msg => "Faltam parâmetros!" );

	// Parameters
  $oObj = $_REQUEST;

	// var_dump($_REQUEST);

	if (!$oObj[CPF_CNPJ]){
		echo ( json_encode($aRtn) );
		exit;
	}

	$bCPF = (strlen($oObj[CPF_CNPJ]) == 14);

	$oObj[DT_CADASTRO] = date('Y-m-d');
	$oObj[STATUS] = 'A';
	$oObj[ID_PAIS] = '1058';
	$oObj[ID_CIDADE] = '4113700';

	$oObj[DT_NASCTO] = '26/11/1970';

	// $sql = "INSERT INTO TB_CLIENTE (ID_CLIENTE, ID_CONVENIO, DT_CADASTRO, NOME, END_CEP, END_TIPO, END_NUMERO, END_LOGRAD, END_BAIRRO, END_COMPLE, DT_PRICOMP, DT_ULTCOMP, CONTATO, STATUS, LIMITE, DDD_RESID, FONE_RESID, DDD_COMER, FONE_COMER, DDD_CELUL, FONE_CELUL, DDD_FAX, FONE_FAX, EMAIL_CONT, EMAIL_NFE, ID_CIDADE, ID_TIPO, ID_FUNCIONARIO, ID_PAIS, MENSAGEM, ID_RAMO, EMAIL_ADIC, OBSERVACAO ) VALUES ( 	'".$oObj[ID_CLIENTE]."', '".$oObj[ID_CONVENIO]."', '".$oObj[DT_CADASTRO]."', '".$oObj[NOME]."', '".$oObj[END_CEP]."', '".
	// $oObj[END_TIPO]."', '".$oObj[END_NUMERO]."', '".$oObj[END_LOGRAD]."', '".$oObj[END_BAIRRO]."', '".$oObj[END_COMPLE].
	// "', '".$oObj[DT_PRICOMP]."', '".$oObj[DT_ULTCOMP]."', '".$oObj[CONTATO]."', '".$oObj[STATUS]."', '".$oObj[LIMITE].
	// "', '".$oObj[DDD_RESID]."', '".$oObj[FONE_RESID]."', '".$oObj[DDD_COMER]."', '".$oObj[FONE_COMER]."', '".$oObj[DDD_CELUL].
	// "', '".$oObj[FONE_CELUL]."', '".$oObj[DDD_FAX]."', '".$oObj[FONE_FAX]."', '".$oObj[EMAIL_CONT]."', '".$oObj[EMAIL_NFE].
	// "', '".$oObj[ID_CIDADE]."',	'".$oObj[ID_TIPO]."', '".$oObj[ID_FUNCIONARIO]."', '".$oObj[ID_PAIS]."', '".$oObj[MENSAGEM].
	// "', '".$oObj[ID_RAMO]."', '".$oObj[EMAIL_ADIC]."', '".$oObj[OBSERVACAO]."'";

	$sql = "INSERT INTO TB_CLIENTE (ID_CLIENTE, DT_CADASTRO, NOME, END_CEP, END_TIPO, END_NUMERO, END_LOGRAD, END_BAIRRO, END_COMPLE, CONTATO,  STATUS, DDD_RESID, FONE_RESID, DDD_COMER, FONE_COMER, DDD_CELUL, FONE_CELUL, EMAIL_CONT, EMAIL_ADIC, EMAIL_NFE, ID_FUNCIONARIO, ID_CIDADE, ID_PAIS ) VALUES (0, '".$oObj[DT_CADASTRO]."', '".$oObj[NOME]."', '".$oObj[END_CEP]."', '".$oObj[END_TIPO]."', '".$oObj[END_NUMERO]."', '".
	$oObj[END_LOGRAD]."', '".$oObj[END_BAIRRO]."', '".$oObj[END_COMPLE]."', '".$oObj[CONTATO]."', '".$oObj[STATUS]."', '".
	$oObj[DDD_RESID]."', '".$oObj[FONE_RESID]."', '".$oObj[DDD_COMER]."', '".$oObj[FONE_COMER]."', '".$oObj[DDD_CELUL]."', '".
	$oObj[FONE_CELUL]."', '".$oObj[EMAIL_CONT]."', '".$oObj[EMAIL_ADIC]."', '".$oObj[EMAIL_NFE]."', '".$oObj[ID_FUNCIONARIO].
	"', '".$oObj[ID_CIDADE]."', '".
	$oObj[ID_PAIS]."');";


	include_once('../conn.inc.php');

	$res = queryFB($sql);

	if ($res) {
		$sql = "SELECT ID_CLIENTE FROM TB_CLIENTE WHERE NOME = '".$oObj[NOME]."' AND EMAIL_CONT = '".$oObj[EMAIL_CONT]."'";
		$data = queryFB($sql, 1);

		if ($data[ID_CLIENTE]) {
			if ($bCPF) {
				$sql = "INSERT INTO TB_CLI_PF (id_cliente, cpf, identidade, dt_nascto) values ('".
									$data[ID_CLIENTE]."', '".$oObj[CPF_CNPJ]."', '".$oObj[RG_IE]."', '".InverteDA($oObj[DT_NASCTO])."')";
			} else {
				// INSERT INTO TB_CLI_PJ (ID_CLIENTE, CNPJ, NOME_FANTA, INSC_ESTAD, INSC_MUNIC, SOC_GERENTE, IND_IE_DEST, INSC_SUFRAMA
				$sql = "INSERT INTO TB_CLI_PJ (ID_CLIENTE, CNPJ, INSC_ESTAD) values ('".$data[ID_CLIENTE]."', '".$oObj[CPF_CNPJ].
				"', '".$oObj[RG_IE]."')";
			};

			$res = queryFB($sql);

			// if ($res) {
			// 	$res = queryFB($sqlDoc . "('".$data[ID_CLIENTE]."', '".$oObj[CPF_CNPJ]."', '".$oObj[RG_IE]."')");
			// }
		}
	}

	$aRtn[data] = $data;
	$aRtn[code] = 1;
	$aRtn[msg]  = "clie_insert: " . $sql;


  echo ( json_encode($aRtn) );
  exit;





?>
