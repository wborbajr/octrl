<?php
	session_start();

// 	mb_internal_encoding("UTF-8");
//	mb_http_output( "iso-8859-1" );
//	header("Content-Type: text/html; charset=ISO-8859-1",true);

//	error_reporting(0);

	$iOS 		 = $_REQUEST['os'];
	$sOrigem = $_REQUEST['origem'];
	$sPathBase = $_REQUEST['local'];

	// $sPathBase = "/oCtrl/";
	$sPathBase = "../";

	require($sPathBase . 'conn.inc.php');

	$sql = "SELECT *
					From V_OS
					Where ID_OS = $iOS;";
					// echo "eu estou aqui: " . __DIR__;

	//Executa a instrução SQL
	$data_os = queryFB($sql, 1, $sOrigem);

	if ($data_os == '') {
		echo json_encode("OS não encontrada.");
		return false;
	}

	$data_v_os = $data_os;

	//
	$iCliente = $data_os[ID_CLIENTE];

	$sql = "SELECT
					ID_CLIENTE, NOME, END_CEP, END_TIPO, END_NUMERO, END_LOGRAD,
					END_BAIRRO, END_COMPLE, ID_CIDADE, CIDADE, UF, CONTATO,
					STATUS, LIMITE, DDD_RESID, FONE_RESID, DDD_COMER, FONE_COMER,
					DDD_CELUL, FONE_CELUL, DDD_FAX, FONE_FAX, EMAIL_CONT, CONVENIO,
					CNPJ, NOME_FANTA, INSC_ESTAD, INSC_MUNIC, CPF, IDENTIDADE
			FROM V_CLIENTES_RESUMO WHERE ID_CLIENTE = $iCliente;";

	//Executa a instrução SQL
	$data_cliente = queryFB($sql, 1, $sOrigem);


	$aLocalidade = $_SESSION[sys][FBConn][$sOrigem];
	$aData = [];

	// Cabeçalho
	$aData['cab'] 	= $aLocalidade[cabecalho];
	$aData['os_nr'] = substr('000000' . $iOS, -6);
	$aData['local'] = $sOrigem;

	$aData['DT_OS'] = $data_os['DT_OS'];

	$aData['os_antendimento'] = $data_os['ATENDIMENTO'];

	// Não é usado
	$aData['os_responsavel_tecnico'] = $data_os['NOME_TECNICO_RESP'];

	$aData['os_situacao'] = format_data($data_os['DESCRICAO']);

	$aData['os_data'] = $data_os['DT_OS'];
	$aData['os_hora'] = $data_os['HR_OS'];

	$aData['os_cliente'] = format_data($data_cliente['NOME']);
	$aData['os_cnpj'] = ( $data_cliente['CPF'] != '' ?
												$data_cliente['CPF'] :
												$data_cliente['CNPJ'] );

	$aData['os_contato'] = $data_cliente['os_contato'];
	$aData['os_fone'] = $data_cliente['DDD_RESID'] .' '. $data_cliente['FONE_RESID'];
	// $aData['os_rg'] = ( $data_cliente['CPF'] != '' ?
	// 										$data_cliente['IDENTIDADE'] : $data_cliente['INSC_ESTAD'] );
	$aData['os_celular'] = $data_cliente['DDD_CELUL'] .' '. $data_cliente['FONE_CELUL'];
	$aData['os_fone_comercial'] = $data_cliente['DDD_COMER'] .' '. $data_cliente['FONE_COMER'];
  //
	$aData['os_imun'] = $data_cliente['INSC_MUNIC'];
	$aData['os_cep'] = $data_cliente['END_CEP'];
	$aData['os_endereco'] = format_data($data_cliente['END_LOGRAD'] .', '. $data_cliente['END_NUMERO']);
	$aData['os_complemento'] = format_data($data_cliente['END_COMPLE']);
	$aData['os_email'] = "<a href='mailto:".$data_cliente['EMAIL_CONT']."'>".$data_cliente['EMAIL_CONT']."</a>";
	$aData['os_bairro'] = $data_cliente['END_BAIRRO'];
	$aData['os_cidade'] = $data_cliente['CIDADE'] .'/'. $data_cliente['UF'];


	// Objeto
	$aData['os_objeto_id'] = format_data($data_os['ID_OBJETO']);
	$aData['os_objeto_descricao'] = format_data($data_os['OBJETO']);
	$aData['os_objeto_modelo'] = format_data($data_os['IDENT1']);
	$aData['os_objeto_serial'] = format_data($data_os['IDENT2']);
	$aData['os_objeto_acessorio'] = format_data($data_os['IDENT3']);
	$aData['os_objeto_prisma'] = format_data($data_os['IDENT4']);

	$aData['os_problema'] = format_data($data_os['DEFEITO']);
	$aData['os_garantia'] = ($data_v_os[IDENT5] ? $data_v_os[IDENT5] : "&nbsp;&nbsp;&nbsp;");

	// Serviços
	$sql = "select *
					from v_os_item
					where ID_OS = $iOS
					and P_S = 'S'
					order by id_identificador;";

	//Executa a instrução SQL
	$res_item = queryFB($sql, 0, $sOrigem);

	$i = 0;
	$vlr_servicos = 0;

	//gera um loop com as linhas encontradas
	while ($data = ibase_fetch_object ($res_item)) {
		$aData["os_serv_".++$i."1"] = format_data($data->ID_IDENTIFICADOR);
		$aData["os_serv_".$i."2"]   = format_data($data->DESCRICAO);
		$aData["os_serv_".$i."3"] = format_data_valor($data->QTD_ITEM);
		$aData["os_serv_".$i."4"] = format_data_valor($data->UNI_MEDIDA);
		$aData["os_serv_".$i."5"] = format_data_valor($data->VLR_UNITARIO);
		$aData["os_serv_".$i."6"] = format_data_valor($data->VLR_TOTAL);
		$aData["os_serv_".$i."7"] = format_data($data->FUNCIONARIO);
		$vlr_servicos += $data->VLR_TOTAL;
	}


		// PEÇAS
		$sql = "select *
				from v_os_item
				where ID_OS = $iOS
				and P_S <> 'S'
				order by id_identificador;";
	//echo $sql . "<hr/>";

		//Executa a instrução SQL
		$res_item = queryFB($sql, 0, $sOrigem);

		$i = 0;
		$vlr_pecas = 0;

		//gera um loop com as linhas encontradas
		while ($data = ibase_fetch_object ($res_item)) {
			$aData["os_pecas_".++$i."1"] = format_data($data->ID_IDENTIFICADOR);
			$aData["os_pecas_".$i."2"] = format_data($data->DESCRICAO);
			$aData["os_pecas_".$i."3"] = format_data($data->COD_BARRA);
			$aData["os_pecas_".$i."4"] = format_data_valor($data->QTD_ITEM);
			$aData["os_pecas_".$i."5"] = format_data_valor($data->VLR_UNITARIO);
			$aData["os_pecas_".$i."6"] = format_data_valor($data->VLR_TOTAL);
			$aData["os_pecas_".$i."7"] = format_data($data->FUNCIONARIO);
			$vlr_pecas += $data->VLR_TOTAL;
		}

		$aData['os_total_servicos'] = format_data_valor($vlr_servicos);
		$aData['os_total_pecas'] = format_data_valor($vlr_pecas);




		// Totais
		$aData['os_totais_servico'] = format_data_valor($vlr_servicos);
		$aData['os_totais_peca'] = format_data_valor($vlr_pecas);
		$aData['os_totais_frete'] = format_data_valor($data_v_os[VLR_FRETE]);
		$aData['os_totais_geral'] = format_data_valor($data_v_os[VLR_TOTAL]);

		$aData['os_atendente'] = format_data($data_v_os[VENDEDOR]);


		$dt_Entrega = amdTOdma($data_os[DT_RETIRADA]);
		$dt_Entrega = $dt_Entrega == '//' ? "________/________/____________" : $dt_Entrega;
	//	$dt_Entrega = $dt_Entrega == '//' ? "________/________/____________      &agrave;s ______:_______hs." : $dt_Entrega;
		$aData['os_dt_entrega'] = format_data($dt_Entrega);


		$aData['os_observacoes'] = _ln2br($data_os[OBSERVACAO]);


	// Variável de retorno
	$aRtn = Array(code => $iQtd, data => $aData, msg => $sRtn);

	// header('Content-Type: application/json');
	// echo json_encode( $aData );
// return false;

	// header('Content-Type: application/json');
	echo json_encode( $aRtn );

return false;
?>
