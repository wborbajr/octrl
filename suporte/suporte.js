jQuery(function($) {

  // Strict is cool.
  'use strict';

	console.log("jquery");

	  //
	  $("#form_busca button").click(function(){
        processTimeModalInt = 0;

				var xVal = $("#os_busca").val();
				var sTipoBusca = $(this).attr('rel');
				var sOrigem = $("#select_os_origem").val();

				$("#div_cliente_print").html('Buscar por ' + sTipoBusca + ' - Critério: ' + xVal);
				$("#cliente_os_div").html('Aguarde, acessando banco de dados...');

				//
				if (xVal == ''){
					  $("#div_cliente_print").html('Critério: Informe algo para pesquisa.');
					  //show('ATENÇAO!',"Informe um(a) "+sTipoBusca+" a ser pesquisado(a).");
					  $("#cliente_busca").focus();
					  return false;

				} else {

			      console.log(sTipoBusca, xVal);
						$.mpb('show',{value: [0,30],speed: 5});
						$('#processTimeModal').modal({show:true})

						//
			      $.ajax({
					        type: "POST",
					        url: 'suporte/suporte.inc.php',
					        dataType: 'json',
					        // async: false,
					        data: {acao: 'os_busca', xParam0: sTipoBusca, xParam1: xVal, xParam2: sOrigem},
									beforeSend: function(){
												$.mpb('update',{value: [30,60],speed: 5});
												console.log("envidado....");
									},
									complete: function(){
                        $('#processTimeModal').modal('hide');
                        // processTimeModalInt = 150;
												$.mpb('update',{value: [60,100],speed: 5});
									},
					        error: function(result){
					              console.log('error',result);
												// $('#processTimeModal').modal('hide');
					              $("#cliente_os_div").html(result.responseText);
					        },
					        success: function(result){
						        console.log(result);

						        $("#cliente_os_div").slideUp('fast', function(){

							        if (result != null)
							          $("#cliente_os_div").html(result.msg);
							        else
							          $("#cliente_os_div").html("OS Não encontrada.");

						        }).slideDown();
					    	}
			      });

		    };

				// $.mpb('update',{value: [60,100],speed: 10}).mpb('destroy');
				console.log('acabou');

				return false;
		});


	//
	/// Funções
	//

	//
	function chaveTratar(sTxt) {
	  var sRtn = sTxt;

	  // retira excesso de mascara
	  if (sRtn.search('-__') > 0)
	    sRtn = sRtn.substring(0, sRtn.search('-__') );

	  if (sRtn.search(' __') > 0)
	    sRtn = sRtn.substring(0, sRtn.search(' __') );

	    if (sRtn.search('_') > 0)
	    sRtn = sRtn.substring(0, sRtn.search('_') );

	//  console.log( 'texto', sRtn);
	//  console.log( 'mask', sRtn.search('_') );

	  // Valida quantidade correta de elementos
	  if (sRtn.search('_') > 0)
	    sRtn = '';

	  return sRtn;
	};

	$('#cliente_os_div').on('click','button', function(e){

    var sBotao = $(this).html();

    console.log("botão origem:", sBotao);

    switch (sBotao) {
      case "Print":
          // Impressão da OS
          $("#frame_os_print").attr({
              'hideOnContentClick': true,
              'processData': false,
              'cache': false,
              'contentType': false,
              'href': "comum/os_print.php?os="+$(this).attr("data-os")+"&origem="+$(this).attr("data-origem")
          }).click();
        break;

      // OBS
      case "OBS":
        console.log("entrei no obs");
        // obs_this($data->ID_OS, $data->ID_STATUS);

        // $("#frame_os_cad").fancybox({'width':450, 'height':300, 'autoSize' : false});

        $("#frame_os_cad").attr({
            'width':450, 'height':300, 'autoSize' : false,
            'hideOnContentClick': true,
            'processData': false,
            'cache': false,
            'contentType': false,
            'href': "suporte/os_cad_obs.php?os="+$(this).attr("data-os")+"&origem="+$(this).attr("data-origem")+"&status="+$(this).attr("data-status")
        }).click();
        break;

      // Status
      case "Status":
        console.log("entrei no status");
        // osEdita($data->ID_OS);

        $("#frame_os_cad").attr({
            'width':450, 'height':550, 'autoSize' : true,
            'hideOnContentClick': true,
            'processData': false,
            'cache': false,
            'contentType': false,
            'href': "suporte/os_edita.inc.php?os="+$(this).attr("data-os")+"&origem="+$(this).attr("data-origem")+"&status="+$(this).attr("data-status")
        }).click();

        // var sOrigem = $("#select_manutencao_os_origem :selected").val();
        // console.log('osEdita: ', sOpc, sOrigem);
        // $("#pop_edit_os").attr("href", 'os_edita.inc.php?os='+sOpc+"&origem="+sOrigem);
        // $("#pop_edit_os").click();
        break;

      // Troca
      case "Troca":
          console.log("entrei no troca");
          // osEdita_funcionario($data->ID_OS, "ID_TECNICO_RESP", $data->ID_TECNICO_RESP);
          $("#frame_os_cad").attr({
              'width':450, 'height':550, 'autoSize' : true,
              'hideOnContentClick': true,
              'processData': false,
              'cache': false,
              'contentType': false,
              'href': "suporte/os_tecnico.inc.php?os="+$(this).attr("data-os")+
              "&origem="+$(this).attr("data-origem")
          }).click();
          break;

      default:

    }


    function obs_this(sOpc, sStatus){
      var sOrigem = $("#select_manutencao_os_origem :selected").val();
      console.log('obs: ', sOpc, sStatus);
      $("#frame_os_cad")
        .attr("href", 'os_cad_obs.php?os='+sOpc+"&origem="+sOrigem+"&status="+sStatus)
        .click();
    }


		// $(".various").fancybox({
		// 	href : print_opc,
		// 	type : 'iframe',
		//   maxWidth  : '910',
		//   maxHeight : '100%',
		//   fitToView : false,
		//   width   : '90%',
		//   height    : '90%',
		//   autoSize  : false,
		//   closeClick  : false,
		//   openEffect  : 'true',
		//   closeEffect : 'true',
		//   afterLoad: function() {
		//     /*this.title = '<a href="' + this.href + '">Imprimir</a> ' + this.title;
		//     this.title = '<input type="button" onclick="javascript:window.print();" value="Imprimir" />';*/
		// 		console.log("carregou...");
		//   },
		//   helpers : {
		//     title: {
		//       type: 'inside'
		//     }
		//   }
		// });


	  // $("#frame_os_print").attr("href", print_opc);

		// $("#frame_os_print").attr("data-src", print_opc).click();
		// $("#frame_os_print").open(print_opc);

		// $("#frame_os_print").click();

	})

	// function print_this(sOpc, sOrigem){
  //
	// 	// var sOpc = "4707";
	// 	// var sOrigem = $(".select_origem :selected").val();
	// 	alert("achou!!");
	// 	console.log(sOpc, sOrigem);
  //
	// 	// var sOrigem = $("#select_manutencao_os_origem :selected").val();
	// 	var print_opc = "../comum/os_print.php?os="+sOpc+"&origem="+sOrigem;
	// 	console.log('sOrigem', sOrigem);
	// 	console.log('print_opc', print_opc);
	// 	show_doc(print_opc);
	// 	// window.open(print_opc);
	// }


});
