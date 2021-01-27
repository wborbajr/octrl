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


	// Abre conexao com o banco de dados firebird
	// $dbh = 0;
	// $dbh = connFB($sLocalidade);


	switch ($sAcao) {
		case "os_busca":
      	$aRtn = os_busca($xParam0, $xParam1, $xParam2);
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

	//Executa a instrução SQL
	//$p_sql = ibase_prepare ($dbh, $sql);
	//$res = ibase_execute ($p_sql);
	$res = queryFB($sql, '', $sOrigem );
	$res1 = $res;

	//gera um loop com as linhas encontradas
	//$data_os = ibase_fetch_object ($res);

	if ($res)
	{
		$sRtn = '<style>.tb_result{font-size: 8pt;
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

    </style><p class="box box-solid bg-yellow">As últimas 15 OS\'s</p>';
		$sNome = '';
		while ($data = ibase_fetch_object ($res)) {

			$iQtd++;


			// if ($sNome != $data->CLIENTE)
      {

				$sNome = $data->CLIENTE;
				$sRtn .= "<div style='background-color:#c0c0c0;'><strong>"
        .utf8_encode($sNome). ' [ ' . $aCidade['cidade'] ." ]</strong></div>

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

			$sRtn .= utf8_encode( "<tr style='background-color:#FFD39B;'>
  						<td align='right'>$data->ID_OS</td>
  						<td>$data->OBJETO</td>
  						<td>$data->DEFEITO</td>
  						<td id=status_desc>$data->DESCRICAO ($data->ID_STATUS)</td>
  						<td align='center'> ".amdTOdma($data->DT_OS)."</td>
  						<td align='center'> ".amdTOdma($data->DT_RETIRADA)."</td>
  						<td width='100' align='center'>
  							<button class='btn btn-sm btn-primary' onClick='javascript:print_this($data->ID_OS, $sOrigem); return false;'>Print</button>
  						</td>
					  </tr>
            <tr>
              <td align='right' colspan='100%'>
					         Responsavel Tecnico: <strong><span id=tecnico_nome>".$data->NOME_TECNICO_RESP."</span></strong>&nbsp;
					    </td>
            </tr>" );

			$sRtn .= "</tbody></table>";

		}


	} else
      $sRtn = "<p align=center>Nenhum registro encontrado.</p>";

    return Array(code => $iQtd, data => [], msg => $sRtn);
}



?>
