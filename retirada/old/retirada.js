jQuery(function($) {

    console.log("jQuery");

    // $("#form_busca button").click(function(e){
    //   console.log('botão: ', $(this).attr('rel'), $("#select_os_origem").val());
    // })


    // Processa os requisitos de retirada
    $("#form_busca button").click(function(){

      var sBotao = $(this).attr('rel');
      var sValor = $("#os_busca").val();
      var sLocalidade = $("#select_os_origem").val();

      console.log("botão origem:", sBotao);
      $("#div_cliente_print").html('');

      switch (sBotao) {
        case "OS":
          // Impressão da OS
          $("#frame_os_print").attr({
              'hideOnContentClick': true,
              'processData': false,
              'cache': false,
              'contentType': false,
              'href': "comum/os_print.php?os="+sValor+"&origem="+sLocalidade
          }).click();
          break;

        case "RECIBO":
          // Impressão da OS
          $("#frame_os_print").attr({
              'hideOnContentClick': true,
              'processData': false,
              'cache': false,
              'contentType': false,
              'href': "comum/recibo_print.php?os="+sValor+"&origem="+sLocalidade
          }).click();
          break;

          // DOC" OR "NOME"
         default:
            console.log("entrei na busca: ", sBotao);

    				$("#div_cliente_print").html('Buscar por ' + sBotao + ' - Critério: ' + sValor);
    				$("#cliente_os_div").html('Aguarde, acessando banco de dados...');

    				//
    				if (sValor == ''){
    					  $("#div_cliente_print").html('Critério: Informe algo para pesquisa.');
                $("#cliente_os_div").html('Informe algo para pesquisa.');
    					  //show('ATENÇAO!',"Informe um(a) "+sTipoBusca+" a ser pesquisado(a).");
    				} else {

              if (sBotao == 'DOC') {

                  // Retira
            			// sValor.strip( sValor );
            			//=> 53282085796

                  // Formata
          				// sValor.format( sValor );
          				//=> 532.820.857-96
              }

              //
  			      $.ajax({
  					        type: "POST",
  					        url: 'retirada/retirada.inc.php',
  					        dataType: 'json',
  					        // async: false,
  					        data: {acao: 'vendas_os_busca', xParam0: sBotao, xParam1: sValor, xParam2: sLocalidade},
  									beforeSend: function(){
  												$.mpb('update',{value: [30,60],speed: 5});
  												console.log("envidado....");
  									},
  									complete: function(){
                          $('#processTimeModal').modal('hide');
                          // processTimeModalInt = 150;
  												$.mpb('update',{value: [60,100],speed: 5});
  									},
  					        error: function(e){
  					              console.log('error',e);
  												// $('#processTimeModal').modal('hide');
  					              $("#cliente_os_div").html(e);
  					        },
  					        success: function(e){
  						        console.log(e);

  						        $("#cliente_os_div").slideUp('fast', function(){

  							        if (e.msg != null)
  							          $("#cliente_os_div").html(e.msg);
  							        else
  							          $("#cliente_os_div").html("OS Não encontrada.");

  						        }).slideDown();
  					    	}
  			      });

            }

            $("#os_busca").focus();
            break;

      }

    })



    // Apenas fecha o modal de confirmação de retirada de OS
  	$('.modal_retirada a').click(function(){
      $("#modal_retirada").modal("hide");
    });


    // Retirada / Baixa de OS
  	$('#btRetirada').click(function(){

      var sBotao = $(this).attr('rel');
      var sValor = $("#retirada_os").val();
      var sLocalidade = $("#select_os_origem").val();

      console.log("botão origem:", sBotao, sValor);

      // Impressão da OS
      $("#frame_os_print").attr({
          'hideOnContentClick': true,
          'processData': false,
          'cache': false,
          'contentType': false,
          'href': "comum/retirada_print.php?os="+sValor+"&origem="+sLocalidade
      }).click();

    });

    // Abre a tela de impressão
  	$('#cliente_os_div').on('click','button', function(e){

      var sBotao = $(this).html();

      console.log("botão origem:", sBotao);

      // Impressão da OS
      $("#frame_os_print").attr({
          'hideOnContentClick': true,
          'processData': false,
          'cache': false,
          'contentType': false,
          'href': "comum/os_print.php?os="+$(this).attr("data-os")+"&origem="+$(this).attr("data-origem")
      }).click();

    });


})

// Valida se tem um valor no campo referente ao nr da OS
function validaOS(){
  console.log('validaOS');
  if ($("#retirada_os").val()=='')
    alert("Informe um número válido de OS.");
   else {
     $("#retirar_os").html( $("#retirada_os").val() ); // apenas mostra nr OS
     $("#modal_retirada").modal("show");
  }
  return false;
}
