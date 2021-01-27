<?php
error_reporting(E_ERROR);

  //ini_set("session.cookie_lifetime","900000"); //an hour

  /* Define o limitador de cache para 'private' */
  // session_cache_limiter('private');

  /* Define o limite de tempo do cache em x minutos */
  // session_cache_expire(60000);

//  set_time_limit(10);

  session_start();


	$aNum = '';

	$sAcao = $_REQUEST[acao];
	$xParam0 = $_REQUEST[xParam0];
	$xParam1 = $_REQUEST[xParam1];
	$xParam2 = $_REQUEST[xParam2];

/*

	if ($sAcao != 'login')
		if ($_SESSION[login][id] == null){
			$aRtn =  Array(code => -1, data => [], msg => "A sessao expirou. Faça login novamente.");  // $sql !! ($sLogin . $sSenha)

			//echo json_encode( $aRtn );
			?>
		  	<script>window.open("index.html", "_top");</script>
		  	<?php
		  	exit;
		}

*/

/*
*
*/

	//error_reporting(0);

	// curitiba
    // if ($_SESSION[login][localid] == 7)
		// require( 'conn.inc.php' );

	// londrina
    // if ($_SESSION[login][localid] == 9)
		// require( 'conn-9.inc.php' );

	// natal
    // if ($_SESSION[login][localid] == 1)
		// require( 'conn-1.inc.php' );

	date_default_timezone_set('America/Sao_Paulo');

	//conexão com o banco, se der erro mostrara uma mensagem.
//	if (!($dbh=ibase_connect($servidor, 'SYSDBA', 'masterkey')))
//		die('Erro ao conectar: ' .  ibase_errmsg());



	switch ($sAcao) {
		case "login":
			login($dbh, $_POST);
			break;

		case "os_busca_nr":
			if ($xParam1 != '11') // fb curitiba
				os_busca_nr($dbh, $xParam0, $xParam1);

			else if ($xParam1 == '11') // mysql curitiba
				os_busca_mysql_nr($xParam0);

			break;

		case "cliente_os_busca":
			cliente_os_busca($dbh, $xParam0, $xParam1, $xParam2);
			break;

    case "vendas_os_busca":
        vendas_os_busca($dbh, $xParam0, $xParam1, $xParam2);
        break;

		case "os_obs":
		  	os_obs($dbh, $xParam0, $xParam1);
		  	break;

		case "os_obs_grava":
			os_obs_grava($dbh, $xParam0, $xParam1, $xParam2);
		  	break;

		case "os_basico_grava":
			os_basico_grava($dbh, $xParam0);
		  	break;

		case "os_tecnico_grava":
			os_tecnico_grava($dbh, $xParam0);
		  	break;

		default:
			$aRtn =  Array(code => -1, data => [], msg => "Informe um parâmetro!");  /* - $sql !! ($sLogin . $sSenha)"*/
			echo json_encode( $aRtn );
	}


	//fecha conexão com o firebird
	ibase_close($dbh);

exit;

function padzeros($sTxt, $iQtd = 6) {
	$sTxt = trim( $sTxt );
	$iLen = strlen( $sTxt ) +$iQtd;
	$sRtn = '000000'.$sTxt;
	$sRtn = substr($sRtn, -$iQtd, $iQtd);
	return $sRtn;
}


function log_acesso($usuario, $msg){

	$data = date("d-m-y");
	$hora = date("H:i:s");
	$ip = $_SERVER['REMOTE_ADDR'];

	//Nome do arquivo:
	$arquivo = "logs/Acesso_$data.txt";

	//Texto a ser impresso no log:
	$texto = "[$hora][$ip]> $msg [$usuario]\n";

	$manipular = fopen("$arquivo", "a+b");
	fwrite($manipular, $texto);
	fclose($manipular);

}



function log_acao($msg){

  	$usuario = $_SESSION[login][nome];
	$data = date("d-m-y");
	$hora = date("H:i:s");
	$ip = $_SERVER['REMOTE_ADDR'];

	//Nome do arquivo:
	$arquivo = "logs/Acao_$data.txt";

	//Texto a ser impresso no log:
	$texto = "[$hora][$ip]> $msg [$usuario]\n";

	$manipular = fopen("$arquivo", "a+b");
	fwrite($manipular, $texto);
	fclose($manipular);

}


//
function login($dbh, $aData){

  $sLogin = $aData['user'];
  $sSenha = $aData['pass'];

  $sLogin = str_replace("+"," ",$aData['user']);
//  $sSenha = str_replace("+"," ",$aData['pass']);


  //Instruções SQL
	$sql = "SELECT r.ID_FUNCIONARIO, r.NOME, r.CIDADE, r.UF, r.N_REGISTRO, r.CPF, r.RG,
              r.END_CEP, r.END_TIPO, r.END_LOGRAD, r.END_NUMERO, r.END_COMPLE,
              r.END_BAIRRO, r.DDD, r.FONE, r.CELULAR, r.EMAIL, r.SALARIO, r.EXTRA,
              r.DATA_NASCT, r.DATA_ADMIS, r.DATA_DEMIS, r.RAMAL, r.SENHA, r.IP, r.STATUS,
              r.SETOR, r.CARGO, r.PIS, r.APELIDO, r.OBSERVACAO
          FROM V_FUNCIONARIOS r
          WHERE r.SENHA = '". strtoupper( md5( strtoupper( str_replace("+",",",$aData['user']) . str_replace("+",",",$aData['pass'])) ) )."'";


  //Instruções SQL
	$sql = "SELECT r.ID_FUNCIONARIO, r.NOME, r.SENHA, r.STATUS, r.CARGO, r.APELIDO
          FROM V_FUNCIONARIOS r
          WHERE r.SENHA = '". strtoupper( md5( strtoupper( $sLogin . $sSenha ) ) )."'";


    // curitiba
      if ($aData['select_localidade'] == 7)
  		require( 'conn.inc.php' );

  	// londrina
      if ($aData['select_localidade'] == 9)
  		require( 'conn-9.inc.php' );

  	// natal
      if ($aData['select_localidade'] == 1)
  		require( 'conn-1.inc.php' );


  $aLocalidades = array('7' => 'Curitiba',  '9' => 'Londrina', '1' => 'Natal');

	//Executa a instrução SQL
	$query= ibase_query ($dbh, $sql);

	//gera um loop com as linhas encontradas
	$data_rtn = ibase_fetch_assoc($query, IBASE_TEXT);

  $sStatus = 0;
  $sMsg = "Login e/ou senha inválido(s). A combinação não retornou resultado. " . $aData['select_localidade'] . ' - ' . $data_rtn[ID_FUNCIONARIO] ;


  // Validar id usuarios com ip interno
  // Somente acesso externo para IDs: 12,15,52,61
  if ($aData['select_localidade'] == 7) // Curitiba
  	$aID_OK = array_search( $data_rtn[ID_FUNCIONARIO], array('0', '12','53') );
  else if ($aData['select_localidade'] == 9) // Londrina
  	$aID_OK = array_search( $data_rtn[ID_FUNCIONARIO], array('0', '1','2','4') );
  else // Natal
  	$aID_OK = array_search( $data_rtn[ID_FUNCIONARIO], array('0', '1','2','3') );


  if ($aData['select_localidade'] == 1)
  	$aID_OK = true;


  if (($_SERVER["SERVER_NAME"] == '200.150.121.43') and ( ! $aID_OK) )
  		$data_rtn = null;

  if ($data_rtn != null){

    if ($data_rtn[STATUS] == 'A') {
        $sStatus  = 1;
        $sMsg     = "./os.inc.php";
        $_SESSION[login][id] = $data_rtn[ID_FUNCIONARIO];
        $_SESSION[login][nome] = $data_rtn[NOME];
        $_SESSION[login][apelido] = $data_rtn[APELIDO];
        $_SESSION[login][cargo] = $data_rtn[CARGO];
        $_SESSION[login][localid] = $aData['select_localidade'];
        $_SESSION[login][localnome] = $aLocalidades[$aData['select_localidade']]; // (( == 7) ? 'Curitiba' : 'Londrina' );
        $_SESSION[bID_OK] = $aID_OK;

	  	log_acesso($sLogin, "Loja ".$aData['select_localidade'].". Logou no sistema.");

		// Verifica se eh tecnico
		$sql = "SELECT r.ID_FUNCIONARIO
				FROM V_FUNC_TECNICO r
	          WHERE r.ID_FUNCIONARIO = '". $data_rtn[ID_FUNCIONARIO]."'";

		//Executa a instrução SQL
		$query= ibase_query ($dbh, $sql);

		//gera um loop com as linhas encontradas
		$data = ibase_fetch_assoc($query, IBASE_TEXT);
		$_SESSION[login][tecnico] = $data[ID_FUNCIONARIO];

        $_SESSION[login][funcao] = $data[ID_FUNCIONARIO] ? 'Tecnico' : '';


    }
    else {
      $sStatus = -1;
      $sMsg     = "Usuário não ATIVO no sistema.";
	  log_acesso($sLogin, "Loja ".$aData['select_localidade'].". Tentativa de acesso. Usuario INATIVO.");
    };

  } else
  	log_acesso($sLogin, "Loja ".$aData['select_localidade'].". Acesso negado! Usou senha: [$sSenha]");


  $aRtn =  Array(code => $sStatus, data => json_encode($data_rtn), msg => "$sMsg");  /* - $sql !! ($sLogin . $sSenha)"*/

  echo json_encode( $aRtn );

}



//
function os_busca_nr($dbh, $iOS, $sOrigem){

	//Instruções SQL
	$sql = "Select ID_OS
				From
				  TB_OS
				Where ID_OS = $iOS;";

  if ($sOrigem == '9')
		require 'conn-9.inc.php';

  if ($sOrigem == '7')
		require 'conn.inc.php';

  if ($sOrigem == '1')
		require 'conn-1.inc.php';

	//Executa a instrução SQL
	$query= ibase_query ($dbh, $sql);

	//gera um loop com as linhas encontradas
	//$data_os = ibase_fetch_object ($query);
	$data_os = ibase_fetch_assoc($query, IBASE_TEXT);

	echo json_encode($data_os[ID_OS]);

}




//
function os_busca_mysql_nr($sOS){

	$sql = "select a.numero
			from ordens a
			where a.numero = '".padzeros($sOS,6)."'
			limit 1;";
	$data = query( $sql, 1 );

	echo json_encode($data);

}




//
function cliente_os_busca($dbh, $sTipo, $xValor, $sOrigem){

	$aOrigem = Array(7 => 'Loja 7 - Curitiba', 9 => 'Loja 9 - Londrina', 1 => 'Natal');

	//Instruções SQL
	if ($sTipo == 'OS')
		$sql = "select * from V_OS Where ID_OS = '$xValor';";

	if ($sTipo == 'DOC')
		$sql = "select first 15 * from V_OS Where CNPJ_CPF = '$xValor' ORDER BY DT_ENTREGA DESC;";

	if ($sTipo == 'NOME')
		$sql = "select first 15 * from V_OS Where CLIENTE LIKE '%" . formata_entrada($xValor) . "%' ORDER BY DT_ENTREGA DESC;";

	if ($sTipo == 'SERIAL')
		$sql = "select first 15 skip 0 * from V_OS Where IDENT2 LIKE '%" . formata_entrada($xValor) . "%' ORDER BY DT_ENTREGA DESC;";



  if ($sOrigem == '9')
   	  require 'conn-9.inc.php';

  if ($sOrigem == '7')
      require 'conn.inc.php';

  if ($sOrigem == '1')
      require 'conn-1.inc.php';



	//Executa a instrução SQL
	$p_sql = ibase_prepare ($dbh, $sql);
	$res = ibase_execute ($p_sql);
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

				$sRtn .= "<div style='background-color:#c0c0c0;'><strong>".utf8_encode($sNome). ' [ ' . $aOrigem[$sOrigem] ." ]</strong></div>
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

			$sRtn .= utf8_encode( "<tr style='background-color:#FFD39B;'>
						<td align='right'>$data->ID_OS</td>
						<td>$data->OBJETO</td>
						<td>$data->DEFEITO</td>
						<td id=status_desc>$data->DESCRICAO ($data->ID_STATUS)</td>
						<td align='center'> ".amdTOdma($data->DT_OS)."</td>
						<td align='center'> ".amdTOdma($data->DT_RETIRADA)."</td>
						<td width='140' align='center'>
							<button class='btn-primary' onClick='javascript:print_this($data->ID_OS, $sOrigem); return false;'>Print</button>
							<button class='btn-warning' onClick='javascript:obs_this($data->ID_OS, $data->ID_STATUS); return false;'>OBS</button>
							<button class='btn-info' onClick='javascript:osEdita($data->ID_OS); return false;'>Status</button>
						</td>
					  </tr><tr><td align='right' colspan='100%'>
					  Responsavel Tecnico: <strong><span id=tecnico_nome>".$data->NOME_TECNICO_RESP."</span></strong>&nbsp;
					  <button class='btn-danger' onClick='javascript:osEdita_funcionario($data->ID_OS, \"ID_TECNICO_RESP\", $data->ID_TECNICO_RESP); return false;'>Troca</button>
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
				$p_sql_aux = ibase_prepare ($dbh, $sql);
				$res_item = ibase_execute ($p_sql_aux);

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
				$p_sql_aux = ibase_prepare ($dbh, $sql);
				$res_item = ibase_execute ($p_sql_aux);

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


	echo $sRtn;
//	echo json_encode( $sRtn  );
	//echo json_encode($sql);

}






//
function vendas_os_busca($dbh, $sTipo, $xValor, $sOrigem){

	$aOrigem = Array(7 => 'Loja 7 - Curitiba', 9 => 'Loja 9 - Londrina', 1 => 'Natal');

	//Instruções SQL
	if ($sTipo == 'OS')
		$sql = "select * from V_OS Where ID_OS = '$xValor';";

	if ($sTipo == 'DOC')
		$sql = "select first 15 * from V_OS Where CNPJ_CPF = '$xValor' ORDER BY DT_ENTREGA DESC;";

	if ($sTipo == 'NOME')
		$sql = "select first 15 * from V_OS Where CLIENTE LIKE '%" . formata_entrada($xValor) . "%' ORDER BY DT_ENTREGA DESC;";

	if ($sTipo == 'SERIAL')
		$sql = "select first 15 skip 0 * from V_OS Where IDENT2 LIKE '%" . formata_entrada($xValor) . "%' ORDER BY DT_ENTREGA DESC;";


	if ($sOrigem == '9')
   		require 'conn-9.inc.php';

  if ($sOrigem == '7')
      require 'conn.inc.php';

  if ($sOrigem == '1')
      require 'conn-1.inc.php';

	//Executa a instrução SQL
	$p_sql = ibase_prepare ($dbh, $sql);
	$res = ibase_execute ($p_sql);
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


			// if ($sNome != $data->CLIENTE)
      {

				$sNome = $data->CLIENTE;
				$sRtn .= "<div style='background-color:#c0c0c0;'><strong>"
        .utf8_encode($sNome). ' [ ' . $aOrigem[$sOrigem] ." ]</strong></div>

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


	echo $sRtn;
//	echo json_encode( $sRtn  );
	//echo json_encode($sql);

}






function itens_show($dbh, $iOS, $sStatus){
	$sRtn = '';

	// Serviços
	$sql = "select *
			from v_os_item
			where ID_OS = $iOS
			and P_S = '$sStatus'
			order by id_identificador;";


	//Executa a instrução SQL
	$p_sql = ibase_prepare ($dbh, $sql);
	$res_item = ibase_execute ($p_sql);

	return ibase_affected_rows();

	$vlr_servicos = 0;

	//gera um loop com as linhas encontradas
	while ($data = ibase_fetch_object ($res_item)) {
		$sRtn .= $data->ID_IDENTIFICADOR . ' | ';
		$sRtn .= $data->DESCRICAO . ' | ';
		$sRtn .= $data->QTD_ITEM . ' | ';
		$sRtn .= $data->UNI_MEDIDA . ' | ';
		$sRtn .= $data->VLR_UNITARIO . ' | ';
		$sRtn .= $data->VLR_TOTAL . ' | ';
		$sRtn .= $data->FUNCIONARIO . '<br />';
		$vlr_servicos += $data->VLR_TOTAL;
	}

	return $sRtn;

}


function os_obs($dbh, $sOrigem, $iOS){


	if ($sOrigem == '9')
   		require 'conn-9.inc.php';

  if ($sOrigem == '7')
      require 'conn.inc.php';

  if ($sOrigem == '1')
      require 'conn-1.inc.php';



	//Instruções SQL
	$sql = "Select FIRST 1 OBSERVACAO
				From
				  TB_OS
				Where ID_OS = '$iOS';";


	//Executa a instrução SQL
	$query= ibase_query ($dbh, $sql);

	//gera um loop com as linhas encontradas
	//$data_os = ibase_fetch_object ($query);
	$data_os = ibase_fetch_assoc($query, IBASE_TEXT);

	echo json_encode([_ln2br($data_os[OBSERVACAO]), $iOS]);

}


//
function _ln2br($sTxt){
  $order   = array("\r\n", "\n", "\r");
  $replace = chr(13);
  $sRtn    = str_replace($order, $replace, $sTxt);

	return utf8_encode($sRtn);
//	return ln2br($sRtn);
}


function os_obs_grava($dbh, $sOrigem, $iOS, $sOBS){


	if ($sOrigem == '9')
   		require 'conn-9.inc.php';

  if ($sOrigem == '7')
      require 'conn.inc.php';

  if ($sOrigem == '1')
      require 'conn-1.inc.php';


	//Instruções SQL
	$sql = "Select FIRST 1 OBSERVACAO
				From
				  TB_OS
				Where ID_OS = '$iOS';";

	//Executa a instrução SQL
	$query= ibase_query ($dbh, $sql);

	//gera um loop com as linhas encontradas
	//$data_os = ibase_fetch_object ($query);
	$data_os = ibase_fetch_assoc($query, IBASE_TEXT);


	//Instruções SQL
	//$sql = "UPDATE TB_OS SET OBSERVACAO = '".utf8_decode($sOBS)."' Where ID_OS = '$iOS' AND DT_RETIRADA IS NULL;";
	$sql = "UPDATE TB_OS SET OBSERVACAO = '".utf8_decode($sOBS)."' Where ID_OS = '$iOS';";
	//echo $sql;

	//Executa a instrução SQL
	$p_sql = ibase_prepare ($dbh, $sql);
	$res   = ibase_execute ($p_sql);

	if (!ibase_affected_rows())
		log_acao("Nao consegui.");
	else {
		log_acao("Atualizou OBS da OS: #".$data_os[ID_OS]." - Loja $sOrigem");
		log_acao("..........de: ".json_encode($data_os[OBSERVACAO]));
		log_acao("........para: ".$sOBS);

		log_acao("Atualizou OBS da OS: $iOS - OBS: $sOBS");

	}

	echo ibase_affected_rows();

	//gera um loop com as linhas encontradas
	//$data_os = ibase_fetch_object ($query);
	//$data_os = ibase_fetch_assoc($query, IBASE_TEXT);

	//echo json_encode($data_os[OBSERVACAO]);

}



function os_basico_grava($dbh, $oObj){
	parse_str($oObj, $aDados);


	if ($sOrigem == '9')
   		require 'conn-9.inc.php';

  if ($sOrigem == '7')
      require 'conn.inc.php';

  if ($sOrigem == '1')
      require 'conn-1.inc.php';



	$sql = "SELECT  FIRST 1
					r.ID_OS, r.ID_CLIENTE, r.ID_VENDEDOR, r.DT_OS, r.HR_OS, r.DT_ENTREGA,
				    r.COMPRADOR, r.ID_STATUS, r.OBSERVACAO, r.ID_MODULO, r.ENTREGA, r.CHAVE,
				    r.ID_OSATEND, r.DT_GARANTIA, r.ID_OBJETO_CONTRATO, r.DT_RETIRADA
			FROM TB_OS r
			WHERE ID_OS = '".$aDados[iOS]."';";

	//Executa a instrução SQL
	$query= ibase_query ($dbh, $sql);

	//gera um loop com as linhas encontradas
	//$data_os = ibase_fetch_object ($query);
	$data_os = ibase_fetch_assoc($query, IBASE_TEXT);
	//---- guarda antes da atualizaçao


	//Instruções SQL
	$sql = "UPDATE TB_OS SET ID_STATUS = ".$aDados[iStatus].", DT_RETIRADA = NULL Where ID_OS = '".$aDados[iOS]."';";
//	echo $sql;

  if ($data_os[ID_STATUS] != '12'){
  	//Executa a instrução SQL
  	$p_sql = ibase_prepare ($dbh, $sql);
  	$res   = ibase_execute ($p_sql);
  }

  // somente altorizados podem remover o status 12
  if ($data_os[ID_STATUS] == '12'){
    //log_acao('é 12 - '.$aID_OK.' !!!');
    if ($_SESSION[bID_OK])
    {
    	//Executa a instrução SQL
    	$p_sql = ibase_prepare ($dbh, $sql);
    	$res   = ibase_execute ($p_sql);
    }
  }


	if (!ibase_affected_rows()){
		log_acao("Tentou atualizar OS *SEM* sucesso: ".json_decode($oObj));
    log_acao("..........de: Status: ".$data_os[ID_STATUS]);
		log_acao("........para: Status: ".$aDados[iStatus]);
	 } else {
		log_acao("Atualizou OS: #".$data_os[ID_OS]." - Loja ".$aDados[origem]);
		log_acao("..........de: Status: ".$data_os[ID_STATUS]);
		log_acao("........para: Status: ".$aDados[iStatus]);
	}

	echo ibase_affected_rows();

	//gera um loop com as linhas encontradas
	//$data_os = ibase_fetch_object ($query);
	//$data_os = ibase_fetch_assoc($query, IBASE_TEXT);

	//echo json_encode($data_os[OBSERVACAO]);

}




function os_tecnico_grava($dbh, $oObj){
	parse_str($oObj, $aDados);

	$sql = "SELECT 	r.ID_ORIGEM, r.ID_OS, r.DT_OS, r.HR_OS, r.DT_ENTREGA, r.COMPRADOR,
				    r.ID_CLIENTE, r.CLIENTE, r.CNPJ_CPF, r.ID_VENDEDOR, r.VENDEDOR, r.ID_STATUS,
				    r.DESCRICAO, r.RESERVA, r.OBSERVACAO, r.VLR_PECAS, r.VLR_SERVICOS,
				    r.VLR_ITEM, r.VLR_TOTAL, r.ENTREGA, r.CHAVE, r.ID_FORNEC, r.NOME,
				    r.VLR_FRETE, r.TIPO_FRETE, r.VAL, r.ID_OBJETO, r.OBJETO, r.DEFEITO,
				    r.IDENT1, r.IDENT2, r.IDENT3, r.IDENT4, r.IDENT5, r.ID_MODULO,
				    r.DT_GARANTIA, r.ID_OSATEND, r.ATENDIMENTO, r.ID_OBJETO_CONTRATO,
				    r.DT_RETIRADA, r.OBS_INTERNA, r.ID_TECNICO_RESP, r.NOME_TECNICO_RESP
			FROM V_OS r
			WHERE r.ID_OS = '".$aDados[sOS]."';";

	//Executa a instrução SQL
	$query= ibase_query ($dbh, $sql);

	//gera um loop com as linhas encontradas
	//$data_os = ibase_fetch_object ($query);
	$data_os = ibase_fetch_assoc($query, IBASE_TEXT);
	//---- guarda antes da atualizaçao


	//Instruções SQL
//	$sql = "UPDATE TB_OS SET ID_STATUS = ".$aDados[iStatus].", ID_VENDEDOR = ".$aDados[iVendedor].", ID_OSATEND = ".$aDados[iAtendente]." Where ID_OS = '".$aDados[iOS]."';";
//	$sql = "UPDATE TB_OS SET ID_STATUS = ".$aDados[iStatus].", ID_VENDEDOR = ".$aDados[iVendedor]." Where ID_OS = '".$aDados[iOS]."';";
	$sql = "UPDATE TB_OS SET ID_TECNICO_RESP = ".$aDados[iTecnico]." Where ID_OS = '".$aDados[sOS]."';";
//	echo $sql;


	//Executa a instrução SQL
	$p_sql = ibase_prepare ($dbh, $sql);
	$res   = ibase_execute ($p_sql);

	if (!ibase_affected_rows())
		log_acao("Tentou trocar tecnico da OS sem sucesso: ".json_decode($oObj));
	else {
		log_acao("Atualizou Tecnico Responsavel da OS: #".$data_os[ID_OS]);
		log_acao("......de: ".$data_os[ID_TECNICO_RESP]." - ".$data_os[NOME_TECNICO_RESP]);
		log_acao("....para: ".$aDados[iTecnico]);
	}

	echo ibase_affected_rows();

	//gera um loop com as linhas encontradas
	//$data_os = ibase_fetch_object ($query);
	//$data_os = ibase_fetch_assoc($query, IBASE_TEXT);

	//echo json_encode($data_os[OBSERVACAO]);

}



# Transforma data
# $data_os: String Ymd
# retorna: dmY
function amdTOdma($sData) { // by reiwolf
    list($sAno, $sMes, $sDia ) = split('[/.-]', $sData);
    return ("$sDia/$sMes/$sAno" == '//' ? '' : "$sDia/$sMes/$sAno");
}

function formata_entrada($sTxt){
	return ($sTxt);
}

//
function format_data($sTxt){
	return utf8_encode($sTxt);
//	return "$('#$sId').text('".($sTxt)."');";
}

//
function format_data_valor($sTxt){
	return number_format($sTxt, 2, ',', ' ');
//	return "$('#$sId').text('".($sTxt)."');";
}

?>
