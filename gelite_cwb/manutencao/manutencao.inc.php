<?php

function dash_base1(){

	$sql = "SELECT count(perf_id) FROM `perfil` WHERE `unid_id` = 1 AND `cont_id` = 1";
	$aRes = query($sql, 1);
	$sRtn = dash1($aRes[0], 'Perfis', $aRes[0]);

	$sql = "SELECT count(grup_id) FROM `grupo` WHERE `unid_id` = 1 AND `cont_id` = 1";
	$aRes = query($sql, 1);
	$sRtn .= dash1($aRes[0], 'Grupos', $aRes[0]);

	$sql = "SELECT count(ele_nome) FROM `elemento` WHERE `unid_id` = 1 AND `cont_id` = 1";
	$aRes = query($sql, 1);
	$sRtn .= dash1($aRes[0], 'Elementos', $aRes[0]);

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

?>