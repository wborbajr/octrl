jQuery(function($) {

    // Botao que aciona a impressao e retirada de OS - index
    // $("#btRetirada").on("click", function(e){
    //     bootbox.prompt({
    //                         title: "Informe o nr da OS para fazer a retirada.",
    //                         inputType: 'number',
    //                         callback: function (result) {
    //                             console.log(result);
    //                             bootbox.alert("Em desenvolvimento!");
    //                         }
    //     });
    // })


    // Botão que mostra dados do usuário logado - index
    // $("#btProfile").on("click", function(e){
    //     bootbox.alert("Em desenvolvimento!");
    // })


    //
    /// Funções
    //

    //
    // function show_doc(print_opc){
    //   console.log('show_doc :=> print_opc: ', print_opc);
    //   $("#frame_os_print").attr("href", print_opc);
    //     console.log("modal relativo", ("#frame_os_print").attr("href"));
    //   $("#frame_os_print").click();
    // }

    //
    function print_this(sOpc){
      var sOrigem = $("#select_manutencao_os_origem :selected").val();
      var print_opc = "comum/os_print.php?os="+sOpc+"&origem="+sOrigem;
      console.log('sOrigem', sOrigem);
      console.log('print_opc', print_opc);
      show_doc(print_opc);
    }

    $("#btnPrint").click(function () {
        //get the modal box content and load it into the printable div
        console.log('asd');
        $(".printable").html($("#myModal").html());
        $(".printable #btnPrint").remove();
        $(".printable").printThis({
            debug: false,               // show the iframe for debugging
            importCSS: false,            // import page CSS
            importStyle: false,         // import style tags
            printContainer: true,       // grab outer container as well as the contents of the selector
            // loadCSS: "path/to/my.css",  // path to additional css file - use an array [] for multiple
            pageTitle: "",              // add title to print page
            removeInline: false,        // remove all inline styles from print elements
            printDelay: 333,            // variable print delay; depending on complexity a higher value may be necessary
            header: "<h1>Amazing header</h1>",               // prefix to html
            footer: null,               // postfix to html
            base: false ,               // preserve the BASE tag, or accept a string for the URL
            formValues: true,           // preserve input/form values
            canvas: false,              // copy canvas elements (experimental)
            // doctypeString: "...",       // enter a different doctype for older markup
            removeScripts: false,       // remove script tags from print content
            copyTagClasses: true       // copy classes from the html & body tag
        });
        console.log('asd');
    });




    // Fill modal with content from link href
    $("#modal_os").on("show.bs.modal", function(e) {
      console.log('opa.... funcionou.');

      var sOpc = "6090";
      var sOrigem = $(".select_origem :selected").val();
  	  var print_opc = "comum/os_print.php?os="+sOpc+"&origem="+sOrigem;
  	  // console.log('sOrigem', sOrigem);
  	  // console.log('print_opc', print_opc);

      //
      // $.ajax({
      //     type: "POST",
      //     url: 'comum/os_print.inc.php',
      //     dataType: 'json',
      //     async: true,
      //     data: {os: sOpc, origem: sOrigem},
      //     error: function(result){
      //           console.log('não deu boa',result);
      //     },
      //     success: function(result){
      //       var aDados = result.data;
      //
      //       console.log('aDados', aDados);
      //
      //       $.each(aDados, function(index, value) {
      //           // console.log(value);
      //           $("#"+index).html(value);
      //       });
      //
      //       // Repasse para os campos da OS
      //       $(".institucional").html(aDados.cab);
      //       // $("#os_nr").text(aDados.os);
      //
      //     }
      // });

        // var link = $(e.relatedTarget);
        // $(this).find(".modal-body").load(link.attr("href"));
    });
})
