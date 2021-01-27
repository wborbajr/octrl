jQuery(function($) {

    console.log("jQuery");

    var oTableItem = {};

    // $("#form_busca button").click(function(e){
    //   console.log('botão: ', $(this).attr('rel'), $("#select_os_origem").val());
    // })
    // lastOSs();
		$("#lastOSs").click();

    $("#os_busca").focus();

    // Processa os requisitos de retirada
    $("#form_busca button").click(function(){

      var sBotao = $(this).attr('rel');
      var sValor = $("#os_busca").val();
      var sLocalidade = $("#select_os_origem").val();

      console.log("botão origem:", sBotao);
      $("#div_cliente_print").html('');

      switch (sBotao) {
        case "OS1": // Não utilizado mais!!
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
            processTimeModalInt = 0;
            $.mpb('show',{value: [0,30],speed: 5});
            $('#processTimeModal').modal({show:true})

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
  						        console.log('success',e);

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


		// OS - combos de atendente e técnico
		$.ajax({
			url: "venda/venda.inc.php?acao=atendenteCarga",
			method: "POST",
			dataType: "JSON",
			// dataType: "html",
			success:function(data, textStatus, jqXHR){
				// console.log(data);
				$("#cbItemTecnico").html(data.msg);
			},
			error:function(e){
				console.log(e);
			}
		});


    // Apenas fecha o modal de confirmação de retirada de OS
  	$('.modal_retirada a').click(function(){
      $("#modal_retirada").modal("hide");
    });


    // Retirada / Baixa de OS
  	$('#btRetirada').click(function(){

      var sBotao = $(this).attr('rel');
      var sValor = $("#retirada_os").val();
      var sLocalidade = $("#select_os_origem").val();

      console.log("#btRetirada: botão origem:", sBotao, sValor);

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
        var sOrigem = $(this).attr("data-origem");
        var sOS     = $(this).attr("data-os");
        var sItem   = $(this).attr("data-item");
        var sTipo   = $(this).attr("data-tipo");

        console.log("#cliente_os_div: botão origem:", '-'+sBotao+'-');

        if (sBotao == 'Print') {
            // Impressão da OS
            $("#frame_os_print").attr({
                'hideOnContentClick': true,
                'processData': false,
                'cache': false,
                'contentType': false,
                'href': "comum/os_print.php?os="+$(this).attr("data-os")+"&origem="+$(this).attr("data-origem")
            }).click()

        } // if

        if (sBotao == 'Adicionar Item') { // Chama o modal
          oTableItem = $(this); // usado na continuação do processo de add item
          console.log('Tentou adicionar ítem: ', oTableItem.attr("data-os"));
          // $("#itemValor").val( oTableItem.attr("data-os") );
        } // if

        if (sBotao == 'X') {
            // Exclusão de item da OS
            console.log("entrei na Excusão de ítem.");

            $.ajax({
      			  type: "POST",
      				url: 'retirada/retirada.inc.php',
      				dataType: 'json',
      			  // async: false,
      			  data: {acao: 'item_del', xParam0: sOS, xParam1: sItem},
      			  error: function(result){
      		        console.log('Error!! ', result);
      			  },
      			  success: function(result){
      		        console.log('Sucesso!! ', result);
      			  }
      			});

        } // if



        if (sBotao == 'Editar OS') {
            // Exclusão de item da OS
            console.log("entrei na edição de OS.");

            oTableItem = $(this);

            var oObj = {acao: 'os_get', obj: $(this).attr("data-os")};

            console.log('oObj', oObj);

            $.ajax({
        		  type: "POST",
        			url: 'retirada/retirada.inc.php',
        			dataType: 'json',
        		  // async: true,
        		  data: oObj,
        		  error: function(result){
        	        console.log('Error!! [os_get] ', result);
        		  },
        		  success: function(result){
        	        console.log('Sucesso!! ', result);
                  var oObj = result.data;

                  console.log("oObj", oObj.os_id);

                  $("#ret_os_id").html(oObj.os_id);
                  $("#ret_os_adicional").val(oObj.os_adicional);
                  $("#ret_os_objeto_acessorio").val(oObj.os_objeto_acessorio);
                  $("#ret_os_objeto_descricao").html(oObj.os_objeto_descricao);
                  $("#ret_os_objeto_id").val(oObj.os_objeto_id);
                  $("#ret_os_objeto_modelo").val(oObj.os_objeto_modelo);
                  $("#ret_os_objeto_prisma").val(oObj.os_objeto_prisma);
                  $("#ret_os_objeto_serial").val(oObj.os_objeto_serial);
                  $("#ret_os_problema").val(oObj.os_problema);
        		  }
        		});

        } // if



        if (sBotao == 'Status') {
          console.log("entrei no status");
          // osEdita($data->ID_OS);

          $("#frame_os_cad").attr({
              'width':450, 'height':550, 'autoSize' : true,
              'hideOnContentClick': true,
              'processData': false,
              'cache': false,
              'contentType': false,
              'href': "suporte/os_edita.inc.php?os="+$(this).attr("data-os")+
                  "&origem="+$(this).attr("data-origem")+
                  "&status="+$(this).attr("data-status")+
                  "&label="+$(this).attr("data-id")
          }).click();

        } // if


        if (sBotao == 'Troca') {
          console.log("entrei no troca");
          // osEdita_funcionario($data->ID_OS, "ID_TECNICO_RESP", $data->ID_TECNICO_RESP);
          $("#frame_os_cad").attr({
              'width':450, 'height':550, 'autoSize' : true,
              'hideOnContentClick': true,
              'processData': false,
              'cache': false,
              'contentType': false,
              'href': "suporte/os_tecnico.inc.php?os="+$(this).attr("data-os")+
              "&origem="+$(this).attr("data-origem")+
              "&label="+$(this).attr("data-id")
          }).click();

        } // if


        if (sBotao == 'OBS') {
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

        } // if

    });

    $( '#modal_edita_os' )
    	   .on('hide.bs.modal', function(e) {
    				 //  alert("onde voce pensa que vai?");
    	       console.log('hide');
    	   })
    	   .on('hidden.bs.modal', function(){
    	       console.log('hidden');

             var iTblPos = (oTableItem).attr('data-table').substr(11,1);

             $("#status_defeito"+iTblPos).html( $("#ret_os_problema").val() );

             console.log('-----------------------------------');
             console.log('oTableItem', (oTableItem).attr('data-table'), $("#status_defeito"+iTblPos).html());
             console.log('-----------------------------------');

    	   })
    	   .on('show.bs.modal', function() {
    	       console.log('show');
    	   })
    	   .on('shown.bs.modal', function(){
    	      console.log('shown' );
    				$("#itemValor").focus();
    	   });


  $( '#modal_itens_os' )
  	   .on('hide.bs.modal', function(e) {
  				 //  alert("onde voce pensa que vai?");
  	       console.log('hide');
  				//  return false;
  	   })
  	   .on('show.bs.modal', function(oObj) {
  	       console.log('show', oObj);
           // oItemSelecionados = [];
           console.log('tecnico no form', $("#cbItemTecnico").val());

  	   })
  	   .on('shown.bs.modal', function(){
  	      console.log('shown!!' );
  				$("#itemValor").focus();
  	   })
		   .on("hidden.bs.modal", function (e) {
          console.log('tecnico recuperado', $("#cbItemTecnico").val());
          oItemSelecionados.ITEM_TECNICO_ID = $("#cbItemTecnico").val();

          console.log('OS #', oTableItem.attr("data-os"), oTableItem.attr("data-origem") );

          // if (oItemSelecionados.ITEM_TECNICO_ID = 'undefined') {
          //   oItemSelecionados.ITEM_TECNICO_ID = oTableItem.attr("data-tecnico-id");
          // }

  		    // put your default event here
  				console.log("última ação", oItemSelecionados);
          console.log('oTableItem', oTableItem.attr('data-table'));

          if (oItemSelecionado.ID_IDENTIFICADOR != 'undefined') {
            console.log('adiciona linha');

            var sTabela = oTableItem.attr('data-table') + oItemSelecionados.TIPO.substr(0,1);
            var oTabela = $('#'+sTabela);
            var sOS = oTableItem.attr('data-os');

            // console.log('oTabela', oTabela);

            AddItemInOS(oTabela, sOS, oItemSelecionados);
            // AddTableRow($('#'+sTabela), oItemSelecionados);
          }

  				e.preventDefault() // stops modal from being shown
	     });


}); // jQuery




  // grava a partir da tela de edição de OS em index.php
  EditPostOS = function(){

    var oObj = {};

    oObj.os_id                = $("#ret_os_id").html();
    oObj.os_objeto_id         = $("#ret_os_objeto_id").val();
    oObj.os_adicional         = $("#ret_os_adicional").val();
    oObj.os_objeto_acessorio  = $("#ret_os_objeto_acessorio").val();
    oObj.os_objeto_descricao  = $("#ret_os_objeto_descricao").html();
    oObj.os_objeto_modelo     = $("#ret_os_objeto_modelo").val();
    oObj.os_objeto_prisma     = $("#ret_os_objeto_prisma").val();
    oObj.os_objeto_serial     = $("#ret_os_objeto_serial").val();
    oObj.os_problema          = $("#ret_os_problema").val();

    console.log('oObj', oObj);


    var oObj = {
                  "acao": "os_post",
                  "obj": oObj
                };

    // console.log('oObj', oObj);

    $.ajax({
            url: "retirada/retirada.inc.php",
            data: oObj,
            method: "POST",
            dataType: "JSON",
            // dataType: "html",
            complete:function(e){
              console.log('complete:', e);
              // AddTableRow(aCampos.tabela, oItem);
            },
            success:function(data, textStatus, jqXHR){
              console.log("retorno: ", data);
            },
            error:function(e){
              // alert("Erro ao tentar gravar o ítem na OS. Operação não concluída!");
              console.log(e);
            }
      });

  } // fim

  //
  AddItemInOS = function(oTabela, sOS, oItem){

    var oObj = {
                  "acao": "item_add",
                  "obj": sOS,
                  'itens' : oItem
                };

    console.log('oObj', oObj);

    $.ajax({
            url: "retirada/retirada.inc.php",
            data: oObj,
            method: "POST",
            dataType: "JSON",
            // dataType: "html",
            complete:function(e){
              console.log('complete:', e);
              // AddTableRow(aCampos.tabela, oItem);
            },
            success:function(data, textStatus, jqXHR){
              console.log("retorno: ", data);
              AddTableRow(oTabela, oItem);
            },
            error:function(e){
              alert("Erro ao tentar gravar o ítem na OS. Operação não concluída!");
              console.log(e);
            }
      });

  } // fim


  //
  function AddTableRow(oTable, aDados) {

      console.log('AddTableRow', oTable, aDados);

      if (aDados.ID_IDENTIFICADOR == undefined)
        return false;

      var newRow = $("<tr>");
      var cols = "";

      cols += '<td align="right">'+aDados.ID_IDENTIFICADOR+'</td>';
      cols += '<td>'+aDados.PROD_SERV+'</td>';
      cols += '<td align="right">'+aDados.ITEM_QTD+'</td>';
      cols += '<td align="right">UN</td>';
      cols += '<td align="right">'+aDados.PRC_VENDA+'</td>';
      cols += '<td align="right">'+aDados.ITEM_VALOR_TOTAL+'</td>';
      cols += '<td align="right">'+aDados.ITEM_TECNICO_NOME+'</td>';
      cols += '<td>';
      cols += "<button onclick='removeTr(this)' data-tipo='"+aDados.TIPO+"' data-item='"+aDados.ID_IDENTIFICADOR+"' data-os='"+aDados.ID_OS+"' data-origem='$sOrigem' type='button'> X </button>";
      cols += '</td>';

      newRow.append(cols);
      $(oTable).append(newRow);

      return false;

  }; // fim


  //
  function removeTr(item) {
    var tr = $(item).closest('tr');

    tr.fadeOut(400, function() {
      tr.remove();
    });

    return false;

  }; // fim


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

  } // fim
