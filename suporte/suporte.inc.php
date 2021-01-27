<?php
	// $lifetime = strtotime('+300 minutes', 0);
	// session_set_cookie_params($lifetime); // 18000 = 5 horas | Set session cookie duration to 1 hour = 3600
	session_start();

  include_once('../conn.inc.php');

	// set_time_limit(20);

	// $sAcao = $_REQUEST['acao'];
	// $oObj  = $_REQUEST['obj'];
	// $sTipo = $_REQUEST['tipo'];
	// $aItens = json_encode($_REQUEST['itens']);
	// $aItens = $_REQUEST['itens'];

	// if ($aItens) {
	// 	// print_r($aItens);
	// 	echo 'Encontrei => ' . $aItens[0]['ID_IDENTIFICADOR'];
	// 	return false;
	// 	exit;
  //
	// }

	$aNum = '';

	$sAcao = $_REQUEST[acao];
	$xParam0 = $_REQUEST[xParam0];
	$xParam1 = $_REQUEST[xParam1];
	$xParam2 = $_REQUEST[xParam2];

	switch ($sAcao) {
		case "os_busca":
      	$aRtn = os_busca($xParam0, $xParam1, $xParam2);
      break;

		case "os_obs":
		  	$aRtn = os_obs($xParam0, $xParam1);
		  	break;

		case "os_obs_grava":
				$aRtn = os_obs_grava($xParam0, $xParam1, $xParam2);
		  	break;

		case "os_basico_grava":
				$aRtn = os_basico_grava($xParam0);
		  	break;

		case "os_tecnico_grava":
				$aRtn = os_tecnico_grava($xParam0);
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



// *******************
function os_busca($sTipo, $xValor, $sOrigem){


	//Instruções SQL
	if ($sTipo == 'OS')
		$sql = "select * from V_OS Where ID_OS = '$xValor';";

	if ($sTipo == 'DOC')
		$sql = "select first 15 * from V_OS Where CNPJ_CPF = '$xValor' ORDER BY DT_ENTREGA DESC;";

	if ($sTipo == 'NOME')
		$sql = "select first 15 * from V_OS Where CLIENTE LIKE '%" . $xValor . "%' ORDER BY DT_ENTREGA DESC;";

	if ($sTipo == 'SERIAL')
		$sql = "select first 15 skip 0 * from V_OS Where IDENT2 LIKE '%" . $xValor . "%' ORDER BY DT_ENTREGA DESC;";

    $iQtd = 0;

	$res = queryFB($sql, '', $sOrigem );
	$res1 = $res;

	//gera um loop com as linhas encontradas
	//$data_os = ibase_fetch_object ($res);

	if ($res)
	{
		$sRtn = '';
		$sNome = '';
		while ($data = ibase_fetch_object ($res)) {

			if ($sNome == ''){
				//$sNome = $data->CLIENTE;
			}

			if ($sNome != $data->CLIENTE){

				$sNome = $data->CLIENTE;
				$sRtn .= ($sRtn == '') ? (($sTipo != 'OS') ? '<p class="box box-solid bg-yellow">As últimas 15 OS\'s</p>' : '' ) : "</tbody></table><br/>" ;

				$sRtn .= "<div style='background-color:#c0c0c0;'><strong>".utf8_encode($sNome). ' [ ' . $_SESSION[sys][FBConn][$sOrigem]['cidade'] ." ]</strong></div>
					    <style>.tb_result{font-size: 8pt;
					    	/*max-width: 95%;*/}
					    .tb_result tr
							{
							border-bottom: 1px solid lightgray;
							padding: 0px;
							spacing: 0px;
							}
							.tb_result td{padding-left:2px;padding-right:2px;}

							/*
							Generic Styling, for Desktops/Laptops
							*/
							table {
							  width: 100%;
							  border-collapse: collapse;
							}
							/* Zebra striping */
							tr:nth-of-type(odd) {
							  background: #eee;
							}
							th {
							  background: #333;
							  color: white;
							  font-weight: bold;
							}
							td {
							  padding: 6px;
							  border: 1px solid #ccc;
							  /*text-align: left; */
							}
							th {
							  padding: 6px;
							  border: 1px solid #ccc;
							  text-align: center;
							}
							.hide{display:none;}

							</style>
						<table border=1	 width='100%' cellspacing='0' cellspacing='0' class='tb_result'>
						  <thead>
						  <tr>
							<th width=30>OS #</th>
							<th>Produto</th>
							<th>Problema Relatado</th>
							<th>Status</th>
							<th width=55>Dt Entrada</th>
							<th width=55>Dt Saída</th>
							<th width='30' colspan='3' align='center'><strong>Ações</th>
						  </tr>
						  </thead>
						  <tbody>";
			};

			//
			// <button class='btn-primary print_os' data-os='$data->ID_OS' data-origem='$sOrigem'>Print</button>
			// <button class='btn-warning' data-os='$data->ID_OS' data-origem='$sOrigem'onClick='javascript:obs_this($data->ID_OS, $data->ID_STATUS); return false;'>OBS</button>
			// <button class='btn-info' onClick='javascript:osEdita($data->ID_OS); return false;'>Status</button>


			$sRtn .= utf8_encode( "<tr style='background-color:#FFD39B;'>
						<td align='right'>$data->ID_OS</td>
						<td>$data->OBJETO</td>
						<td>$data->DEFEITO</td>
						<td id=status_desc>$data->DESCRICAO ($data->ID_STATUS)</td>
						<td align='center'> ".amdTOdma($data->DT_OS)."</td>
						<td align='center'> ".amdTOdma($data->DT_RETIRADA)."</td>
						<td width='140' align='center'>
							<button class='btn-primary print_os' data-os='$data->ID_OS' data-origem='$sOrigem'>Print</button>
							<button class='btn-warning' data-os='$data->ID_OS' data-origem='$sOrigem' data-status='$data->STATUS'>OBS</button>
							<button class='btn-info' data-os='$data->ID_OS' data-origem='$sOrigem' data-status='$data->STATUS'>Status</button>
						</td>
					  </tr><tr><td align='right' colspan='100%'>
					  Responsavel Tecnico: <strong><span id=tecnico_nome>".
						$data->NOME_TECNICO_RESP."</span></strong>&nbsp;
					  <button class='btn-danger' data-os='$data->ID_OS' data-origem='$sOrigem'>Troca</button>
					  </td></td>" );

			$sRtn .= "<tr>
					  	<td colspan='100%'>
					  		<div>
					  			<strong>SERVIÇOS</strong>

					  			<table border='0' style='border:0; padding:0; margin:0;'>
									<tr>
										<td style='width:58px;' align='right'>Cód Obj.</td>
										<td>Serviço</td>
										<td style='width:50px;' align='right'>Quant.</td>
										<td style='width:50px;' align='right'>Unid.</td>
										<td style='width:70px;' align='right'>Valor Unit.</td>
										<td style='width:70px;' align='right'>Valor Total</td>
										<td style='width:150px;' align='center'>Técnico</td>
									</tr>";

				//------------ Serviços
				$sql = "select *
						from v_os_item
						where ID_OS = $data->ID_OS
						and P_S = 'S'
						order by id_identificador;";


				//Executa a instrução SQL
				//$p_sql_aux = ibase_prepare ($dbh, $sql);
				$res_item = queryFB($sql, '', $sOrigem ); //ibase_execute ($p_sql_aux);

				while ($data_aux = ibase_fetch_object ($res_item)) {
					//$sRtn .= '<div>';
					$sRtn .= utf8_encode( "<tr><td align='right'>" . $data_aux->ID_IDENTIFICADOR . '</td>' .
                                "<td align=''>" . $data_aux->DESCRICAO . '</td>' .
                                "<td align='right'>" . $data_aux->QTD_ITEM . '</td>' .
                                "<td align='right'>" . $data_aux->UNI_MEDIDA . '</td>' .
                                "<td align='right'>" . format_data_valor($data_aux->VLR_UNITARIO) . '</td>' .
                                "<td align='right'>" . format_data_valor($data_aux->VLR_TOTAL) . '</td>' .
                                "<td align='right'>" . $data_aux->FUNCIONARIO . "
                                <button class='btn-info hide' onClick='javascript:osEdita_funcionario($data->ID_OS, \"ID_FUNCIONARIO\", $data->ID_FUNCIONARIO); return false;'>Troca</button>
                                </td></tr>" );
					$vlr_servicos += $data_aux->VLR_TOTAL;
				};


			$sRtn .= "</tr></table>
					  		</div>
					  		<div>
					  			<strong>PEÇAS</strong>

					  			<table border='0' style='border:0; padding:0; margin:0;'>
									<tr>
										<td style='width:58px;' align='right'>Cód Obj.</td>
										<td>Serviço</td>
										<td style='width:70px;' align='right'>Quant.</td>
										<td style='width:70px;' align='right'>Unid.</td>
										<td style='width:90px;' align='right'>Valor Unit.</td>
										<td style='width:90px;' align='right'>Valor Total</td>
										<td style='width:170px;' align='center'>Técnico</td>
									</tr>";

				//------------ Serviços
				$sql = "select *
						from v_os_item
						where ID_OS = $data->ID_OS
						and  P_S <> 'S'
						order by id_identificador;";


				//Executa a instrução SQL
				//$p_sql_aux = ibase_prepare ($dbh, $sql);
				$res_item = queryFB($sql, '', $sOrigem );; //ibase_execute ($p_sql_aux);

				while ($data_aux = ibase_fetch_object ($res_item)) {
					$sRtn .= utf8_encode( "<tr><td align='right'>" . $data_aux->ID_IDENTIFICADOR . '</td>' .
					                      "<td align=''>" . $data_aux->DESCRICAO . '</td>' .
					                      "<td align='right'>" . $data_aux->QTD_ITEM . '</td>' .
                                "<td align='right'>" . $data_aux->UNI_MEDIDA . '</td>' .
                                "<td align='right'>" . $data_aux->VLR_UNITARIO . '</td>' .
                                "<td align='right'>" . $data_aux->VLR_TOTAL . '</td>' .
                                "<td align='right'>" . $data_aux->FUNCIONARIO . "
                                <button class='btn-info hide' onClick='javascript:osEdita_funcionario($data->ID_OS, \"ID_FUNCIONARIO\", $data->ID_FUNCIONARIO); return false;'>Troca</button></td></tr>" );

					$vlr_servicos += $data_aux->VLR_TOTAL;
				};


			$sRtn .= "</table>
					  		</div>
					  	</td>
					  </tr>";

		}

		$sRtn .= ($sRtn == '') ? "<p align=center>Nenhum registro encontrado.</p>" : "</tbody></table>" ;

	}
    return Array(code => $iQtd, data => [], msg => $sRtn);
}




//
function os_obs($sOrigem, $iOS){

	//Instruções SQL
	$sql = "Select FIRST 1 OBSERVACAO
				From
				  TB_OS
				Where ID_OS = '$iOS';";

	//Executa a instrução SQL
	$data_os = queryFB($sql, 1, $sOrigem );


	return Array(code => $iOS, data => [__ln2br($data_os[OBSERVACAO]), $iOS], msg => $sql);
	// echo json_encode([_ln2br($data_os[OBSERVACAO]), $iOS]);
}



function os_obs_grava($sOrigem, $iOS, $sOBS){

	//Instruções SQL
	$sql = "Select FIRST 1 OBSERVACAO
						From TB_OS
					 Where ID_OS = '$iOS';";

	//Executa a instrução SQL
	$data_os = queryFB($sql, 1, $sOrigem );

	//Instruções SQL
	//$sql = "UPDATE TB_OS SET OBSERVACAO = '".utf8_decode($sOBS)."' Where ID_OS = '$iOS' AND DT_RETIRADA IS NULL;";
	$sql = "UPDATE TB_OS SET OBSERVACAO = '".utf8_decode($sOBS)."' Where ID_OS = '$iOS';";
	//echo $sql;

	//Executa a instrução SQL
	$res = queryFB($sql, '', $sOrigem );
	$iQtd = ibase_affected_rows();

	if (!$iQtd)
		_log_acao("Nao conseguiu atualizar OS #".$data_os[ID_OS]." - Loja $sOrigem");
	else {
		_log_acao("Atualizou OBS da OS: #".$data_os[ID_OS]." - Loja $sOrigem");
		_log_acao("..........de: [".json_encode($data_os[OBSERVACAO])."]");
		_log_acao("........para: [".$sOBS."]");

		// _log_acao("Atualizou OBS da OS: $iOS - OBS: $sOBS");
	}

	return Array(code => $res, data => [], msg => '');
}


// Grava status da OS
function os_basico_grava($oObj){
	parse_str($oObj, $aDados);

	$sql = "SELECT FIRST 1 r.ID_STATUS
					  FROM TB_OS r
					 WHERE ID_OS = '".$aDados[iOS]."';";

	//Executa a instrução SQL
	$data_os = queryFB($sql, 1, $aDados[origem] );
	//---- guarda antes da atualizaçao

	// Atualiza a tabela
	$sql = "UPDATE TB_OS SET ID_STATUS = ".$aDados[iStatus].", DT_RETIRADA = NULL Where ID_OS = '".$aDados[iOS]."';";

	$res  = queryFB($sql, '', $aDados[origem] );
	$iRes = ibase_affected_rows();

	if (!$iRes){
		_log_acao("Tentou atualizar OS *SEM* sucesso: ".json_decode($oObj));
    _log_acao("..........de: Status: ".$data_os[ID_STATUS]);
		_log_acao("........para: Status: ".$aDados[iStatus]);
	 } else {
		_log_acao("Atualizou OS: #".$data_os[ID_OS]." - Loja ".$aDados[origem]);
		_log_acao("..........de: Status: ".$data_os[ID_STATUS]);
		_log_acao("........para: Status: ".$aDados[iStatus]);
	}

	return Array(code => $iRes, data => [], msg => 'os_basico_grava');
}





function os_tecnico_grava($oObj){
	parse_str($oObj, $aDados);

	$sql = "SELECT 	r.ID_OS, r.ID_TECNICO_RESP, r.NOME_TECNICO_RESP
			FROM V_OS r
			WHERE r.ID_OS = '".$aDados[sOS]."';";
	$data_os = queryFB($sql, 1, $aDados[origem]);
	//---- guarda antes da atualizaçao

	$sql = "UPDATE TB_OS SET ID_TECNICO_RESP = ".$aDados[iTecnico]." Where ID_OS = '".$aDados[sOS]."';";
	$res  = queryFB($sql, '', $aDados[origem]);

	$iRes = ibase_affected_rows();
	if (!$iRes){
		_log_acao("Tentou trocar tecnico da OS sem sucesso: ".json_decode($oObj));
	} else {
		_log_acao("Atualizou Tecnico Responsavel da OS: #".$data_os[ID_OS]);
		_log_acao("......de: ".$data_os[ID_TECNICO_RESP]." - ".$data_os[NOME_TECNICO_RESP]);
		_log_acao("....para: ".$aDados[iTecnico]);
	}

	return Array(code => $iRes, data => [$sql], msg => 'os_basico_grava');
}





//
function _log_acao($msg){

	// $usuario = $_SESSION[login][nome];
  $usuario = $_SESSION[sys][login][usuario] . ' - #' . $_SESSION[sys][login][id];
	$data = date("d-m-y");
	$hora = date("H:i:s");
	$ip = $_SERVER['REMOTE_ADDR'];

	//Nome do arquivo:
	$arquivo = "../comum/logs/Acao_$data.txt";

	//Texto a ser impresso no log:
	$texto = "[$hora][$ip]> $msg [$usuario]\n";

	$manipular = fopen("$arquivo", "a+b");
	fwrite($manipular, $texto);
	fclose($manipular);

}


//
function __ln2br($sTxt){
  $order   = array("\r\n", "\n", "\r");
  $replace = chr(13);
  $sRtn    = str_replace($order, $replace, $sTxt);

	return utf8_encode($sRtn);
//	return ln2br($sRtn);
}



?>
