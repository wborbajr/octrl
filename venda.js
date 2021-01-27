jQuery(function($) {

		console.log("jquery");

		var oCliente = {};

		// $('#modal_cliente1').modal({ keyboard: false })   // initialized with no keyboard

		$("#DT_ENTREGA").val( somaDias(12) );

		// Validação de CPF/CNPJ - inicio
		// ****************************************************************

		$("#CPF_CNPJ").on('focus',function(){
			var oDoc = $("#CPF_CNPJ");

			// console.log( CPF.strip( oDoc.val() ) );

			oDoc.val(CPF.strip( oDoc.val() ));
			//=> 53282085796

		}); // ***

		$("#END_CEP").on('blur',function(){
			// var sCEP = $("#END_CEP").val();
			var sCEP = $(this).val().replace(/\D/g, '');

				$.ajax({
								 url: "comum/busca_cep.inc.php?cep="+sCEP,
								 dataType: "JSON",
								 async: true,
								 success:function(e, textStatus, jqXHR)
								 {
											console.log(e);

										$("#END_LOGRAD").val(e.logradouro);
										$("#END_BAIRRO").val(e["bairro"]);
										$("#CIDADE").val(e.cidade);
										$("#ID_CIDADE").val(e.ibge);
										$("#UF").val(e.estado);

										$('#END_TIPO').val('Rua');

								 },
								 error: function(e){
										console.log('não deu', e);
										alert("Houve um erro inesperado. Operação não concluida.");
								 }
			 });
		});


		$("#CPF_CNPJ").on('blur',function(){
			var oDoc = $("#CPF_CNPJ");

			// Retira
			oDoc.val(CPF.strip( oDoc.val() ));

			var tamanho = oDoc.val().length;
			// console.log( oDoc.val(), tamanho);

			if (tamanho == 0) {
				return false;
			}

			//
			if ((tamanho == 11) || (tamanho == 14)){

				// Formata
				oDoc.val(CPF.format( oDoc.val() ));
				//=> 532.820.857-96

				sDoc = oDoc.val(); // para recuperação e uso em novo cadastro
				validaDoc(oDoc.val());

				oObj = oCliente;

				console.log("oObj", oObj);

				// Alimenta os combos com os valores encontrados
				$.each(oObj, function(index, value){
					$("#"+index).val(value);
					// console.log(index, value);
				});

				$("#MINHAOBSERVACAO").text('').html( oObj.OBSERVACAO );
				$("#MINHAMENSAGEM").val( oObj.MENSAGEM );

				// Valida se é cliente novo
				if (oObj.ID_CLIENTE){
					$("#clienteID").html(oObj.ID_CLIENTE);
					$("#ID_CLIENTE").val(oObj.ID_CLIENTE);
					$("#clienteDataCad").html(oObj.DT_CADASTRO);

				} else { // valores iniciais para novos cadastros
					$("#clienteID").html('NOVO');
					$("#CPF_CNPJ").val(sDoc);
					$("#clienteDataCad").html(dataAgora());

				}

			} else return false; //

		}); // ***


		function somaDias(iDias){
			var time = new Date();
			var data = new Date();
			data.setDate(time.getDate() + iDias); // Adiciona 3 dias

			// let dia = String(outraData.getDay()+1);
			// let mes = String(outraData.getMonth()+1);
			// let ano = String(outraData.getFullYear());
      //
			// let novaData = dia + '/' + mes +'/' + ano;

			var dia = data.getDate();
			if (dia.toString().length == 1)
				dia = "0"+dia;
			var mes = data.getMonth()+1;
			if (mes.toString().length == 1)
				mes = "0"+mes;
			var ano = data.getFullYear();
			novaData = dia+"/"+mes+"/"+ano;
			// alert(novaData);

			console.log('somaDias', novaData, time);
			return novaData;
		}


		function validaDoc(sDoc){
			// console.log('sDoc', sDoc);

			//timeOutCtrl(); // Inicia a contagem para logout automático

			$.ajax({
						 url: "venda/venda.inc.php",
						 data: {acao: 'clie_busca', obj: sDoc},
						 dataType: "JSON",
						 async: false,
						 success:function(data, textStatus, jqXHR)
						 {

							 console.log(data);

							  // erro
							 	if (!data.code) {
							 			alert(data.msg);
										return false;
							 	}

								// Guarda o retorno
								// var oObj = data.data[0];
								oCliente = data.data[0];

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


		// Objetos da OS
		$.ajax({
			url: "venda/venda.inc.php",
			data: {'acao': 'comboTabelaBasica', obj: ['TB_OS_OBJETO', "ID_OBJETO, DESCRICAO", ""]},
			method: "POST",
			dataType: "JSON",
			// dataType: "html",
			success:function(data, textStatus, jqXHR){
				// console.log(data);
				$("#cbObjeto").html(data.msg);
			},
			error:function(e){
				console.log(e);
			}
		});


		// Status da OS
		$.ajax({
			url: "venda/venda.inc.php",
			data: {'acao': 'comboTabelaBasica', obj: ['TB_OS_STATUS', "ID_STATUS, DESCRICAO", "6"]},
			method: "POST",
			dataType: "JSON",
			// dataType: "html",
			success:function(data, textStatus, jqXHR){
				// console.log(data);
				$("#cbSituacao").html(data.msg);
			},
			error:function(e){
				console.log(e);
			}
		});


		// Tipo de atendimento da OS
		$.ajax({
			url: "venda/venda.inc.php",
			data: {'acao': 'comboTabelaBasica', obj: ['TB_OS_ATENDIMENTO', "ID_OSATEND, DESCRICAO", "1"]},
			method: "POST",
			dataType: "JSON",
			// dataType: "html",
			success:function(data, textStatus, jqXHR){
				// console.log(data);
				$("#cbTipoAtendimento").html(data.msg);
			},
			error:function(e){
				console.log(e);
			}
		});



		// Select de técnicos
		$.ajax({
			url: "venda/venda.inc.php",
			data: {'acao': 'tecnicoCarga', obj: ["SUPERVISOR"]},
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


		// OS - combos de atendente e técnico
		$.ajax({
			url: "venda/venda.inc.php?acao=atendenteCarga",
			method: "POST",
			dataType: "JSON",
			// dataType: "html",
			success:function(data, textStatus, jqXHR){
				// console.log(data);
				$("#cbAtendente").html(data.msg);
				$("#cbItemTecnico").html(data.msg);
				// $("#ID_TECNICO").html(data.msg);
			},
			error:function(e){
				console.log(e);
			}
		});


		// OS - campo doc deixa somente numeros, quando estiver selecionado
		$("#cpClieDoc").on('focus',function(){
			var oDoc = $("#cpClieDoc");

			// console.log( CPF.strip( oDoc.val() ) );

			oDoc.val(CPF.strip( oDoc.val() ));
			//=> 53282085796

		}); // ***


		// OS - valida doc ao sair do campo
		$("#cpClieDoc").on('blur',function(){
			var oDoc = $("#cpClieDoc");

			// Retira
			oDoc.val(CPF.strip( oDoc.val() ));

			var tamanho = oDoc.val().length;
			// console.log( oDoc.val(), tamanho);

			//
			if (tamanho == 11){
				// Formata
				oDoc.val(CPF.format( oDoc.val() ));
				//=> 532.820.857-96

			} else
				if (tamanho == 14){

					// Formata
					oDoc.val(CNPJ.format( oDoc.val() ));

				} else return false; //

		}); // ***


		function hoje(sModo){
			// Obtém a data/hora atual
			var data = new Date();

			// Guarda cada pedaço em uma variável
			var dia     = data.getDate();           // 1-31
			var dia_sem = data.getDay();            // 0-6 (zero=domingo)
			var mes     = data.getMonth();          // 0-11 (zero=janeiro)
			var ano2    = data.getYear();           // 2 dígitos
			var ano4    = data.getFullYear();       // 4 dígitos
			var hora    = data.getHours();          // 0-23
			var min     = data.getMinutes();        // 0-59
			var seg     = data.getSeconds();        // 0-59
			var mseg    = data.getMilliseconds();   // 0-999
			var tz      = data.getTimezoneOffset(); // em minutos

			// Formata a data e a hora (note o mês + 1)
			var str_data = ('0'+dia).substr(-2,2) + '/' + ('0'+(mes+1)).substr(-2,2) + '/' + ano4;
			var str_hora = ('0'+hora).substr(-2,2) + ':' + ('0'+min).substr(-2,2) + ':' + ('0'+seg).substr(-2,2);

			sRtn = str_data + ' ' + str_hora;

			if (sModo == 'data') sRtn = str_data;
			if (sModo == 'hora') sRtn = str_data;


			return sRtn;
		}

		// OS - botão de gravação
		$("#btOSGrava").on('click',function(){
			Date.prototype.addHoras = function(horas){
					this.setHours(this.getHours() + horas)
			};
			Date.prototype.addMinutos = function(minutos){
					this.setMinutes(this.getMinutes() + minutos)
			};
			Date.prototype.addSegundos = function(segundos){
					this.setSeconds(this.getSeconds() + segundos)
			};
			Date.prototype.addDias = function(dias){
					this.setDate(this.getDate() + dias)
			};
			Date.prototype.addMeses = function(meses){
					this.setMonth(this.getMonth() + meses)
			};
			Date.prototype.addAnos = function(anos){
					this.setYear(this.getFullYear() + anos)
			};

			// var dt = new Date();
			var agora = new Date();
			var dtEntrega = new Date();
			dtEntrega.setDate(agora.getDate() + 2); // Adiciona 2 dias

			// dtEntrega.addDias(2);
			//
			var oGravar = {
								"ID_OS" : 0,
								"ID_CLIENTE" : $("#lblID_CLIENTE").html(),
								"ID_VENDEDOR" : $("#cbAtendente").val(),
								"ID_STATUS" : $("#cbSituacao").val(),
								"ID_TECNICO_RESP" : $("#cbTecnico").val(),
								"DT_ENTREGA" : dtEntrega,
								"DT_OS" : hoje('data'),
								"HR_OS" : $("#relogio").html(),
								"ID_MODULO" : "22",
								"OBSERVACAO" : $("#OBSERVACAO").val(),
								"ID_OBJETO_CONTRATO" : $("#cbTecnico").val(),

								"MODELO" : $("#MODELO").val(),
								"SERIAL" : $("#SERIAL").val(),
								"ACESSORIOS" : $("#ACESSORIOS").val(),
								"PRISMA" : $("#PRISMA").val(),
								"ADICIONAL" : $("#ADICIONAL").val(),
								"DEFEITO" : $("#DEFEITO").val(),
								"LOCALIZACAO" : $("#LOCALIZACAO").val(),
								"DT_GARANTIA" : $("#DT_GARANTIA").val(),
								"OBSERVACAO" : $("#OBSERVACAO").val(),
								"MENSAGEM" : $("#MENSAGEM").val(),
								"STATUS" : $("#STATUS").val()
							};

			// var oObj = {
			// 							"acao": "os_insert",
			// 							"obj": oGravar
			// 						};

			if (validaCamposObrigatorio("CPF/CNPJ", $("#cpClieDoc").val())) {

				// $("#ID_CLIENTE").val($("#lblID_CLIENTE").html());
				// $("#ID_VENDEDOR").val($("#cbAtendente").val());
				// $("#ID_STATUS").val($("#cbSituacao").val());
				// $("#ID_TECNICO_RESP").val($("#cbTecnico").val());
				// $("#DT_ENTREGA").val(dtEntrega);
				$("#DT_OS").val(hoje('data'));
				$("#HR_OS").val($("#relogio").html());
				$("#ID_MODULO").val("22");
				$("#OS_CPF_CNPJ").val($("#lblCPF_CNPJ").html());
				$("#OS_CLIE_NOME").val($("#lblNOME").html());
				// $("#OBSERVACAO").val($("#OBSERVACAO").val());
				// $("#ID_OBJETO_CONTRATO").val($("#cbTecnico").val());

				var aCampos = $("#formOS").serialize();
				console.log();
				//
				var oObj = {
											"acao": "os_insert",
											"obj": aCampos
										};


					// saveConfirm(oGravar);
				if (confirm("Confirma a geração da Ordem de Serviço?")) {
					//
					$.ajax({
									url: "venda/venda.inc.php",
									data: oObj,
									method: "POST",
									// dataType: "JSON",
									dataType: "html",
									success:function(data, textStatus, jqXHR){
										console.log("gravou", data);
										console.log("id_os_cad", data.code);
										$("#id_os_cad").text(data.code);
									},
									error:function(e){
										console.log(e);
									}
						});

					}
			}

		}); // ***


		// Função genérica
		function validaCamposObrigatorio(sCampo, sValor){
			if (sValor == "") {
				alert("O Campo " + sCampo + " é OBRIGATÓRIO!");
				return false;
			} else return true;
		}


		// OS - pesquisar cliente
		$("#btnCliePesquisar").on("click", function(e){
			var oDoc = $("#cpClieDoc");

			// Retira
			oDoc.val(CPF.strip( oDoc.val() ));

			var tamanho = oDoc.val().length;

			//
			// if ((tamanho == 11) || (tamanho == 14))
			{

				// Formata
				oDoc.val(CPF.format( oDoc.val() ));

				validaDoc(oDoc.val());

				var oObj = oCliente;

				console.log('pesquisar',oObj);

				$("#IDCLIENTE").val(oObj.ID_CLIENTE);

				// Alimenta os combos com os valores encontrados
				$.each(oObj, function(index, value){
					$("#lbl"+index).html(value);
					// console.log(index, value);
				});

			};

		});


		// Formulario de clientes - grava insert ou update
		$("#btnClieGrava").on('click',function(){
			var sModo = "clie_update";
			var bNovo = ($("#clienteID").html() == "NOVO");

			//
			if (bNovo){
				sModo = "clie_insert";
				$("#DT_CADASTRO").val($("#clienteDataCad").html());
			};

			var aCampos = $("#frmCliente").serialize();
			//
			var oObj = {
										"acao": sModo,
										"obj": aCampos
									};

      // Campos obrigatórios
			var oGravar = {
												"id_cliente" : $("#ID_CLIENTE").val(),
												"nome" : $("#NOME").val(),
												"ID_PAIS" : $("#ID_PAIS").val(),
												"status" : "A",
												"ID_CIDADE" : $("#ID_CIDADE").val()
		 									};

			console.log("oObj:", oObj);
			// console.log("gravar:", oGravar);

			if (validaCamposObrigatorio("CPF/CNPJ", $("#CPF_CNPJ").val())) {
					// saveConfirm(oGravar);
					var sTxt = "Confirma a ATUALIZAÇÃO dos dados do cliente?";

					if (bNovo)
						sTxt = "Confirma o CADASTRO do NOVO cliente?"

					if (confirm(sTxt)) {
							// console.log('formenvie', oObj);

							//
							$.ajax({
											url: "venda/venda.inc.php",
											data: oObj,
											method: "POST",
											// dataType: "JSON",
											dataType: "html",
											success:function(data, textStatus, jqXHR){
												console.log("gravou", data);
												console.log("gravou", textStatus);
												console.log("gravou", jqXHR);
											},
											error:function(e){
												console.log(e);
											}
								});

						}
			}

		}); // ***


		$.noty.defaults.theme = 'relax';

		$.noty.defaults = {
		  layout: 'top',
		  theme: 'defaultTheme', // or relax
		  type: 'alert', // success, error, warning, information, notification
		  text: '', // [string|html] can be HTML or STRING

		  dismissQueue: true, // [boolean] If you want to use queue feature set this true
		  force: false, // [boolean] adds notification to the beginning of queue when set to true
		  maxVisible: 5, // [integer] you can set max visible notification count for dismissQueue true option,

		  template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',

		  timeout: false, // [integer|boolean] delay for closing event in milliseconds. Set false for sticky notifications
		  progressBar: false, // [boolean] - displays a progress bar

		  animation: {
		    open: {height: 'toggle'}, // or Animate.css class names like: 'animated bounceInLeft'
		    close: {height: 'toggle'}, // or Animate.css class names like: 'animated bounceOutLeft'
		    easing: 'swing',
		    speed: 500 // opening & closing animation speed
		  },
		  closeWith: ['click'], // ['click', 'button', 'hover', 'backdrop'] // backdrop click will close all notifications

		  modal: false, // [boolean] if true adds an overlay
		  killer: false, // [boolean] if true closes all notifications and shows itself

		  callback: {
		    onShow: function() {},
		    afterShow: function() {},
		    onClose: function() {},
		    afterClose: function() {},
		    onCloseClick: function() {},
		  },

		  buttons: false // [boolean|array] an array of buttons, for creating confirmation dialogs.
		};


		// $('.combobox').combobox();

		// bonus: add a placeholder
		// $('.combobox').attr('placeholder', 'Digite pra ver a mágica."');

	})
