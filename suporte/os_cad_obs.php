<?php
  session_start();

  $sOS = $_REQUEST['os'];
  $sOrigem = $_REQUEST['origem'];
  $sPathBase = $_REQUEST['local'];

  if (($sOS == '') OR ($sOrigem == '')) {
    echo "Parâmetros inválidos ou inexistentes.";
    return false;
    exit;
  }

  $sPathBase = "../";
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OMNI INFORMÁTICA - ORDEM DE SERVIÇO</title>
    <script src="<?php echo $sPathBase;?>vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap core CSS -->
    <!-- <link href="<?php echo $sPathBase;?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="<?php echo $sPathBase;?>css/style.css"> -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="<?php echo $sPathBase;?>css/theme-blue.css"/>

</head>
<body style="padding:10px;">

<table class="table" width="100%" style="margin:0 auto;">
  <tr>
    <td align="center">
      <form class="form-signin" role="form" id="_form">
  	  	<input type="hidden" name="origem" id="origem" value="<?php echo $_REQUEST[origem];?>" />
  		<h4>OS #<?php echo $_REQUEST['os']?> - Observação [edição]</h4>


  	    <div class="form-group hide">
  	      <label for="os_prisma">Prisma: </label><br>
  	      <input type="text" id="os_prisma" name="os_prisma" />
  	    </div>

  	    <div class="form-group">
    			<textarea class="field" id="os_obs" rows="8" cols="150"  placeholder="Anotações gerais"></textarea>
    		</div>

    		<button id='btGrava' class="btn btn-warning span6 submit">Gravar</button>&nbsp;<label id="msg"></label>
        <button type="button" class="btn btn-success" onclick="javascript:parent.jQuery.fancybox.close();"> Fechar </button>
  	  </form>
    </td>
  </tr>
</table>

</body>
</html>

<script type="text/javascript">

// Carrega OBS
$.ajax({
  type: "POST",
  url: '<?php echo $sPathBase;?>suporte/suporte.inc.php',
  dataType: 'json',
  async: false,
  data: {acao: 'os_obs', xParam0: "<?php echo $_REQUEST['origem']?>", xParam1: "<?php echo $_REQUEST['os']?>"},
  error: function(result){
      console.log('erro', result);
      alert('Erro!! Nao consegui encontra a OS.')

  },
  success: function(result){
      // console.log('sucesso', result.data);

//      if (result != null) {
        $("#os_obs").html(result.data[0]);
//      } else
//        $("#os_obs").html("OS Não encontrada.");
  }
});



// Gravar
$(".submit").click(function(){
	//
	$.ajax({
	  type: "POST",
	  url: '<?php echo $sPathBase;?>suporte/suporte.inc.php',
	  dataType: 'json',
	  async: false,
	  data: {acao: 'os_obs_grava', xParam0: "<?php echo $_REQUEST['origem']?>", xParam1: <?php echo $_REQUEST['os']?>, xParam2: $("#os_obs").val()},
	  error: function(e){
    		console.log(e);
    		alert( "Erro ao tentar atualizar a OS." );
	  },
	  success: function(e){
    		// console.log('success',e);

    		if (e.code == 1){
    			sRtn = "OS atualizada com sucesso.";
    			javascript:parent.jQuery.fancybox.close();
    		} else
    			sRtn = "Erro ao tentar atualizar a OS.";

    		$("#msg").html( sRtn );
	  }
	});

	return false;
});



</script>
