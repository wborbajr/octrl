<?php
	$lifetime = strtotime('+300 minutes', 0);

	session_set_cookie_params($lifetime); // 18000 = 5 horas | Set session cookie duration to 1 hour = 3600
	session_start();

  include_once('../conn.inc.php');

	$sAcao = $_REQUEST['acao'];
	$oObj  = $_REQUEST['obj'];
	$sTipo = $_REQUEST['tipo'];
	// $aItens = json_encode($_REQUEST['itens']);
	$aItens = $_REQUEST['itens'];

	$iAtendente = $_REQUEST['atendente'];
	$sOrigem = $_REQUEST['origem'];


	// Abre conexao com o banco de dados firebird
	$dbh = 0;
	// $dbh = connFB($sLocalidade);


	switch ($sAcao) {
		case "clie_update":
			$aRtn = clie_update($oObj);
			break;

		case "clie_insert":
			$aRtn = clie_insert($oObj);
			break;

		case "clie_busca":
			$aRtn = clie_busca($oObj);
			break;

		case "atendenteCarga":
			$aRtn = atendenteCarga($dbh);
			break;

		case "tecnicoCarga":
			$aRtn = tecnicoCarga($oObj);
			break;

		case "comboTabelaBasica":
			$aRtn = comboTabelaBasica($oObj);
			break;

		case "os_insert":
			$aRtn = os_insert($oObj, $aItens);
			break;

		case "itens_busca":
			$aRtn = itens_busca($oObj, $sTipo);
			break;

		case "getLastOS":
			$aRtn = getLastOS($iAtendente, $sOrigem);
			break;

		default:
			# code...
			$aRtn = Array(code => -1, data => [$_REQUEST], msg => "Informe um parâmetro!");
			break;
	};


	// ibase_close($dbh);

	echo json_encode( $aRtn );

exit;
return false;


function retira_tchuk($aValores){
  $aNaoQuero = Array("'", "+");
	for ($i=0; $i < sizeof($aCampos); $i++) {
		$aValores[$i] = str_replace( $aNaoQuero, " ", trim($aValores[$i]));
	}
	return $aValores;
}


// *******************
function validaData($sData){
	if (substr($sData, 2, 1) == "-") {
		$sData = InverteData($sData);
	}
  return $sData;
}


// *******************
function clie_update($oObj){
	// $oRtn 	 = Array(code => 0, data => $oObj, msg => "clie_update()");
	$oRtn 	 = Array(code => 0, data => $oObj.ID_CLIENTE, msg => "clie_update() - " . oObj[ID_CLIENTE]);

	if (!$oObj)
		return Array(code => -1, data => [$oObj], msg => "ERRO! Documento não informado.");

	$aCampos = array();
	parse_str($oObj, $aCampos);

	$aCampos = retira_tchuk($aCampos);

	// cliente
	$sSqlUpdate = "    NOME           = '".utf8_decode($aCampos[NOME])."'
										,END_CEP        = '".$aCampos[END_CEP]."'
										,END_TIPO       = '".$aCampos[END_TIPO]."'
										,END_NUMERO     = '".$aCampos[END_NUMERO]."'
										,END_LOGRAD     = '".utf8_decode($aCampos[END_LOGRAD])."'
										,END_BAIRRO     = '".utf8_decode($aCampos[END_BAIRRO])."'
										,END_COMPLE     = '".utf8_decode($aCampos[END_COMPLE])."'
										,CONTATO        = '".utf8_decode($aCampos[CONTATO])."'
										,STATUS         = '".$aCampos[STATUS]."'
										,DDD_RESID      = '".trim($aCampos[DDD_RESID])."'
										,FONE_RESID     = '".trim($aCampos[FONE_RESID])."'
										,DDD_COMER      = '".trim($aCampos[DDD_COMER])."'
										,FONE_COMER     = '".trim($aCampos[FONE_COMER])."'
										,DDD_CELUL      = '".trim($aCampos[DDD_CELUL])."'
										,FONE_CELUL     = '".trim($aCampos[FONE_CELUL])."'
										,DDD_FAX        = '".trim($aCampos[DDD_FAX])."'
										,FONE_FAX       = '".trim($aCampos[FONE_FAX])."'
										,EMAIL_CONT     = '".trim($aCampos[EMAIL_CONT])."'
										,EMAIL_NFE      = '".trim($aCampos[EMAIL_NFE])."'
										,EMAIL_ADIC     = '".trim($aCampos[EMAIL_ADIC])."'
										,ID_CIDADE      = '".$aCampos[ID_CIDADE]."'
										,ID_PAIS        = '".$aCampos[ID_PAIS]."'
										,MENSAGEM       = '".utf8_decode($aCampos[MINHAMENSAGEM])."'
										,OBSERVACAO     = '".utf8_decode($aCampos[MINHAOBSERVACAO])."'";

	// $oRtn[data] = $aCampos;
	$oRtn[code] = sizeof($aCampos);

	$sql = "UPDATE tb_cliente SET $sSqlUpdate WHERE ID_CLIENTE = $aCampos[ID_CLIENTE];";
	$res = qPrepare($sql);

	$oRtn[msg] = "clie_update -> [".$sql."]" ;

	return $oRtn;
}


//
function rt_especial($valor){

    $string = $valor;
    $separa = explode(" ", $string); // quebra a string nos espaços
    $count = count($separa); // quantidade de separações

    $arrayok = array();

    for($i=0; $i<= $count; $i++)
    {
        // Pego toda palavra que começa com \' e substituo por "
        $string2 = ereg_replace("^([/\'])", '"',$separa[$i]);
        $string3 = str_replace("\',", '",', $string2);
        $string4 = str_replace("\',", '",', $string3);

        $string5 = ereg_replace('^([/""])', '"',$string4);
        $string6 = ereg_replace('([/""])$', '"',$string5);

        //Pego toda palavra que termina com \' e substituo por "
        $string = ereg_replace("([/\'])$", '"',$string6);
        $string7 = str_replace('"\'', '"', $string);
        $string8 = str_replace("\'\"", '"', $string7);
        $string9 = str_replace('\"', '"', $string8);


        $arrayok[$i] = $string9;

    }

    $ccp = implode(' ', $arrayok);

    return trim($ccp);
}




// ***************************
function clie_insert($oObj){
	$oRtn 	 = Array(code => 0, data => [], msg => "clie_insert()");

	if (!$oObj)
		return Array(code => -1, data => [$oObj], msg => "ERRO! Documento não informado.");
// 02880565316

	$aCampos = array();
	parse_str($oObj, $aCampos);

	// $aCampos = retira_tchuk($aCampos);

	$sNome = $aCampos[NOME];

	// CÓDIGO IGUAL A ZERO PARA NOVO CLIENTE
	$sqlInsert = "INSERT INTO TB_CLIENTE (".
							 "ID_CLIENTE, DT_CADASTRO, NOME, END_CEP, END_TIPO, END_NUMERO, END_LOGRAD, END_BAIRRO, END_COMPLE, CONTATO, STATUS, DDD_RESID, FONE_RESID, DDD_COMER, FONE_COMER, DDD_CELUL, FONE_CELUL, DDD_FAX, FONE_FAX, EMAIL_CONT, EMAIL_NFE, ID_CIDADE, ID_PAIS, MENSAGEM, EMAIL_ADIC, OBSERVACAO, ID_FUNCIONARIO) VALUES (0, '".
									dmaTOamd($aCampos[DT_CADASTRO])."', '".utf8_decode($sNome)."', '".$aCampos[END_CEP]."', '".$aCampos[END_TIPO]."', '".$aCampos[END_NUMERO].
									"', '".utf8_decode($aCampos[END_LOGRAD])."', '".utf8_decode($aCampos[END_BAIRRO])."', '".utf8_decode($aCampos[END_COMPLE]).
									"', '".utf8_decode($aCampos[CONTATO])."', '".$aCampos[STATUS]."', '".$aCampos[DDD_RESID]."', '".$aCampos[FONE_RESID].
									"', '".$aCampos[DDD_COMER]."', '".$aCampos[FONE_COMER]."', '".$aCampos[DDD_CELUL]."', '".$aCampos[FONE_CELUL].
									"', '".$aCampos[DDD_FAX]."', '".$aCampos[FONE_FAX]."', '".$aCampos[EMAIL_CONT]."', '".$aCampos[EMAIL_NFE].
									"', '".$aCampos[ID_CIDADE]."', '".$aCampos[ID_PAIS]."', '".utf8_decode($aCampos[MINHAMENSAGEM]).
									"', '".$aCampos[EMAIL_ADIC]."', '".utf8_decode($aCampos[MINHAOBSERVACAO])."', ".$aCampos[ID_FUNCIONARIO].
						" )";


  $res = queryFB($sqlInsert);
	$oRtn[error] = $res;

	if ($res) // -> grava
		$oRtn[code] = 1;

	// Resgata id cliado para o novo cliente, a partir de alguns dados únicos
	$sqlSelect = "SELECT ID_CLIENTE FROM TB_CLIENTE
								 WHERE NOME = '".$aCampos[NOME]."'
								 	 AND STATUS = 'A'
									 AND DT_CADASTRO = '".dmaTOamd($aCampos[DT_CADASTRO])."'
									 AND ID_FUNCIONARIO = '".$aCampos[ID_FUNCIONARIO]."'
									 AND EMAIL_CONT = '".$aCampos[EMAIL_CONT]."' ".
							 " ORDER BY ID_CLIENTE DESC;";
	$data = queryFB($sqlSelect, 1); // --> recupera código do cliente

	if ($data)
		$oRtn[code] = 2;

	if ($data[ID_CLIENTE]) {
			$oRtn[code] = 2.5;

			// Cadastra cliente em tb_cli_pf ou tb_cli_pj antes, para obter o cóodigo
			if (strlen($aCampos[CPF_CNPJ]) == 14) {
					$sql = "INSERT INTO TB_CLI_PF (ID_CLIENTE, CPF, IDENTIDADE, DT_NASCTO) VALUES (".$data[ID_CLIENTE].", '".$aCampos[CPF_CNPJ]."', '".$aCampos[RG_IE]."', '".dmaTOamd($aCampos[DT_NASCTO])."');";

				  if (dmaTOamd($aCampos[DT_NASCTO]) == "")
						$sql = "INSERT INTO TB_CLI_PF (ID_CLIENTE, CPF, IDENTIDADE) VALUES (".$data[ID_CLIENTE].", '".$aCampos[CPF_CNPJ]."', '".$aCampos[RG_IE]."');";

					$oRtn[code] = 2.6;
			} else {
					$sql = "INSERT INTO TB_CLI_PJ (ID_CLIENTE, CNPJ, NOME_FANTA, INSC_ESTAD, INSC_MUNIC, SOC_GERENTE) VALUES (".$data[ID_CLIENTE].", '".$aCampos[CPF_CNPJ]."', '".$aCampos[RG_IE]."', '".dmaTOamd($aCampos[DT_NASCTO])."', '".$aCampos[NOME]."');";
					$oRtn[code] = 2.7;
			}
			// @queryFB($sql); // -> grava
			// $oRtn[code] = 3;
			$res = queryFB($sql);
			$oRtn[error] = $res;
	}

  $oRtn[msg] = "clie_insert -> [".$sqlInsert." | select: ".$sqlSelect." | insert: ".$sql."]" ;

  return $oRtn;
}



// *******************
function clie_busca($sValor){
	$oRtn 	 = Array(code => 0, data => [$sValor], msg => "clie_busca()");

	if (!$sValor) {
		return Array(code => -1, data => [$sValor], msg => "ERRO! Documento não informado.");
	}

	// 10403494478

	$sCampos = "ID_CLIENTE, DT_CADASTRO, NOME, END_CEP, END_TIPO, END_NUMERO, END_LOGRAD, END_BAIRRO, END_COMPLE, ID_CIDADE, CIDADE, UF, DT_PRICOMP, DT_ULTCOMP, CONTATO, STATUS, LIMITE, DDD_RESID, FONE_RESID, DDD_COMER, FONE_COMER, DDD_CELUL, FONE_CELUL, DDD_FAX, FONE_FAX, EMAIL_CONT, EMAIL_NFE, OBSERVACAO, ID_TIPO, DESCRICAO, CONVENIO, ADICIONAL1, ADICIONAL2, CNPJ, NOME_FANTA, INSC_ESTAD, INSC_MUNIC, SOC_GERENTE, CPF, IDENTIDADE, NOME_PAI, NOME_MAE, PROFISSAO, DT_NASCTO, NATUR, RENDA, LOCAL_TRAB, DATA_ADM, NOME_CONJU, NASC_CONJU, CPF_CONJU, NUM_DEPEN, CASA_PROPR, CASA_FINAN, ID_PAIS, NOME_PAIS, VENDEDOR, CPF_CNPJ, RG_IE, MENSAGEM, PROX_CONTATO, EMAIL_ADIC, ID_ESTRANG";
	$aCampos = explode(",",$sCampos);

		$sCondicao = "CPF_CNPJ = '$sValor' AND STATUS = 'A'";
	// $sCondicao = "CPF_CNPJ = '794.839.509-10'";

	$sql = "SELECT $sCampos FROM V_CLIENTES WHERE $sCondicao;";

	// $sql = "SELECT ID_CLIENTE FROM V_CLIENTES WHERE $sCondicao;";

	$data = queryFB($sql,1);

	// ok
	$aDados[] = array(
		'ID_CLIENTE' => $data[ID_CLIENTE],
		'DT_CADASTRO' => InverteData($data[DT_CADASTRO]),
		'NOME' => utf8_encode($data[NOME]),
		'END_CEP' => $data[END_CEP],
		'END_TIPO' => $data[END_TIPO],
		'END_NUMERO' => $data[END_NUMERO],
		'END_LOGRAD' => utf8_encode($data[END_LOGRAD]),
		'END_BAIRRO' => utf8_encode($data[END_BAIRRO]),
		'END_COMPLE' => utf8_encode($data[END_COMPLE]),
		'ID_CIDADE' => $data[ID_CIDADE],
		'CIDADE' => utf8_encode($data[CIDADE]),
		'UF' => $data[UF],
		'DT_PRICOMP' => InverteData($data[DT_PRICOMP]),
		'DT_ULTCOMP' => InverteData($data[DT_ULTCOMP]),
		'CONTATO' => utf8_encode($data[CONTATO]),
		'STATUS' => $data[STATUS],
		'LIMITE' => $data[LIMITE],
		'DDD_RESID' => trim($data[DDD_RESID]),
		'FONE_RESID' => trim($data[FONE_RESID]),
		'DDD_COMER' => trim($data[DDD_COMER]),
		'FONE_COMER' => trim($data[FONE_COMER]),
		'DDD_CELUL' => trim($data[DDD_CELUL]),
		'FONE_CELUL' => trim($data[FONE_CELUL]),
		'DDD_FAX' => trim($data[DDD_FAX]),
		'FONE_FAX' => trim($data[FONE_FAX]),
		'EMAIL_CONT' => $data[EMAIL_CONT],
		'EMAIL_NFE' => $data[EMAIL_NFE],
		'ID_TIPO' => $data[ID_TIPO],
		'CONVENIO' => $data[CONVENIO],
		// 'ADICIONAL1' => format_data($data[ADICIONAL1]),
		// 'ADICIONAL2' => format_data($data[ADICIONAL2]),
		'CNPJ' => $data[CNPJ],
		// 'NOME_FANTA' => rt_especial(format_data($data[NOME_FANTA])),
		'INSC_ESTAD' => format_data($data[INSC_ESTAD]),
		// 'SOC_GERENTE' => rt_especial(format_data($data[SOC_GERENTE])),
		'CPF' => $data[CPF],
		'IDENTIDADE' => $data[IDENTIDADE],
		// 'NOME_PAI' => rt_especial(format_data($data[NOME_PAI])),
		// 'NOME_MAE' => rt_especial(format_data($data[NOME_MAE])),
		// 'PROFISSAO' => format_data($data[PROFISSAO]),  // ******
		'DT_NASCTO' => InverteData($data[DT_NASCTO]),
		// 'NATUR' => rt_especial(format_data($data[NATUR])),
		'RENDA' => $data[RENDA],
		'LOCAL_TRAB' => $data[LOCAL_TRAB],
		'DATA_ADM' => InverteData($data[DATA_ADM]),
		// 'NOME_CONJU' => rt_especial($data[NOME_CONJU]),
		'NASC_CONJU' => InverteData($data[NASC_CONJU]),
		'CPF_CONJU' => $data[CPF_CONJU],
		'NUM_DEPEN' => $data[NUM_DEPEN],
		'CASA_PROPR' => $data[CASA_PROPR],
		'CASA_FINAN' => $data[CASA_FINAN],
		'ID_PAIS' => ($data[ID_PAIS] == '' ? '1058' : $data[ID_PAIS]),
		'NOME_PAIS' => ($data[NOME_PAIS] == '' ? 'Brasil' : utf8_encode($data[NOME_PAIS])),
		'VENDEDOR' => $data[VENDEDOR],
		'CPF_CNPJ' => $data[CPF_CNPJ],
		'RG_IE' => $data[RG_IE],
		// 'OBSERVACAO' => rt_especial(format_data(trim($data[OBSERVACAO]))), //****
		// 'MENSAGEM' => rt_especial(format_data(trim($data[MENSAGEM]))), //****
		'OBSERVACAO' => utf8_encode(trim($data[OBSERVACAO])), //****
		'MENSAGEM' => utf8_encode(trim($data[MENSAGEM])), //****
		'PROX_CONTATO' => $data[PROX_CONTATO],
		'EMAIL_ADIC' => $data[EMAIL_ADIC],
		'ID_ESTRANG' => $data[ID_ESTRANG]
	);
//734.216.001-63
	return Array(code => 1, data => $aDados, msg => "clie_busca: ");
};


function TxtToBlob($sTxt){
	return htmlentities($sTxt);
}


// INCLUSÃO DE OS
function os_insert($oObj, $aItens){

	$oRtn 	 = '';

	if (!$oObj)
		return Array(code => -1, data => [$oObj], msg => "ERRO! Documento não informado.");

	$aCampos = array();
	parse_str($oObj, $aCampos);

	// $aCampos = retira_tchuk($aCampos);

	$sMsg = '';
	$i = -1;

  $sOS_MAX = '(SELECT NEXT VALUE FOR GEN_TB_DAV_ID FROM RDB$DATABASE)';

  // Grava OS básica
  $sql1 = "INSERT INTO TB_OS (
						ID_OS, ID_CLIENTE, ID_VENDEDOR, DT_OS, HR_OS, DT_ENTREGA, ID_STATUS, OBSERVACAO, ID_MODULO, ID_OSATEND, ID_OBJETO_CONTRATO,
						OBS_INTERNA, ID_TECNICO_RESP
					  ) VALUES ( ".
						"$sOS_MAX, ".
						$aCampos[IDCLIENTE].", ".
						$aCampos[cbAtendente].", '".
						dmaTOamd($aCampos[DT_OS])."', '".
						$aCampos[HR_OS]."', '".
						(dmaTOamd($aCampos[DT_ENTREGA]) == "" ? null : dmaTOamd($aCampos[DT_ENTREGA]))."', ".
						$aCampos[cbSituacao].", '".
						TxtToBlob($aCampos[OS_OBSERVACAO])."', 22, '".
						$aCampos[cbTipoAtendimento].
						"', null, '".
						utf8_decode($aCampos[OS_MENSAGEM])."', ".
						$aCampos[cbTecnico]
						.");";
	$res = qPrepare($sql1); // -> grava
	$oRtn[error][sql][] = $sql1;
	$oRtn[error][res][] = $res;


	// Resgata id cliado para a nova OS, a partir de alguns dados únicos
	$sql = "SELECT ID_OS FROM TB_OS
						WHERE ID_CLIENTE = ".$aCampos[IDCLIENTE].
						" AND DT_OS = '".dmaTOamd($aCampos[DT_OS])."'".
						" AND HR_OS = '".$aCampos[HR_OS]."'".
						" AND ID_VENDEDOR = ".$aCampos[cbAtendente].
						" AND ID_TECNICO_RESP = ".$aCampos[cbTecnico].";";
	$data = queryFB($sql, 1); // --> recupera código do cliente
	$oRtn[error][sql][] = $sql;
	$oRtn[error][res][] = $data;

	if ($data[ID_OS]) {

			// Recupera o nr da última OS gerada
			$sGen = "SELECT MAX(ID_OS) as id FROM TB_OS;";
			// $res = queryFB($sGen, 1);

			$sAux = $res[id];

			// Seta na variável do banco de dados a última OS gerada
			$sGen = "SET GENERATOR GEN_TB_DAV_ID TO " . $sAux;
			// @qPrepare($sGen); // -> grava

			$sMsg = 'Incluiu OS #' . $data[ID_OS];

			// Grava Objetos da OS
			$sql = "INSERT INTO TB_OS_NOME (ID_OS, NOME, CPF_CNPJ)
							VALUES (".
							$data[ID_OS].", '".
							utf8_decode($aCampos[OS_CLIE_NOME])."', '".
							$aCampos[OS_CPF_CNPJ]."');";
			$res = queryFB($sql);
			$oRtn[error][sql][] = $sql;
			$oRtn[error][res][] = $res;


			$sMsg = 'Incluiu TB_OS_NOME #' . $data[ID_OS];

			// Grava Objetos da OS
			$sql = "INSERT INTO TB_OS_OBJETO_OS (ID_OS, ID_OBJETO, IDENT1, IDENT2, IDENT3, IDENT4,
											    IDENT5, DEFEITO, LOCALIZACAO)
							VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? )";

			$aOSIncRtn = os_fb_prepare($sql);
			ibase_execute( $aOSIncRtn[0],
										 $data[ID_OS],
										 utf8_decode($aCampos[cbObjeto]),
										 utf8_decode($aCampos[MODELO]), // ok
										 utf8_decode($aCampos[SERIAL]), // ok
										 $aCampos[ACESSORIOS],
										 utf8_decode($aCampos[PRISMA]),
										 utf8_decode($aCampos[ADICIONAL]),
										 utf8_decode($aCampos[DEFEITO]), // ok
										 utf8_decode($aCampos[LOCALIZACAO])
									);

      if ( !ibase_commit( $aOSIncRtn[1] ) ) {
				  ibase_rollback($aOSIncRtn[1]);
          throw new Exception( 'Unable to commit transaction because: ' . ibase_errmsg(), ibase_errcode() );
      }

			ibase_free_result( $aOSIncRtn[0] );
			ibase_close( $aOSIncRtn[0] );

			$oRtn[error][sql][] = $sql;
			$oRtn[error][res][] = $aOSIncRtn;

			$sMsg .= ' | Incluiu TB_OS_OBJETO_OS #' . $data[ID_OS];

			// Grava todos os ítens da OS
			$sql = "";
			for ($i=0; $i < sizeof($aItens); $i++) {

				$sql = "insert into TB_OS_ITEM (ID_ITEMOS, ID_OS, ID_IDENTIFICADOR, ID_FUNCIONARIO, ITEM_CANCEL, QTD_ITEM, VLR_UNIT, VLR_DESC, VLR_TOTAL, DT_LACTO, CASAS_QTD,
				CASAS_VLR, ST, DT_ITEM, HR_ITEM) VALUES ( 0,"
					 .$data[ID_OS].", "
				   .$aItens[$i]['ID_IDENTIFICADOR'].", "
					 .$aCampos[cbTecnico].", "
					 ."'N', "
				 .$aItens[$i]['ITEM_QTD'].", "
				 .$aItens[$i]['PRC_VENDA'].", "
				 .$aItens[$i]['ITEM_VALOR_DESC'].", "
				 .$aItens[$i]['ITEM_VALOR_TOTAL'].", '"
				 .InverteData($aCampos[DT_OS])."', 2, 2, 'T', '"
				 .InverteData($aCampos[DT_OS])."', '".date('H:i:s')."' "
				 .");";

				// Grava, efetivamente, os ítens na OS
				// @queryFB($sql); // -> grava
				$res = queryFB($sql);
				$oRtn[error][sql][item][] = $sql;
				$oRtn[error][res][item][] = $res;

				$sMsg .= " " . $sql;
			}


			$sMsg .= " | Incluiu ($i) ITENS ";

			$i = 1;

	} else $sMsg .= 'ERRO!! Não incluiu OS para o cliente #' . $aCampos[ID_CLIENTE] . " | sql: " . $sql;

	// getLastOS();

	return Array(code => $data[ID_OS], data => $oRtn, msg => $sMsg . " | sql: " . $sql);
}


function os_fb_prepare($sql, $aValues = [], $sLocal = ''){

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

	      // insert ou update
	      $qh = ibase_prepare($th, $sql);
				// ibase_execute( $qh, $aValues );

				if ( !$qh ) {
	          throw new Exception( 'Unable to process query because: ' . ibase_errmsg(), ibase_errcode() );
	      }

	  } catch ( Exception $e ) {
				ibase_rollback($th);

				ibase_free_result( $qh );
				ibase_close( $dbh );

	      echo "Caught exception [$sql]: $e\n";
				return -1;

	  }

		return Array($qh, $th);
}


// *******************
function comboTabelaBasica($oObj){
	$sTabela  = $oObj[0];
	$sCampos  = $oObj[1];
	$sDefault = $oObj[2];
	$aCampos  = explode(",",$sCampos);

	// return $oObj;

	$sql = "SELECT $aCampos[0] AS ID, $aCampos[1] AS DESC FROM $sTabela ORDER BY 2;";

	//Executa a instrução SQL
	$res = queryFB($sql);

	$aDados = [];
	$sRtn = '';

	$i = 0;
	while($row = ibase_fetch_object($res, IBASE_TEXT)) // ibase_fetch_assoc($res, IBASE_TEXT)
	{
		$bSelected = '';
		if ($sDefault!='') {
			$bSelected = ($sDefault == $row->ID) ? 'selected' : '';
		}
		$aDados[] = array(
												$aCampos[0] => $row->ID,
												$aCampos[1] => format_data($row->DESC)
											);
    $i++;
		$sRtn .= "<option value='$row->ID' $bSelected>".format_data($row->DESC)."</option>";
  };

	if ($i==0){
		$sRtn = "<option value=-1>Não encontrado</option>";
	} else {
		if ($sDefault == '') {
			$sRtn = "<option value=''>** Selecione algo **</option>" . $sRtn;
		}
	}

	return Array(code => $i, data => $aDados, msg => $sRtn);
}






// *******************
function atendenteCarga($dbh){
	$sql = "SELECT r.ID_FUNCIONARIO, r.NOME FROM V_FUNC_ATENDENTE r ORDER BY r.NOME;";

	//Executa a instrução SQL
	// $res = ibase_query($sql);
	$res = queryFB($sql);

	$aDados = [];
	$sRtn = '';

	$i = 0;
	while($row = ibase_fetch_object($res, IBASE_TEXT)) // ibase_fetch_assoc($res, IBASE_TEXT)
	{
		$bSelected = ($_SESSION[sys][login][id]==$row->ID_FUNCIONARIO) ? 'selected' : '';
		$aDados[] = array(
												'ID_FUNCIONARIO' => $row->ID_FUNCIONARIO,
												'NOME' => format_data($row->NOME)
											);
    $i++;
		$sRtn .= "<option value='$row->ID_FUNCIONARIO' $bSelected>".format_data($row->NOME)."</option>";
  };

	if ($i==0)
		$sRtn = "<option value=-1>Não encontrado</option>";

	return Array(code => $i, data => $aDados, msg => $sRtn);
}




// *******************
function tecnicoCarga($oObj){
	$sDefault = $oObj[0];

	$sql = "SELECT r.ID_FUNCIONARIO, r.NOME FROM V_FUNC_TECNICO r ORDER BY r.NOME;";

	//Executa a instrução SQL
	$res = queryFB($sql);

	$aDados = [];
	$sRtn = '';
	$sDefault = ($sDefault == "") ? $_SESSION[sys][login][usuario] : $sDefault;

	$i = 0;
	while($row = ibase_fetch_object($res, IBASE_TEXT))
	{
		$bSelected = ($sDefault==$row->NOME) ? 'selected' : '';
		$aDados[] = array(
												'ID_FUNCIONARIO' => $row->ID_FUNCIONARIO,
												'NOME' => format_data($row->NOME)
											);
    $i++;
		$sRtn .= "<option value='$row->ID_FUNCIONARIO' $bSelected>".format_data($row->NOME)."</option>";
  };

	if ($i==0)
		$sRtn = "<option value=-1>Não encontrado</option>";

	return Array(code => $i, data => $aDados, msg => $sRtn);
}



// *******************
function itens_busca($sValor, $sTipo){

		if (($sValor == '') OR (strlen($sValor)<3)) {
			return Array(code => -1, data => [$oObj], msg => "itens_busca -> ERRO! Documento não informado.");
		};

		$sCampos = "ID_IDENTIFICADOR,PROD_SERV,PRC_VENDA,ID_TIPOITEM,TIPO_ITEM";
		$aCampos  = explode(",",$sCampos);
		// $sCampos = "*";

		$sCampoPesq = (($sTipo == '0') ? " AND PROD_SERV CONTAINING '$sValor' " : " AND  ID_IDENTIFICADOR = '$sValor' ");

		$sql = "SELECT $sCampos
						FROM V_ESTOQUE
						WHERE STATUS = 'A'
						AND ID_TIPOITEM IN ('0', '9')
						$sCampoPesq
						ORDER BY PROD_SERV;";
		$res = queryFB($sql);


		$i = 0;
		while($row = ibase_fetch_object($res, IBASE_TEXT)){
			// ok
			$aDados[] = array(
				'ID_IDENTIFICADOR' => $row->ID_IDENTIFICADOR,
				'PROD_SERV' => format_data($row->PROD_SERV),
				'PRC_VENDA' => number_format($row->PRC_VENDA, 2),
				'ID_TIPOITEM' => $row->ID_TIPOITEM,
				'TIPO_ITEM' => format_data($row->TIPO_ITEM),
				'tipo' => (($row->ID_TIPOITEM == 0) ? 'Prod' : 'Serv')
			);
			$i++;
		};

	return Array(code => $i, data => $aDados, msg => "$sql");
}



// *******************

// Retorna array com os numeros das duas ultimas OSs. A geral e a do usuário logado como vendedor
function getLastOS($iAtendente, $sOrigem){

	$iAtendente = ($iAtendente == "") ? $_SESSION[sys][login][id] : $iAtendente;

	// $sql = "SELECT first 1 ID_OS FROM V_OS ORDER BY ID_OS DESC;";
	$sql = "SELECT MAX(ID_OS) ID_OS FROM TB_OS;";
	$dataGeral = queryFB($sql, '1', "$sOrigem");

  if ($iAtendente != '') {
		// $sql = "SELECT first 1 ID_OS FROM V_OS WHERE ID_VENDEDOR = '$iAtendente' ORDER BY ID_OS DESC;";
		$sql = "SELECT MAX(ID_OS) ID_OS FROM TB_OS WHERE ID_VENDEDOR = '$iAtendente';";
    $dataVendedor = queryFB($sql, '1', "$sOrigem");
  }

	// Seta na variável do banco de dados a última OS gerada
	$sGen = "SET GENERATOR GEN_TB_OS_ID TO " . $dataGeral[ID_OS];
	// @queryFB($sGen); // -> grava

	// Seta na variável do banco de dados a última OS gerada
	$sGen = "SET GENERATOR GEN_TB_DAV_ID TO " . $dataGeral[ID_OS];
	// @queryFB($sGen); // -> grava

	return Array(code => 0, data => [vendedor => $dataVendedor[ID_OS], geral => $dataGeral[ID_OS]], msg => "getLastOS");
}



?>
