<?php
	session_start();

  include_once('../conn.inc.php');

	$bAdmin = $_SESSION[sys][login][admin];

	$sAcao = $_REQUEST[acao];
	$xParam0 = $_REQUEST[xParam0];
	$xParam1 = $_REQUEST[xParam1];
	$xParam2 = $_REQUEST[xParam2];

	$oObj  = $_REQUEST['obj'];
	$aItens = $_REQUEST['itens'];

	switch ($sAcao) {
		case "vendas_os_busca":
      	$aRtn = vendas_os_busca($xParam0, $xParam1, $xParam2, $bAdmin);
      break;

	case "os_get":  // Os_id
		$aRtn = os_get($oObj);
		break;

	case "os_post":  // Os_id
		$aRtn = os_post($oObj);
		break;

	case "item_del":  // Os_id, Item_id
		$aRtn = item_del($xParam0, $xParam1);
		break;

	case "item_add":
		$aRtn = item_add($oObj, $aItens);
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
function vendas_os_busca($sTipo, $xValor, $sOrigem, $bAdmin){

  	//Instruções SQL
  	if ($sTipo == 'OS')
  		$sql = "select * from V_OS Where ID_OS = '$xValor';";

  	if ($sTipo == 'DOC')
  		$sql = "select first 15 * from V_OS Where CNPJ_CPF = '$xValor' ORDER BY DT_ENTREGA DESC;";

  	if ($sTipo == 'NOME')
  		$sql = "select first 15 * from V_OS Where CLIENTE LIKE '%" . $xValor . "%' ORDER BY DT_ENTREGA DESC;";

  	if ($sTipo == 'SERIAL')
  		$sql = "select first 15 skip 0 * from V_OS Where IDENT2 LIKE '%" . $xValor . "%' ORDER BY DT_ENTREGA DESC;";

  	//Executa a instrução SQL
  	$res = queryFB($sql, '', $sOrigem);
  	$res1 = $res;

		$i = 0;

  	//gera um loop com as linhas encontradas
  	//$data_os = ibase_fetch_object ($res);

  	if ($res)
  	{

			$sNome = '';

  		$sRtn = '<p class="box box-solid bg-yellow">As últimas 15 OS\'s</p>';
  		while ($data = ibase_fetch_object ($res)) {

				$i++;

				$sTableName  = "tblServicos".$i;
				$sTableNameS = "tblServicos".$i."S";
				$sTableNameP = "tblServicos".$i."P";

				// if ($sNome != $data->CLIENTE)
        {
					$isTec    = ($_SESSION[sys][login][funcao]=="Técnico");
					$NaoEdita = ((in_array($data->ID_STATUS, ["9", "12"])) && !$bAdmin);
  				$sNome = $data->CLIENTE;
  				$sRtn .= "<h3> >>> ".utf8_encode($sNome). ' <code>[ ' . $_SESSION[sys][FBConn][$sOrigem]['cidade'] ." ]</code></h3>
  						<table if='$sTableName' border=1 width='100%' cellspacing='0' cellspacing='0' class='table table-bordered'>
  						  <thead>
    						  <tr>
      							<th width=30>OS</th>
      							<th>Produto</th>
      							<th>Problema Relatado</th>
      							<th>Status</th>
      							<th width=55 nowrap=no>Dt Entrada</th>
      							<th width=55 nowrap=no>Dt Saída</th>
      							<th width='30' colspan='3' align='center'><strong>Ações</th>
    						  </tr>
  						  </thead>
  						  <tbody>";
  			};

  			$sRtn .= utf8_encode( "<tr style='background-color:#FFD39B;'>
    						<td align='right'>$data->ID_OS</td>
    						<td>$data->OBJETO</td>
    						<td id='status_defeito".$i."'>$data->DEFEITO</td>
    						<td id='status_desc".$i."'>$data->DESCRICAO ($data->ID_STATUS)</td>
    						<td align='center'> ".amdTOdma($data->DT_OS)."</td>
    						<td align='center'> ".amdTOdma($data->DT_RETIRADA)."</td>
    						<td width='179' align='right'>
                  <button class='btn btn-sm btn-rounded btn-primary print_os' data-os='$data->ID_OS' data-origem='$sOrigem'>Print</button>".

									(($NaoEdita) ? '' : "<button class='btn btn-sm btn-rounded btn-success' data-os='$data->ID_OS' data-origem='$sOrigem' data-status='$data->STATUS'>OBS</button>

									<button class='btn btn-sm btn-rounded btn-info ".(($isTec) ? '' : 'hide')."' data-id='status_desc".$i."' data-os='$data->ID_OS' data-origem='$sOrigem' data-status='$data->STATUS'>Status</button>")

							."</td>
  					  </tr>
              <tr>
                <td align='right' colspan='100%'>
  					         Responsavel Tecnico: <strong><span id=tecnico_nome".$i.">".
										 $data->NOME_TECNICO_RESP."</span></strong>&nbsp;".

									 (($NaoEdita) ? '' : "<button class='btn btn-sm btn-danger ".(($isTec) ? '' : 'hide')."' data-id='tecnico_nome".$i."'  data-os='$data->ID_OS' data-origem='$sOrigem'>Troca</button>")

							."</td>
              </tr>" );

				$sRtn .= "<tr>
								<td colspan='100%'>
									<div>
										<strong>SERVIÇOS</strong>
										<span class='pull-right'>".

										(($NaoEdita) ? '' : "<button data-dismiss='modal' data-toggle='modal' data-table='$sTableName' data-os='$data->ID_OS' data-origem='$sOrigem' data-target='#modal_edita_os' class='btn btn-rounded btn-danger'>Editar OS</button>

										<button data-dismiss='modal' data-toggle='modal' data-table='$sTableName' data-os='$data->ID_OS' data-tecnico-id='".$_SESSION[sys][login][id]."' data-origem='$sOrigem' data-target='#modal_itens_os' class='btn btn-rounded btn-primary'>Adicionar Item</button>")

								 ."		</span>

										<table border='1' id='$sTableNameS' style='padding:0; margin:0;width:100%' class='table table-bordered'>
										<tr>
											<td style='width:58px;' align='right'>Cód.</td>
											<td>Serviço</td>
											<td style='width:50px;' align='right'>Quant.</td>
											<td style='width:50px;' align='right'>Unid.</td>
											<td style='width:70px;' nowrap=no align='right'>Valor Unit.</td>
											<td style='width:70px;' nowrap=no align='right'>Valor Total</td>
											<td style='width:150px;' align='center'>Técnico</td>
											<td style='width:50px;'></td>
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
													<button class='btn-info hide' onClick='javascript:osEdita_funcionario($data->ID_OS, \"ID_FUNCIONARIO\", $data->ID_FUNCIONARIO); return false;'>Troca</button></td>
													<td>".

													(($NaoEdita) ? '' : "<button type='button' onclick='removeTr(this)' data-tipo='$data_aux->P_S' data-item='$data_aux->ID_IDENTIFICADOR' data-os='$data->ID_OS' data-origem='$sOrigem'>X</button>")

													."</td>
													</tr>" );
		$vlr_servicos += $data_aux->VLR_TOTAL;
	};


$sRtn .= "</td></tr></table>
					</div>
					<div>
						<strong>PEÇAS</strong>

						<table border='10' id='$sTableNameP' style='cellspacing:0;cellpadding:0; margin:0;width:100%' class='table table-bordered'>
						<tr>
							<td style='width:58px;' align='right'>Cód.</td>
							<td>Serviço</td>
							<td style='width:70px;' align='right'>Quant.</td>
							<td style='width:70px;' align='right'>Unid.</td>
							<td style='width:90px;' nowrap=no align='right'>Valor Unit.</td>
							<td style='width:90px;' nowrap=no align='right'>Valor Total</td>
							<td style='width:170px;' align='center'>Técnico</td>
							<td style='width:50px;'></td>
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
													"<td align='right'>" . number_format( $data_aux->QTD_ITEM, 0) . '</td>' .
													"<td align='right'>" . $data_aux->UNI_MEDIDA . '</td>' .
													"<td align='right'>" . format_data_valor($data_aux->VLR_UNITARIO) . '</td>' .
													"<td align='right'>" . format_data_valor($data_aux->VLR_TOTAL) . '</td>' .
													"<td align='right'>" . $data_aux->FUNCIONARIO . "
													<button class='btn-info hide' onClick='javascript:osEdita_funcionario($data->ID_OS, \"ID_FUNCIONARIO\", $data->ID_FUNCIONARIO); return false;'>Troca</button></td>
													<td>".

													(($NaoEdita) ? '' : "<button type='button' onclick='removeTr(this)' data-tipo='$data_aux->P_S' data-item='$data_aux->ID_IDENTIFICADOR' data-os='$data->ID_OS' data-origem='$sOrigem'>X</button>")

													."</td>
													</tr>" );

		$vlr_servicos += $data_aux->VLR_TOTAL;
	};

// nova ideia - fim

  			$sRtn .= "</tbody></table></table>";

  		}


  	}

		if ($i==0)
			$sRtn = "<p align=center>Nenhum registro encontrado.</p>";


  return Array(code => $i, data => [], msg => $sRtn);
}; //





// INCLUSÃO DE OS
function item_del($sOS, $sItem){

	if (($sOS == '') or ($sItem == ''))
		return Array(code => -1, data => [$sOS, $sItem], msg => 'Erro!! item_del()');

	$sql = "DELETE FROM TB_OS_ITEM WHERE ID_OS = $sOS AND id_identificador = $sItem ";

	// Grava, efetivamente, os ítens na OS
	$res = qPrepare($sql);
	$oRtn[error][sql][item][] = $sql;
	$oRtn[error][res][item][] = $res;

	$sMsg .= " " . $sql;

	return Array(code => 0, data => $oRtn, msg => "item_del(): " . $sMsg);
}; //



// Dados do produto da OS
function os_get($sOS){

	$oRtn 	 = '';

	if ($sOS == '')
		return Array(code => -1, data => [$sOS], msg => "os_get($sOS) - ERRO! Faltam parametros.");

	$sql = "SELECT * FROM TB_OS_OBJETO_OS WHERE ID_OS = '$sOS'";


		$sql1 = "SELECT *
						From V_OS
						Where ID_OS = $sOS;";
						// echo "eu estou aqui: " . __DIR__;

		//Executa a instrução SQL
  	$res = queryFB($sql, '');
		$data_os = ibase_fetch_assoc($res);





	//Executa a instrução SQL
	// $data_os = queryFB($sSql, 1);

	// Objeto
	$aData['os_id'] = $data_os['ID_OS'];
	$aData['os_objeto_id'] = ($data_os['ID_OBJETO']);
	$aData['os_objeto_descricao'] = textFormat($data_os['OBJETO']);
	$aData['os_objeto_modelo'] = textFormat($data_os['IDENT1']);
	$aData['os_objeto_serial'] = textFormat($data_os['IDENT2']);
	$aData['os_objeto_acessorio'] = textFormat($data_os['IDENT3']);
	$aData['os_objeto_prisma'] = textFormat($data_os['IDENT4']);

	$aData['os_problema'] = textFormat($data_os['DEFEITO']);
	$aData['os_problema'] = textFormat($data_os['DEFEITO']);
	$aData['os_adicional'] = textFormat($data_os['IDENT5']);

	return Array(code => [], data => $aData, msg => "os_get($sOS) - $sql ");
}

function textFormat($sTxt){
	return utf8_encode(addslashes($sTxt));
}

// EDIÇÃO DE OS
function os_post($aCampos){

	// Grava Objetos da OS
	$sql = "UPDATE TB_OS_OBJETO_OS SET
						IDENT1  = '".utf8_decode($aCampos['os_objeto_modelo'])."',
						IDENT2  = '".utf8_decode($aCampos['os_objeto_serial'])."',
						IDENT3  = '".utf8_decode($aCampos['os_objeto_acessorio'])."',
						IDENT4  = '".utf8_decode($aCampos['os_objeto_prisma'])."',
						IDENT5  = '".utf8_decode($aCampos['os_adicional'])."',
						DEFEITO = '".utf8_decode($aCampos['os_problema'])."'
					WHERE ID_OS = ".$aCampos['os_id']." AND ID_OBJETO = ".$aCampos['os_objeto_id'];
	$oRtn = queryFB($sql);

	return Array(code => 0, data => $oRtn, msg => "os_post($aCampos): " . $sql);
} //




// INCLUSÃO DE OS
function item_add($sOS, $aItens){
	$oRtn 	 = '';

	// Grava todos os ítens da OS
	$sql = "";
	// for ($i=0; $i < sizeof($aItens); $i++) {

				$sql = "insert into TB_OS_ITEM (ID_ITEMOS, ID_OS, ID_IDENTIFICADOR, ID_FUNCIONARIO, ITEM_CANCEL, QTD_ITEM, VLR_UNIT, VLR_DESC, VLR_TOTAL, DT_LACTO, CASAS_QTD,
				CASAS_VLR, ST, DT_ITEM, HR_ITEM) VALUES ( 0,"
					 .$sOS.", "
					 .$aItens['ID_IDENTIFICADOR'].", "
					 .$aItens['ITEM_TECNICO_ID'].", "
					 ."'N', "
				 .$aItens['ITEM_QTD'].", "
				 .$aItens['PRC_VENDA'].", "
				 .$aItens['ITEM_VALOR_DESC'].", "
				 .$aItens['ITEM_VALOR_TOTAL'].", '"
				 .date('Y-m-d')."', 2, 2, 'T', '"
				 .date('Y-m-d')."', '".date('H:i:s')."' "
				 .");";

		// Grava, efetivamente, os ítens na OS
		$res = queryFB($sql);
		$oRtn[error][sql][item][] = $sql;
		$oRtn[error][res][item][] = $res;

		$sMsg .= " " . $sql;
	// }


	return Array(code => 0, data => $oRtn, msg => "item_add(): " . $sMsg);
} //



?>
