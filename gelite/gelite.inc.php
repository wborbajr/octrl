<?php

function dash_base1($sUnid = 1){

	$sql = "SELECT count(distinct unid_id) FROM `unidade`";
	$aRes = query($sql, 1);
//	$sRtn = dash1(100, 'Unidades', $aRes[0]);

	$sql = "SELECT count(distinct cont_id) FROM `perfil` WHERE `unid_id` = {$sUnid} ";
	$aRes = query($sql, 1);
	// $sRtn = dash1(100, 'Controles', $aRes[0]);
	$sRtn = dash2('Controles', $aRes[0]);

	$sql = "SELECT count(perf_id) FROM `perfil` WHERE `unid_id` = {$sUnid}";
	$aRes = query($sql, 1);
	// $sRtn = dash1(100, 'Perfis', $aRes[0]);
	$sRtn = dash2('Perfis', $aRes[0]);

	$sql = "SELECT count(grup_id) FROM `grupo` WHERE `unid_id` = {$sUnid}";
	$aRes = query($sql, 1);
	// $sRtn .= dash1(100, 'Grupos', $aRes[0]);
	$sRtn .= dash2('Grupos', $aRes[0]);

	$sql = "SELECT count(ele_nome) FROM `elemento` WHERE `unid_id` = {$sUnid}";
	$aRes = query($sql, 1);
	// $sRtn .= dash1(100, 'Elementos', $aRes[0]);
	$sRtn .= dash2('Elementos', $aRes[0]);

	echo $sRtn;

	return false;

}


//*************************
function dash1($val1 = 13, $val2 = 'cabeçalho', $val3 = 'descriçao'){

	$sRtn = '   <div class="infobox infobox-blue2">
					<div class="infobox-progress">
						<div class="easy-pie-chart percentage" data-percent="'.$val1.'" data-size="46">
							<span class="percent">'.$val1.'</span>%
						</div>
					</div>

					<div class="infobox-data">
						<span class="infobox-text">'.$val2.'</span>

						<div class="infobox-content">
							'.$val3.'
						</div>
					</div>
				</div>';

	echo $sRtn;

	return false;
}	



//**************************
function dash2($val1 = 'sem valor', $val2 = 0){

	$sRtn = '<tr>
				<td>'.$val1.'</td>

				<td style="text-align: right;">
					<b class="blue">'.$val2.'</b>
				</td>

			</tr>';


	echo $sRtn;
	return false;
}
?>