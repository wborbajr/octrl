var varJQuery = "jQuery";

// var oItemSelecionados = [];
var oItemSelecionado = {
	                          ID_IDENTIFICADOR: 0,
	                          ITEM_TECNICO_ID: 0,
	                          ITEM_TECNICO_NOME: '',
	                          PROD_SERV: '',
	                          PRC_VENDA: '',
	                          ITEM_QTD: 1, /*e.ITEM_QTD,*/
	                          ITEM_VALOR_DESC: 0.00, /*e.ITEM_VALOR_DESC,*/
	                          ITEM_VALOR_TOTAL: 0.00 /*e.ITEM_VALOR_TOTAL*/
	                      };

jQuery(function($) {

		console.log("jquery", varJQuery);

		// lastOSs();
		$("#lastOSs").click();

		var oCliente = {};

		$(".ClientePanel").slideUp('slow');

		// $('#modal_cliente1').modal({ keyboard: false })   // initialized with no keyboard

		$("#DT_ENTREGA").val( somaDias(12) );

		$("#cpClieDoc").focus();

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
								 // url: "comum/busca_cep.inc.php?cep="+sCEP,
								 url: "https://viacep.com.br/ws/"+sCEP+"/json/",
								 dataType: "JSON",
								 async: true,
								 success:function(e, textStatus, jqXHR)
								 {
											console.log(e);

										$("#END_LOGRAD").val(e.logradouro);
										$("#END_BAIRRO").val(e.bairro);
										$("#CIDADE").val(e.localidade);
										$("#ID_CIDADE").val(e.ibge);
										$("#UF").val(e.uf);

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

			if ((tamanho == 0) || (tamanho < 11)) {
				bootbox.alert('Informe um DOCUMENTO válido!');
				return false;
			}

			var sDoc = oDoc.val();
			var sMsgDoc = '';

			if (tamanho == 11) {
				if (!CPF.isValid(sDoc))
					sMsgDoc = 'Informe um CPF válido!!';
			} else if (tamanho == 14){
				if (!CNPJ.isValid(sDoc))
					sMsgDoc = 'Informe um CNPJ válido!';
			} else
				sMsgDoc = 'Informe um DOCUMENTO válido!';

			if (sMsgDoc) {
				bootbox.alert(sMsgDoc);
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
					// $("#"+index).val(value).trim();
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

			// lastOSs();
			$("#lastOSs").click();

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

								$("#DT_ENTREGA").val( somaDias(12) );

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
						$("#CPF_CNPJ").val($("#cpClieDoc").val()).unmask().focus();
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

			// console.log("Tentou gravar");
			// exit;

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
			var oGravar_desativado_não_usado = {
								"ID_OS" : 0,
								"ID_CLIENTE" : $("#lblID_CLIENTE").html(),
								"ID_VENDEDOR" : $("#cbAtendente").val(),
								"ID_STATUS" : $("#cbSituacao").val(),
								"ID_TECNICO_RESP" : $("#cbTecnico").val(),
								"DT_ENTREGA" : dtEntrega,
								"DT_OS" : hoje('data'),
								"HR_OS" : $("#relogio").html(),
								"ID_MODULO" : "22",
								"ID_OBJETO_CONTRATO" : $("#cbTecnico").val(),

								"MODELO" : $("#MODELO").val(),
								"SERIAL" : $("#SERIAL").val(),
								"ACESSORIOS" : $("#ACESSORIOS").val(),
								"PRISMA" : $("#PRISMA").val(),
								"ADICIONAL" : $("#ADICIONAL").val(),
								"DEFEITO" : $("#DEFEITO").val(),
								"LOCALIZACAO" : $("#LOCALIZACAO").val(),
								"DT_GARANTIA" : $("#DT_GARANTIA").val(),
								"OBSERVACAO" : $("#OS_OBSERVACAO").val(),
								"MENSAGEM" : $("#OS_MENSAGEM").val(),
								"STATUS" : $("#OS_STATUS").val()
							};

			// var oObj = {
			// 							"acao": "os_insert",
			// 							"obj": oGravar
			// 						};

			if ((validaCamposObrigatorio("CPF/CNPJ", $("#IDCLIENTE").val())) &&
                (validaCamposObrigatorio("Descrição do Produto", $("#cbObjeto").val()))) {

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
				// var aCampos = $("#formOS").serializeArray();
				console.log('itens a serem gravados: ', oItemSelecionados);
				//
				var oObj = {
											"acao": "os_insert",
											"obj": aCampos,
											// 'itens' : JSON.stringify(oItemSelecionados)
											'itens' : oItemSelecionados
										};
				console.log('gravar agora: ', oObj);

				bConfirmado = confirm("Confirma a geração da Ordem de Serviço?");

				console.log("resultado da opção:", bConfirmado);

					// saveConfirm(oGravar);
				if (bConfirmado) {
					$(".ClientePanel").slideUp('slow');
					var sUltimaOS = $("#id_os_vendedor").html();
          //
					// return false;
					//
					$.ajax({
									url: "venda/venda.inc.php",
									data: oObj,
									method: "POST",
									dataType: "JSON",
									// dataType: "html",
									complete:function(e){

										// lastOSs();
										$("#lastOSs").click();

										if (sUltimaOS != $("#id_os_vendedor").html()) {
											$("#formOS")[0].reset();
											print_os($("#id_os_vendedor").html()); // neste arquivo
										}
										console.log('complete:', e);
									},
									success:function(data, textStatus, jqXHR){
										console.log("retorno: ", data);
										console.log("id_os_cad: ", data.code);

										// lastOSs();
										$("#lastOSs").click();

										print_os(data.code); // neste arquivo
										$("#formOS")[0].reset();

										// Chamar a função que recupera as ultimas informações
										// $("#id_os_geral").html(data.data.geral);
										// $("#id_os_vendedor").html(data.data.vendedor);

										window.open();
									},
									error:function(e){
										// alert("Erro ao tentar gravar a OS. Operação não concluída!");
										console.log("Erro ao tentar gravar a OS. Operação não concluída!", e);
									}
						});

					}
			}

		}); // ***

		$("#btnteste").click(function(){
			console.log("teste", oItemSelecionados);
			oItemSelecionados = [];
		})
		// Função genérica
		function validaCamposObrigatorio(sCampo, sValor){
			if (sValor == "") {
				alert("O Campo " + sCampo + " é OBRIGATÓRIO!");
				return false;
			} else return true;
		}


		// OS - pesquisar cliente
		$("#btnCliePesquisar").on("click", function(e){
					var sDoc = $("#cpClieDoc").val();

					$("#OS_ITENS_GRAVAR").val("0");
					LimpaVariaveis();

		      if (sDoc == ''){
		          bootbox.alert("Informe um documento para pesquisar.");
		          return false;
		      };

					// Retira
					// sDoc = CPF.strip( sDoc );

					console.log('doc: ', CPF.strip( sDoc ));

					var tamanho = CPF.strip( sDoc ).length;
					var sMsgDoc = '';

					if (tamanho < 11) {
						sMsgDoc = 'Informe um DOCUMENTO válido!';

						} else if (tamanho == 11) {
								if (!CPF.isValid(sDoc))
									sMsgDoc = 'Informe um CPF válido!!';

							} else if (tamanho == 14)
								if (!CNPJ.isValid(sDoc))
									sMsgDoc = 'Informe um CNPJ válido!';

					if (sMsgDoc) {
						bootbox.alert(sMsgDoc);
						return false;
					}

          if (tamanho == 11)
						sDoc = CPF.format( sDoc ); // Formata
					else
						sDoc = CNPJ.format( sDoc ); // Formata

					console.log('formatado: ', sDoc);


					// Alimenta os combos com os valores nulos.
					$(".ClientePanel").slideUp('slow', function(){
						// Pesquisa o documento na base de dados e retorna um obj com o resultado.
						// Todos os campos nulos, se não encontrado.
						// O resultado é retornado na forma de um objeto publico oCliente.
						validaDoc(sDoc);
					});

					var oObj = oCliente;

					console.log('pesquisar',oObj);

					$("#IDCLIENTE").val(oObj.ID_CLIENTE);
					// $("#OS_OBSERVACAO").val(oObj.OBSERVACAO);
					$("#OS_OBSERVACAO").val('Cliente relata que: ');
					$("#OS_MENSAGEM").val(oObj.MENSAGEM);
					$("#OS_STATUS").val(oObj.STATUS);

					// Alimenta os combos com os valores encontrados
					$.each(oObj, function(index, value){
						$("#lbl"+index).html(value);
						// console.log(index, value);
					});

		      //
		      if (!oObj.ID_CLIENTE) {
							$(".ClientePanel").slideUp('slow');

		          bootbox.confirm({
		              message: "Cliente não encontrado! Deseja cadastrar?",
		              buttons: {
		                          confirm: {
		                              label: 'Sim',
		                              className: 'btn-success'
		                          },
		                          cancel: {
		                              label: 'Não',
		                              className: 'btn-danger'
		                          }
		              },
		              callback: function (bSim) {
		                  if (bSim)
													// Clica no botão que abre o modal para edição/cliação de clientes
		                      $("#btnClieNovo1").click();
		              }
		          });
		      } else
						// Cliente encontrado
						$(".ClientePanel").slideDown('slow');

		});


		// Formulario de clientes - grava insert ou update
		$("#btnClieGrava").on('click',function(){

			// Valida campos obrigatórios
			if ($('#NOME').val() == ''){
				$('#NOME').focus().select();
				alert('Campo NOME é obrigatório');
				return false;
			}

			if ($('#END_CEP').val() == ''){
				$('#END_CEP').focus().select();
				alert('Campo CEP é obrigatório');
				return false;
			}

			// Emails
			if ($('#EMAIL_CONT').val() == ''){
				$('#EMAIL_CONT').focus().select();
				alert('Campo E-Mail #1 é obrigatório');
				return false;
			} else if (!IsEmail($('#EMAIL_CONT').val())) {
					$('#EMAIL_CONT').focus().select();
					alert('Campo E-Mail #1 é obrigatório');
					return false;
			}

			// Email de contato igual ao email de nfe
			if ($('#EMAIL_NFE').val() == '')
				$('#EMAIL_NFE').val($('#EMAIL_CONT').val());


			var sModo = "clie_update";
			var bNovo = ($("#clienteID").html() == "NOVO");

			//
			if (bNovo){
				sModo = "clie_insert";
				$("#DT_CADASTRO").val($("#clienteDataCad").html());
			};

			$("#STATUS").val("A");
			$("#DDD_RESID").val( $("#DDD_RESID").val().trim() );

			console.log('antes', $("#DDD_RESID").val());
			console.log('depois', $("#DDD_RESID").val().trim());

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
                        "STATUS" : "A",
                        "ID_CIDADE" : $("#ID_CIDADE").val()
                    };

			console.log("oObj:", oObj);
			// console.log("gravar:", oGravar);

			if (validaCamposObrigatorio("CPF/CNPJ", $("#CPF_CNPJ").val())) {

					// saveConfirm(oGravar);
					var sTxt = "Confirma a ATUALIZAÇÃO dos dados do cliente?";

					if (bNovo)
						sTxt = "Confirma o CADASTRO do NOVO cliente?"

            bootbox.confirm({
                message: sTxt,
                buttons: {
                            confirm: {
                                label: 'Sim',
                                className: 'btn-success'
                            },
                            cancel: {
                                label: 'Não',
                                className: 'btn-danger'
                            }
                },
                callback: function (result) {
                    if (result) {

                        $("#modal_cliente1").modal("hide");
                        bootbox.hideAll();
//                                return false;
//                                console.log("aqui nao passa!");

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
            });
			}

		}); // ***

		function IsEmail(email){
				if (email=='') return false;

				var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
		    var check=/@[\w\-]+\./;
		    var checkend=/\.[a-zA-Z]{2,3}$/;
		    if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){return false;}
		    else {return true;}
		}

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


		$( '#modal_itens_os' )
			   .on('hide.bs.modal', function(e) {
						 //  alert("onde voce pensa que vai?");
			       console.log('hide');
						//  return false;
			   })
			   .on('hidden.bs.modal', function(){
			       console.log('hidden');
			   })
			   .on('show.bs.modal', function() {
			       console.log('show:-', varJQuery);
			   })
			   .on('shown.bs.modal', function(){
			      console.log('shown' );
						// Inicializa as variáveis
						// $("#itemValor").val('');
						// oItemSelecionado = {
						// 											 ID_IDENTIFICADOR: 0,
						// 											 ITEM_TECNICO_ID: 0,
						// 											 ITEM_TECNICO_NOME: '',
						// 											 PROD_SERV: '',
						// 											 PRC_VENDA: '',
						// 											 ITEM_QTD: 1, /*e.ITEM_QTD,*/
						// 											 ITEM_VALOR_DESC: 0.00, /*e.ITEM_VALOR_DESC,*/
						// 											 ITEM_VALOR_TOTAL: 0.00 /*e.ITEM_VALOR_TOTAL*/
						// 									 };

						$("#itemValor").focus();
			   });

		$("#modal_itens_os").on("hidden.bs.modal", function (e) {

		    // put your default event here
				console.log("bye bye", oItemSelecionados);

				// if (!data) return
				e.preventDefault() // stops modal from being shown
		});


		// $('.combobox').combobox();

		// bonus: add a placeholder
		// $('.combobox').attr('placeholder', 'Digite pra ver a mágica."');
		function print_os(iOS){
			// Impressão da OS
			$("#frame_os_print").attr({
					'hideOnContentClick': true,
					'processData': false,
					'cache': false,
					'contentType': false,
					'href': "comum/os_print.php?os="+iOS
			}).click();
		}

		function LimpaVariaveis(){
			oItemSelecionados = {};
			console.log('é pra ter limpado!', oItemSelecionados);
		}

	})

	function mascara(o,f){
			v_obj=o
			v_fun=f
			setTimeout("execmascara()",1)
	}
	function execmascara(){
			v_obj.value=v_fun(v_obj.value)
	}
	function mdata(v){
			v=v.replace(/\D/g,"");
			v=v.replace(/(\d{2})(\d)/,"$1/$2");
			v=v.replace(/(\d{2})(\d)/,"$1/$2");

			v=v.replace(/(\d{2})(\d{2})$/,"$1$2");
			return v;
	}
