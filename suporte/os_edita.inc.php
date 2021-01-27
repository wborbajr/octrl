<?php
session_start();

	$sOS 				 = $_REQUEST['os'];
	$sOrigem 		 = $_REQUEST['origem'];
	$sPathBase   = $_REQUEST['local'];
	$sLblRetorno = $_REQUEST['label'];

	if (($sOS == '') OR ($sOrigem == '')) {
		echo "Parâmetros inválidos ou inexistentes.";
		return false;
		exit;
	}

	$sPathBase = "../";

	include_once($sPathBase.'conn.inc.php');

	loginValida();


	//Instruções SQL
	$sql = "SELECT  FIRST 1
					r.ID_OS, r.ID_CLIENTE, r.ID_VENDEDOR, r.DT_OS, r.HR_OS, r.DT_ENTREGA,
				    r.COMPRADOR, r.ID_STATUS, r.OBSERVACAO, r.ID_MODULO, r.ENTREGA, r.CHAVE,
				    r.ID_OSATEND, r.DT_GARANTIA, r.ID_OBJETO_CONTRATO, r.DT_RETIRADA
			FROM TB_OS r
			WHERE ID_OS = '$sOS';";


	//Executa a instrução SQL
	$data_os = queryFB($sql, 1, $sOrigem );

	$sLocalidade = (($sOrigem == '') ? $_SESSION[sys][login][localidade][cidade] : $_SESSION[sys][FBConn][$sOrigem][cidade] );

	// $aMaster = array( '10' , '1' ); ;//;
	$bAdmin = $_SESSION[sys][login][admin];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  	<link rel="stylesheet" type="text/css" id="theme" href="<?php echo $sPathBase;?>css/theme-blue.css"/>

	  <script src="<?php echo $sPathBase;?>vendor/jquery/jquery.min.js"></script>
    <!-- script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script -->
	  <script src="<?php echo $sPathBase;?>vendor/bootstrap/js/bootstrap.min.js"></script>

</head>
<body style="padding:10px;">
<center>
<table class="table">
  <tr>
    <td align="center">
<div class="container">
  <h4>Editar Informacões Básicas - OS #<?php echo $sOS;?><br>
  <sup><i>=> <?php echo $sLocalidade;?></i></sup></h4>

  <form role="form">
    <div class="form-group">

    	<input type="hidden" value="<?php echo $sOS;?>" name="iOS" id="iOS" />
	  	<input type="hidden" name="origem" id="origem" value="<?php echo $_REQUEST[origem];?>" />

      <label for="status">Status:</label>
      <select class="selectpicker" data-style="btn-primary" data-width="100%" name="iStatus" id="iStatus">
      	<option value="0">--> Selecione algo</option>
      	<?php
      		$sql = "SELECT ID_STATUS, DESCRICAO, RESERVA, STATUS FROM TB_OS_STATUS WHERE STATUS = 'A'";
					$query = queryFB($sql, '', $sOrigem );

					while ($data = ibase_fetch_assoc($query, IBASE_TEXT)){
						if ($data[ID_STATUS] == $data_os[ID_STATUS]){
							$sSelected = "selected";
							$sStatusAtual = $data[DESCRICAO];
							$sOSStatus = $data[ID_STATUS];
						} else $sSelected = '';

						if ($bAdmin)
						  echo "<option value='$data[ID_STATUS]' $sSelected>".utf8_encode($data[DESCRICAO])." ($data[ID_STATUS])</option>\n";
						else
						if (!in_array($data[ID_STATUS], ["9", "12"]))
							  echo "<option value='$data[ID_STATUS]' $sSelected>".utf8_encode($data[DESCRICAO])." ($data[ID_STATUS])</option>\n";

					}
       	?>
      </select><br/>
      	<?php echo "Status atual: ".$data_os[ID_STATUS].' - '.utf8_encode($sStatusAtual);?>
    </div>

	<?php

		// Status proibido mas é admin
		if ((in_array($data_os[ID_STATUS], ["9", "12"])) && $bAdmin)
			echo '<button type="button" class="btn btn-warning submit"> Gravar </button> ';

		// Status não é proibido
		else if (!in_array($data_os[ID_STATUS], ["9", "12"]))
			echo '<button type="button" class="btn btn-warning submit"> Gravar </button> ';

		// Status proibido e não é admin
		if ((in_array($data_os[ID_STATUS], ["9", "12"])) && !$bAdmin)
			echo '<button type="button" disabled class="btn btn-default"> Não pode ser alterado! </button> ';

		?>
		<button type="button" class="btn btn-success" onclick="javascript:parent.jQuery.fancybox.close();"> Fechar </button>
  </form>
</div>
</td></tr></table>
</center>
</body>
</html>
<script>
$(document).ready(function(){

		$(".submit").click(function(e){
			var oDados = $('form').serialize();
			console.log( 'oDados:', oDados );

			$.ajax({
			  type: "POST",
				url: '<?php echo $sPathBase;?>suporte/suporte.inc.php',
				dataType: 'json',
			  // async: false,
			  data: {acao: 'os_basico_grava', xParam0: oDados},
			  error: function(result){
		        console.log('Error!! ', result);
		        alert('Ocorreu um erro!');
		        $("#message").text(result);
			  },
			  success: function(result){
		        console.log('Sucesso!! ', result);
	        	parent.document.getElementById("<?php echo $sLblRetorno;?>").innerHTML = $("#iStatus :selected").text();
		        parent.jQuery.fancybox.close();
			  }
			});
		});
});
</script>
