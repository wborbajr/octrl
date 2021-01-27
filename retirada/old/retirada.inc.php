<?php
	session_start();

  include_once('../conn.inc.php');

	$sAcao = $_REQUEST[acao];
	$xParam0 = $_REQUEST[xParam0];
	$xParam1 = $_REQUEST[xParam1];
	$xParam2 = $_REQUEST[xParam2];

	switch ($sAcao) {
		case "vendas_os_busca":
      	$aRtn = vendas_os_busca($xParam0, $xParam1, $xParam2);
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
function vendas_os_busca($sTipo, $xValor, $sOrigem){

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
  		$sRtn = '<p class="box box-solid bg-yellow">As últimas 15 OS\'s</p>';
  		$sNome = '';
  		while ($data = ibase_fetch_object ($res)) {

				$i++;
  			// if ($sNome != $data->CLIENTE)
        {

  				$sNome = $data->CLIENTE;
  				$sRtn .= "<br/><p>".utf8_encode($sNome). '<code> [ ' . $_SESSION[sys][FBConn][$sOrigem]['cidade'] ." ]</code></p>
  						<table border=1	 width='100%' cellspacing='0' cellspacing='0' class='table table-bordered'>
  						  <thead>
    						  <tr>
      							<th width=30>OS</th>
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
                  <button class='btn btn-sm btn-primary print_os' data-os='$data->ID_OS' data-origem='$sOrigem'>Print</button>
    						</td>
  					  </tr>
              <tr>
                <td align='right' colspan='100%'>
  					         Responsavel Tecnico: <strong><span id=tecnico_nome>".$data->NOME_TECNICO_RESP."</span></strong>&nbsp;
  					    </td>
              </tr>" );

  			$sRtn .= "</tbody></table>";

  		}


  	}

		if ($i==0)
			$sRtn = "<p align=center>Nenhum registro encontrado.</p>";


  return Array(code => $i, data => [], msg => $sRtn);
}


?>
