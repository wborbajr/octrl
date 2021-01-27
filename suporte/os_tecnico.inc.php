<?php
session_start();

	$sOS 	 = $_REQUEST[os];
	$sOrigem = $_REQUEST[origem];
	$sCampo  = $_REQUEST[campo];
	$sValor  = $_REQUEST[valor];
	$sLblRetorno = $_REQUEST['label'];


	if (($sOS == '') OR ($sOrigem == '')) {
		echo "Parâmetros inválidos ou inexistentes.";
		return false;
		exit;
	}

	$sPathBase = "../";

	include_once($sPathBase.'conn.inc.php');


	//Instruções SQL
	$sql = "SELECT  FIRST 1 r.ID_OS, r.ID_TECNICO_RESP, r.NOME_TECNICO_RESP
			FROM V_OS r
			WHERE ID_OS = '$sOS';";

	//Executa a instrução SQL
	$data_os = queryFB($sql, 1, $sOrigem );

	$sql = "SELECT r.ID_FUNCIONARIO, r.NOME, r.DESCRICAO
			FROM V_FUNC_TECNICO r
			ORDER BY r.NOME";
	$res_tecnico  = queryFB($sql, '', $sOrigem );

	$sLocalidade = (($sOrigem == '') ? $_SESSION[sys][login][localidade][cidade] : $_SESSION[sys][FBConn][$sOrigem][cidade] );

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="<?php echo $sPathBase;?>css/bootstrap/bootstrap.min.css" rel="stylesheet">
	  <link rel="stylesheet" href="<?php echo $sPathBase;?>css/bootstrap/bootstrap-select.min.css">
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo $sPathBase;?>css/theme-blue.css"/>

		<script src="<?php echo $sPathBase;?>js/plugins/jquery/jquery.min.js"></script>
	  <!-- script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script -->
	  <script src="<?php echo $sPathBase;?>js/plugins/bootstrap/bootstrap.min.js"></script>
	  <!-- <script src="<?php echo $sPathBase;?>js/plugins/bootstrap/bootstrap-select.js"></script> -->
</head>
<body>
<div class="container" style="margin: 0 auto; width:500px;">
	<br />
  <h4>Editar Informações Básicas - OS #<?php echo $data_os[ID_OS];?><br>
  <sup><i>=> Loja <?php echo "$sLocalidade";?></i></sup></h4>


  <form role="form">

    <input type="hidden" value="<?php echo $sOS;?>" name="sOS" id="sOS" />
    <input type="hidden" value="<?php echo $sOrigem;?>" name="sOrigem" id="sOrigem" />

    <div class="form-group">
      <label for="iTecnico">Técnico Resposavel: </label>
      <select class="selectpicker" data-style="btn-primary" data-width="100%" name="iTecnico" id="iTecnico">
      	<option value="0">--> Selecione algo</option>
      	<?php
				while ($data = ibase_fetch_assoc($res_tecnico, IBASE_TEXT)){
				if ($data[ID_FUNCIONARIO] == $data_os[ID_TECNICO_RESP]){
					$sSelected = "selected";
					$sValorAtual = $data[NOME];
				} else $sSelected = '';
				echo "<option value='$data[ID_FUNCIONARIO]' $sSelected>".$data[NOME]." ($data[ID_FUNCIONARIO])</option>\n";
			}
       	?>
      </select><br/>
      	<?php echo "Técnico atual: ".$sValorAtual;?>
    </div>
    <button type="button" class="btn btn-warning submit">Gravar</button>
		<button type="button" class="btn btn-success" onclick="javascript:parent.jQuery.fancybox.close();"> Fechar </button>
  </form>
	<br/>
</div>

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
			  async: false,
			  data: {acao: 'os_tecnico_grava', xParam0: oDados},
			  error: function(result){
		        console.log('Error!! ', result);
		        alert('Ocorreu um erro!');
		        $("#message").text(result);
			  },
			  success: function(result){
		        console.log('Sucesso!! ', result);
	        	parent.document.getElementById("<?php echo $sLblRetorno;?>").innerHTML = $("#iTecnico :selected").text();
		        parent.jQuery.fancybox.close();
			  }
			});
		});
	});
</script>
