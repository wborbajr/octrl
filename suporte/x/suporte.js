jQuery(function($) {
	console.log("jquery");

	$("#form_os_busca button, #a_btn_retirada").click(function(e){

			var sOrigem = $("#select_os_origem").val();
			var iOS = chaveTratar( $("#os_busca").val() );
			var sBotao = $(this).attr('rel');
			var print_opc =  sBotao +  "_print.php?os="+iOS;//+"&origem="+sOrigem;
			console.log('objeto: ', sBotao);
			console.log('sOrigem: ', sOrigem);

			//
			if (iOS == ''){
				alert('ATENÇAO!',"Informe o critério de pesquisa.");
				$("#os_busca").focus();
				return false;
			};


			//

				if ((sBotao == 'DOC') || (sBotao == 'NOME')){

					console.log("doc ou nome");

							var xVal = iOS;
							var sTipoBusca = sBotao;
							// sOrigem -> definido acima.

							$("#div_os_print").html('Buscar por ' + $(this).html() + ' - Critério: ' + xVal);

							$("#div_resultado").slideUp('fast', function(){

									$("#div_resultado").html('teste');

									//
									if (xVal == ''){
										$("#div_cliente_print").html('Critério: Informe algo para pesquisa.');
										show('ATENÇAO!',"Informe um(a) "+sTipoBusca+" a ser pesquisado(a).");
										$("#cliente_busca").focus();
										return false;

									} else {

											console.log(sTipoBusca, xVal, sOrigem);

											//
											$.ajax({
												type: "POST",
												url: 'suporte/suporte.inc.php',
												dataType: 'json',
												async: false,
												data: {acao: 'os_busca', xParam0: sTipoBusca, xParam1: xVal, xParam2: sOrigem},
												error: function(result){
															console.log('erro: ', result);
															$("#div_resultado").html(result.responseText);
												},
												success: function(result){
												console.log('ok: ', result);

												if (result != null) {
													$("#div_resultado").html(result.msg);
												} else
													$("#div_resultado").html("OS Não encontrada.");
												}
											});
									};

									$("#div_resultado").slideDown();
							});

							$("#div_resultado").html("*** Critério solicitado não encontrado.");
							return false;
				}




			// Pesquisa base MySQL
			if (sOrigem == 11) // Base MySql
				if ($(this).attr('rel') == 'os') {

						$("#frame_os_print").attr("href", 'os_mysql_print.inc.php?os_num='+iOS);
						$("#frame_os_print").click();
						return false;

				//
				$.ajax({
					type: "POST",
					url: 'os_mysql_print.inc.php',
					dataType: 'html',
					async: false,
					data: {os_num: iOS},
					error: function(result){

								console.log('Error!! ', result);
								$("#div_os_print").html(result.responseText);
						},
					success: function(result){

							print_opc = print_opc +"&origem="+sOrigem

								console.log(print_opc, result);

								if (result != null) {
									show_doc(print_opc);
								} else
									$("#div_os_print").html("OS Não encontrada.");
							}
				});

				return false;

			}  else {
					$("#div_os_print").html('Recurso não disponível para essa origem.');
					alert('Recurso não disponível para essa orgiem.');
					return false;

			} // pesquisa MySQL Fim

			//*****************



			// Mensagem padrao
			$("#div_os_print").html('Informe o Nr da OS a ser impressa. ');


		// Pesquisa por nr da OS
		if (iOS == ''){
			alert("Informe o critério de pesquisa.");
			$("#os_busca").focus();

		} else {

			//
			$.ajax({
				type: "POST",
				url: 'acoes.inc.php',
				dataType: 'json',
				async: false,
				data: {acao: 'os_busca_nr', xParam0: iOS, xParam1: sOrigem},
				error: function(result){

							console.log('Error!! ', result);
							$("#div_os_print").html(result.responseText);
					},

			 success: function(result){

							console.log('Print OS: ', print_opc, result);

							if (result != null) {
								show_doc(print_opc +"&origem="+sOrigem);

							} else {
									$("#div_os_print").html("OS Não encontrada.");
									alert("OS Não encontrada. "+sOrigem);
								}
						}
			});

		};
		return false;
	});

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
	}


})
