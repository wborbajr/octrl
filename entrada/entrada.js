jQuery(function($) {

		console.log("jquery");

		console.log("processo abortado.");
		return false;

		console.log("processo abortado.");

		var oCliente = {};

		// $('#modal_cliente1').modal({ keyboard: false })   // initialized with no keyboard


		// Validação de CPF/CNPJ - inicio
		// ****************************************************************

		$("#CPF_CNPJ").on('focus',function(){
			var oDoc = $("#CPF_CNPJ");

			console.log( CPF.strip( oDoc.val() ) );

			oDoc.val(CPF.strip( oDoc.val() ));
			//=> 53282085796

		}); // ***

		$("#CPF_CNPJ").on('blur',function(){
			var oDoc = $("#CPF_CNPJ");

			// Retira
			oDoc.val(CPF.strip( oDoc.val() ));

			var tamanho = oDoc.val().length;
			console.log( oDoc.val(), tamanho);

			//
			if ((tamanho == 11) || (tamanho == 14)){
				console.log('sim');
				// Formata
				oDoc.val(CPF.format( oDoc.val() ));
				//=> 532.820.857-96

				// var oObj =
				validaDoc(oDoc.val());

				oObj = oCliente;

				// Alimenta os combos com os valores encontrados
				$.each(oObj, function(index, value){
					$("#"+index).val(value);
					// console.log(index, value);
				});

				// Valida se é cliente novo
				if (oObj.ID_CLIENTE){
					$("#clienteID").html(oObj.ID_CLIENTE);
					$("#clienteDataCad").html(YmdTodmY(oObj.DT_CADASTRO));

				} else {
					$("#clienteID").html(' *NOVO*');
					$("#CPF_CNPJ").val(sDoc);
					$("#clienteDataCad").html(dataAgora());

				}

			} else return false; //

		}); // ***

		function validaDoc(sDoc){
			// console.log('sDoc', sDoc);
			$.ajax({
						 url: "entrada/entrada.inc.php",
						 data: {acao: 'clie_busca', obj: sDoc},
						 dataType: "JSON",
						 async: false,
						 success:function(data, textStatus, jqXHR)
						 {

							  // erro
							 	if (!data.code) {
							 			alert(data.msg);
										return false;
							 	}

								// Guarda o retorno
								// var oObj = data.data[0];
								oCliente = data.data[0];

								console.log('oObj', oCliente);

								// return oObj;

								// Alimenta os combos com os valores encontrados
								// $.each(oObj, function(index, value){
								// 	$("#"+index).val(value);
								// 	// console.log(index, value);
								// });

						 },
						 error: function(e){
								console.log('não deu', e);
								alert("Houve um erro inesperado. Operação não concluida.");
						 }
					 });
		}; // ***


		//
		function dataAgora(){
		    var data = new Date();
		    var dia = data.getDate();
		    if (dia.toString().length == 1)
		      dia = "0"+dia;
		    var mes = data.getMonth()+1;
		    if (mes.toString().length == 1)
		      mes = "0"+mes;
		    var ano = data.getFullYear();
		    return dia+"/"+mes+"/"+ano;
		}; // ***

		//
		function YmdTodmY(sData){
			var dia = sData.substr(8,2);
			var mes = sData.substr(5,2);
			var ano = sData.substr(0,4);
			return dia+"/"+mes+"/"+ano;
		}; // ***


		$("#btnClieGrava").on("click",function(e){
			var oObj = $("#frmCliente").serialize();
			console.log('formenvie', oObj);
			$.ajax({
							url: "entrada/clie_insert.inc.php",
							data: oObj,
							method: "POST",
							// dataType: "JSON",
							dataType: "html",
							success:function(data, textStatus, jqXHR){
								console.log(data);
							},
							error:function(e){
								console.log(e);
							}
				});
			});


		$("#btnClieGravaContinua").on("click",function(e){
			// console.log($("#form_clie_cad").serialize());
			//
			// $('#modal_cliente1').modal("hide");
			// $('#modal_os1').modal("show");
		});

		$( '#modal_cliente1' )
			   .on('hide.bs.modal', function(e) {
						 //  alert("onde voce pensa que vai?");
			       console.log('hide');
						//  return false;
			   })
			   .on('hidden.bs.modal', function(){
			       console.log('hidden');
			   })
			   .on('show.bs.modal', function() {
						 //  $("#frmCliente").reset();
						 document.getElementById('frmCliente').reset();
			       console.log('show');
			   })
			   .on('shown.bs.modal', function(){
			      console.log('shown' );
						$("#CPF_CNPJ").unmask().focus();
			   });

		$("#modal_cliente1").on("hidden.bs.modal", function (e) {
		    // put your default event here
				console.log("bye bye");
				// if (!data) return
				e.preventDefault() // stops modal from being shown
		});



		// Form OS1
		// **************

		$.ajax({
			url: "entrada/entrada.inc.php",
			data: {'acao': 'comboTabelaBasica', obj: ['TB_OS_OBJETO', "ID_OBJETO, DESCRICAO"]},
			method: "POST",
			dataType: "JSON",
			// dataType: "html",
			success:function(data, textStatus, jqXHR){
				console.log(data);
				$("#cbObjeto").html(data.msg);
			},
			error:function(e){
				console.log(e);
			}
		});


		$.ajax({
			url: "entrada/entrada.inc.php",
			data: {'acao': 'comboTabelaBasica', obj: ['TB_OS_STATUS', "ID_STATUS, DESCRICAO"]},
			method: "POST",
			dataType: "JSON",
			// dataType: "html",
			success:function(data, textStatus, jqXHR){
				console.log(data);
				$("#cbSituacao").html(data.msg);
			},
			error:function(e){
				console.log(e);
			}
		});


		$.ajax({
			url: "entrada/entrada.inc.php?acao=tecnicoCarga",
			method: "POST",
			dataType: "JSON",
			// dataType: "html",
			success:function(data, textStatus, jqXHR){
				// console.log(data);
				$("#cbTecnico").html(data.msg);
			},
			error:function(e){
				console.log(e);
			}
		});


		$.ajax({
						url: "entrada/entrada.inc.php?acao=atendenteCarga",
						method: "POST",
						dataType: "JSON",
						// dataType: "html",
						success:function(data, textStatus, jqXHR){
							// console.log(data);
							$("#cbAtendente").html(data.msg);
						},
						error:function(e){
							console.log(e);
						}
			});


		$("#cpClieDoc").on('focus',function(){
			var oDoc = $("#cpClieDoc");

			console.log( CPF.strip( oDoc.val() ) );

			oDoc.val(CPF.strip( oDoc.val() ));
			//=> 53282085796

		}); // ***




		$("#cpClieDoc").on('blur',function(){
			var oDoc = $("#cpClieDoc");

			// Retira
			oDoc.val(CPF.strip( oDoc.val() ));

			var tamanho = oDoc.val().length;
			console.log( oDoc.val(), tamanho);

			//
			if ((tamanho == 11) || (tamanho == 14)){
				console.log('sim');
				// Formata
				oDoc.val(CPF.format( oDoc.val() ));
				//=> 532.820.857-96

			} else return false; //

		}); // ***




		// pesquisar cliente
		$("#btnCliePesquisar").on("click", function(e){
			var oDoc = $("#cpClieDoc");

			// Retira
			oDoc.val(CPF.strip( oDoc.val() ));

			var tamanho = oDoc.val().length;

			//
			if ((tamanho == 11) || (tamanho == 14)){

				// Formata
				oDoc.val(CPF.format( oDoc.val() ));

				validaDoc(oDoc.val());

				var oObj = oCliente;

				console.log('pesquisar',oObj);

				// Alimenta os combos com os valores encontrados
				$.each(oObj, function(index, value){
					$("#lbl"+index).html(value);
					// console.log(index, value);
				});

			};

		});

		$('.combobox').combobox();

		// bonus: add a placeholder
		$('.combobox').attr('placeholder', 'Digite pra ver a mágica."');

	})
