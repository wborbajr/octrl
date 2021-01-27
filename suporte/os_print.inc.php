<?php
/*
*
*/

// 	mb_internal_encoding("UTF-8");
//	mb_http_output( "iso-8859-1" );
//	header("Content-Type: text/html; charset=ISO-8859-1",true);

//	error_reporting(0);

	$iOS = $_REQUEST['os'];
  	$sOrigem = $_REQUEST['origem'];
  /*
	if ($iOS == '') {
		retornaJS("Informe o Número da OS.");
		exit;
	}
	*/
	//ibase_connect — Abre uma conexão com um banco de dados InterBase
	//pode ser colocado o IP, ou nome do computador onde esta o banco de dados


 	// curitiba
    if ($sOrigem == 7)
		require( 'conn.inc.php' );

	// londrina
    if ($sOrigem == 9)
		require( 'conn-9.inc.php' );

	// natal
    if ($sOrigem == 1)
		require( 'conn-1.inc.php' );


	//Instruções SQL
	$sql = "Select
				  TB_OS.ID_OS,
				  TB_OS.ID_CLIENTE,
				  TB_OS.ID_VENDEDOR,
				  TB_OS.DT_OS,
				  TB_OS.HR_OS,
				  TB_OS.DT_ENTREGA,
				  TB_OS.COMPRADOR,
				  TB_OS.ID_STATUS,
				  OBSERVACAO,
				  TB_OS.ID_MODULO,
				  TB_OS.ENTREGA,
				  TB_OS.CHAVE,
				  TB_OS.ID_OSATEND,
				  TB_OS.DT_GARANTIA,
				  TB_OS.ID_OBJETO_CONTRATO,
				  TB_OS.DT_RETIRADA
				From
				  TB_OS
				Where ID_OS = $iOS;";
	$sql = "Select
					r.ID_ORIGEM, r.ID_OS, r.DT_OS, r.HR_OS, r.DT_ENTREGA, r.COMPRADOR,
					r.ID_CLIENTE, r.CLIENTE, r.CNPJ_CPF, r.ID_VENDEDOR, r.VENDEDOR, r.ID_STATUS,
					r.DESCRICAO, r.RESERVA, r.OBSERVACAO, r.VLR_PECAS, r.VLR_SERVICOS,
					r.VLR_ITEM, r.VLR_TOTAL, r.ENTREGA, r.CHAVE, r.ID_FORNEC, r.NOME,
					r.VLR_FRETE, r.TIPO_FRETE, r.VAL, r.ID_OBJETO, r.OBJETO, r.DEFEITO,
					r.IDENT1, r.IDENT2, r.IDENT3, r.IDENT4, r.IDENT5, r.ID_MODULO,
					r.DT_GARANTIA, r.ID_OSATEND, r.ATENDIMENTO, r.ID_OBJETO_CONTRATO,
					r.DT_RETIRADA, r.OBS_INTERNA, r.ID_TECNICO_RESP, r.NOME_TECNICO_RESP
				From
				  V_OS r
				Where r.ID_OS = $iOS;";
//echo $sql . "<hr/>";

	//Executa a instrução SQL
	$query= ibase_query ($dbh, $sql);

	//gera um loop com as linhas encontradas
	//$data_os = ibase_fetch_object ($query);
	$data_os = ibase_fetch_assoc($query, IBASE_TEXT);


	if ($data_os == '') {
		retornaJS("OS não encontrada.");
		exit;
	}



	$sql = "SELECT *
			From V_OS
			Where ID_OS = $iOS;";
//echo $sql . "<hr/>";

	//Executa a instrução SQL
	$query= ibase_query ($dbh, $sql);

	//gera um loop com as linhas encontradas
	//$data_os = ibase_fetch_object ($query);
	$data_v_os = ibase_fetch_assoc($query, IBASE_TEXT);


	//
	$iCliente = $data_os[ID_CLIENTE];

/*
	//Instruções SQL
	$sql = "Select
					NOME, ID_CLIENTE, ID_CONVENIO, DT_CADASTRO, END_CEP,
					END_TIPO, END_NUMERO, END_LOGRAD, END_BAIRRO, END_COMPLE,
					DT_PRICOMP, DT_ULTCOMP, CONTATO, STATUS, LIMITE, DDD_RESID,
					FONE_RESID, DDD_COMER, FONE_COMER, DDD_CELUL, FONE_CELUL,
					DDD_FAX, FONE_FAX, EMAIL_CONT, EMAIL_NFE, ID_CIDADE, ID_TIPO,
					ID_FUNCIONARIO, ID_PAIS, MENSAGEM, ID_RAMO, EMAIL_ADIC,
					OBSERVACAO
				From
				  TB_CLIENTE
				Where ID_CLIENTE = $iCliente;";
*/

	$sql = "SELECT
					ID_CLIENTE, NOME, END_CEP, END_TIPO, END_NUMERO, END_LOGRAD,
					END_BAIRRO, END_COMPLE, ID_CIDADE, CIDADE, UF, CONTATO,
					STATUS, LIMITE, DDD_RESID, FONE_RESID, DDD_COMER, FONE_COMER,
					DDD_CELUL, FONE_CELUL, DDD_FAX, FONE_FAX, EMAIL_CONT, CONVENIO,
					CNPJ, NOME_FANTA, INSC_ESTAD, INSC_MUNIC, CPF, IDENTIDADE
			FROM V_CLIENTES_RESUMO WHERE ID_CLIENTE = $iCliente;";
//echo $sql . "<hr/>";

	//Executa a instrução SQL
	$query= ibase_query ($dbh, $sql);

	//gera um loop com as linhas encontradas
	$data_cliente = ibase_fetch_object ($query);



	//$sRtn = "$('#os_antendimento').html('".$data_os[ID_OS]."');";


	// Cabeçalho
	$sRtn .= format_data('os_nr', substr('00000'.$data_os[ID_OS], -5));

	$sRtn .= format_data('os_antendimento', $data_v_os[ATENDIMENTO]);
	$sRtn .= format_data('os_responsavel_tecnico', $data_os[NOME_TECNICO_RESP]);
	$sRtn .= format_data('os_situacao', $data_v_os[DESCRICAO]);

	$sRtn .= format_data('os_data', amdTOdma($data_os[DT_OS]));
	$sRtn .= format_data('os_hora', $data_os[HR_OS]);

	$sRtn .= format_data('os_cliente', $data_cliente->NOME);
	$sRtn .= format_data('os_cnpj', ( $data_cliente->CPF != '' ? $data_cliente->CPF : $data_cliente->CNPJ ));

	$sRtn .= format_data('os_contato', $data_cliente->CONTATO);
	$sRtn .= format_data('os_fone', $data_cliente->DDD_RESID .' '. $data_cliente->FONE_RESID);

	$sRtn .= format_data('os_rg', ( $data_cliente->CPF != '' ? $data_cliente->IDENTIDADE : $data_cliente->INSC_ESTAD ));

	$sRtn .= format_data('os_celular', $data_cliente->DDD_CELUL .' '. $data_cliente->FONE_CELUL);
	$sRtn .= format_data('os_fone_comercial', $data_cliente->DDD_COMER .' '. $data_cliente->FONE_COMER);
	$sRtn .= format_data('os_imun', $data_cliente->INSC_MUNIC);
	$sRtn .= format_data('os_cep', $data_cliente->END_CEP);
	$sRtn .= format_data('os_endereco', $data_cliente->END_LOGRAD .', '. $data_cliente->END_NUMERO);
	$sRtn .= format_data('os_complemento', $data_cliente->END_COMPLE);
	$sRtn .= format_data('os_email', "<a href='mailto:".$data_cliente->EMAIL_CONT."'>".$data_cliente->EMAIL_CONT."</a>");
	$sRtn .= format_data('os_bairro', $data_cliente->END_BAIRRO);
	$sRtn .= format_data('os_cidade', $data_cliente->CIDADE .'/'. $data_cliente->UF);


	// Objeto
	$sRtn .= format_data('os_objeto_id', $data_v_os[ID_OBJETO]);
	$sRtn .= format_data('os_objeto_descricao', $data_v_os[OBJETO]);
	$sRtn .= format_data('os_objeto_modelo', $data_v_os[IDENT1]);
	$sRtn .= format_data('os_objeto_serial', $data_v_os[IDENT2]);
	$sRtn .= format_data('os_objeto_acessorio', $data_v_os[IDENT3]);
	$sRtn .= format_data('os_objeto_prisma', $data_v_os[IDENT4]);

	$sRtn .= format_data('os_problema', $data_v_os[DEFEITO]);
	$sRtn .= format_data('os_garantia', ($data_v_os[IDENT5] ? $data_v_os[IDENT5] : "&nbsp;&nbsp;&nbsp;"));


	// Serviços
	$sql = "select *
			from v_os_item
			where ID_OS = $iOS
			and P_S = 'S'
			order by id_identificador;";
//echo $sql . "<hr/>";

	//Executa a instrução SQL
	$res_item= ibase_query ($dbh, $sql);

	//gera um loop com as linhas encontradas
	$i = 0;
	$vlr_servicos = 0;
	while ($data = ibase_fetch_object ($res_item)) {
		$sRtn .= format_data("os_serv_".++$i."1", $data->ID_IDENTIFICADOR);
		$sRtn .= format_data("os_serv_".$i."2", $data->DESCRICAO);
		$sRtn .= format_data_valor("os_serv_".$i."3", $data->QTD_ITEM);
		$sRtn .= format_data_valor("os_serv_".$i."4", $data->UNI_MEDIDA);
		$sRtn .= format_data_valor("os_serv_".$i."5", $data->VLR_UNITARIO);
		$sRtn .= format_data_valor("os_serv_".$i."6", $data->VLR_TOTAL);
		$sRtn .= format_data("os_serv_".$i."7", $data->FUNCIONARIO);
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
	$res_item= ibase_query ($dbh, $sql);

	//gera um loop com as linhas encontradas
	$i = 0;
	$vlr_pecas = 0;
	while ($data = ibase_fetch_object ($res_item)) {
		$sRtn .= format_data("os_pecas_".++$i."1", $data->ID_IDENTIFICADOR);
		$sRtn .= format_data("os_pecas_".$i."2", $data->DESCRICAO);
		$sRtn .= format_data("os_pecas_".$i."3", $data->COD_BARRA);
		$sRtn .= format_data_valor("os_pecas_".$i."4", $data->QTD_ITEM);
		$sRtn .= format_data_valor("os_pecas_".$i."5", $data->VLR_UNITARIO);
		$sRtn .= format_data_valor("os_pecas_".$i."6", $data->VLR_TOTAL);
		$sRtn .= format_data("os_pecas_".$i."7", $data->FUNCIONARIO);
		$vlr_pecas += $data->VLR_TOTAL;
	}



	$sRtn .= format_data_valor('os_total_servicos', $vlr_servicos);
	$sRtn .= format_data_valor('os_total_pecas', $vlr_pecas);

	// Totais
	$sRtn .= format_data_valor('os_totais_servico', $vlr_servicos);
	$sRtn .= format_data_valor('os_totais_peca', $vlr_pecas);
	$sRtn .= format_data_valor('os_totais_frete', $data_v_os[VLR_FRETE]);
	$sRtn .= format_data_valor('os_totais_geral', $data_v_os[VLR_TOTAL]);

	$sRtn .= format_data('os_atendente', $data_v_os[VENDEDOR]);

	$dt_Entrega = amdTOdma($data_os[DT_RETIRADA]);
	$dt_Entrega = $dt_Entrega == '//' ? "________/________/____________" : $dt_Entrega;
//	$dt_Entrega = $dt_Entrega == '//' ? "________/________/____________      &agrave;s ______:_______hs." : $dt_Entrega;
	$sRtn .= format_data('os_dt_entrega', $dt_Entrega);


	$sRtn .= "$('#os_observacoes').html('"._ln2br($data_os[OBSERVACAO])."');";

	show_data( $sRtn );

	exit;

//
function format_data($sId, $sTxt){
	return "$('#$sId').html('".utf8_encode( addslashes( $sTxt ))."');";
//	return "$('#$sId').text('".($sTxt)."');";
}

//
function format_data_valor($sId, $sTxt){
  return "$('#$sId').html('".number_format( '0'.$sTxt, 2, ',', ' ')."&nbsp;');";
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
    list($sAno, $sMes, $sDia ) = split('[/.-]', $sData);
    return "$sDia/$sMes/$sAno";
}

# Transforma data
# $data_os: String dmY
# retorna: Ymd
function dmaTOamd($sData) { // by reiwolf
    list($sDia, $sMes, $sAno) = split('[/.-]', $sData);
    return "$sAno/$sMes/$sDia";
}

//
function _ln2br($sTxt){
	$order   = array("\r\n", "\n", "\r");
	$replace = '<br />';
  $sRtn    = str_replace($order, $replace, $sTxt);

	return utf8_encode($sRtn);
}

?>
