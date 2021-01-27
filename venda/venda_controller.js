
var app = angular.module('myApp', []);
var oItemSelecionados = [];
var oItemSelecionado = {
	                          ID_IDENTIFICADOR: 0,
	                          ITEM_TECNICO_ID: 0,
	                          ITEM_TECNICO_NOME: 'reiwolf',
	                          PROD_SERV: '',
	                          PRC_VENDA: '',
	                          ITEM_QTD: 1, /*e.ITEM_QTD,*/
	                          ITEM_VALOR_DESC: 0.00, /*e.ITEM_VALOR_DESC,*/
	                          ITEM_VALOR_TOTAL: 0.00 /*e.ITEM_VALOR_TOTAL*/
	                      };


// app.run(["$locale", function ($locale) {
//     $locale.NUMBER_FORMATS.GROUP_SEP = ".";
//     $locale.NUMBER_FORMATS.DECIMAL_SEP = ",";
// }]);

// app.filter('decimaliscomma', function(){
//     return function(value) {
//         return value ? parseFloat(value).toFixed(2).toString().replace('.', ',') : null;
//     };
// });

app.controller('AppCtrl', function($scope, $http){

  console.log('AppCtrl', oItemSelecionado);

  $scope.oItemSelecionados = [];

  $scope.itemBuscar = function(sBuscar, sTipo){
    //console.log("bucar o quê? ",sBuscar, sTipo);
    $http
        .get("venda/venda.inc.php?acao=itens_busca&obj="+sBuscar+"&tipo="+sTipo)
        .then(function(e) {
            //console.log('e', e.data);
            $scope.servicoLista = e.data.data;
        });
    //console.log($scope.servicoLista);
  };


	$scope.getLastOS = function(){
		//console.log("getLastOS.");
    $http
        .get("venda/venda.inc.php?acao=getLastOS")
        .then(function(e) {
            //console.log('getLastOS:', e.data);
            // $scope.servicoLista = e.data.data;
        });
    // //console.log($scope.servicoLista);
	}

  $scope.itemSeleciona = function(e){

    // //console.log('e', e);

    var oItemSelecionado2 = {
                                  ID_IDENTIFICADOR: 0,
                                  ITEM_TECNICO_ID: 0,
                                  ITEM_TECNICO_NOME: '',
                                  PROD_SERV: '',
                                  PRC_VENDA: '',
                                  ITEM_QTD: 1, /*e.ITEM_QTD,*/
                                  ITEM_VALOR_DESC: 0.00, /*e.ITEM_VALOR_DESC,*/
                                  ITEM_VALOR_TOTAL: 0.00 /*e.ITEM_VALOR_TOTAL*/
                              };

    $scope.oItemSelecionado = {};

    $scope.oItemSelecionado.ID_IDENTIFICADOR = e.ID_IDENTIFICADOR;
    $scope.oItemSelecionado.PROD_SERV        = e.PROD_SERV;
    $scope.oItemSelecionado.PRC_VENDA        = $scope.decimalpointiscoma(e.PRC_VENDA);
    $scope.oItemSelecionado.ITEM_QTD         = 1;
    $scope.oItemSelecionado.ITEM_VALOR_DESC  = 0.00;
    $scope.oItemSelecionado.ITEM_VALOR_TOTAL = $scope.decimalpointiscoma(e.PRC_VENDA);


    //console.log('e: ', e);

    $scope.cItem_Desconto = 0.00;
    $scope.cItem_Qtd = 1;

    //console.log('$scope.oItemSelecionado:', $scope.oItemSelecionado);
  };

  $scope.itemAdd = function(item){

    //console.log('itemAdd - oItemSelecionado', $scope.oItemSelecionado);
    //console.log('itemAdd - item', item);

    varJQuery = "mudei o valor";

    // Calcula total e, caso precise, alimenta as variáveis com valores válidos
    $scope.itemCalculaTotal();

    item.ITEM_TECNICO_ID   = $scope.cbItemTecnico,
    item.ITEM_TECNICO_NOME = $("#cbItemTecnico :selected").text(),
    item.ITEM_QTD          = $scope.cItem_Qtd;
    item.ITEM_VALOR_DESC   = $scope.cItem_Desconto;
    item.ITEM_VALOR_TOTAL  = (($scope.cItem_Qtd * $scope.oItemSelecionado.PRC_VENDA) - $scope.cItem_Desconto);

    $scope.oItemSelecionados.push( item );
    oItemSelecionados = $scope.oItemSelecionados;
    // //console.log("oItemSelecionados", $scope.oItemSelecionados);

		camposInicializa($scope);
  }

	function camposInicializa($scope){
		$scope.oItemSelecionado = {};
		$scope.servicoLista = {};
		$scope.itemValor = '';

		$scope.cItem_Qtd = '0';
		$scope.cItem_Desconto = '0,00';
	}

  // Remove linha (TR) de um table
  // Usado para eliminar itens da OS
  $scope.itemDel = function(index) {
    // //console.log("oItemSelecionados", $scope.oItemSelecionados[index]);
		$scope.item_valor_total_os = ($scope.item_valor_total_os - $scope.oItemSelecionados[index].PRC_VENDA);
		$scope.oItemSelecionados.splice(index, 1);
    // return false;
  }

	$scope.decimalpointiscoma = function(sVal){
      return sVal ? sVal.toString().replace(',', '') : null;
  };

  $scope.itemCalculaTotal = function(){
    var rResultado = 0;

    if (($scope.cItem_Qtd * 1) == NaN) {
      $scope.cItem_Qtd = 1;
    }
    //console.log('$scope.cItem_Qtd', $scope.cItem_Qtd);

    if (($scope.cItem_Desconto * 1) == NaN) {
      $scope.cItem_Desconto = 0;
    }

		//console.log('$scope.cItem_Desconto', $scope.cItem_Desconto);
		//console.log('$scope.oItemSelecionado.PRC_VENDA', $scope.decimalpointiscoma($scope.oItemSelecionado.PRC_VENDA));

    rResultado = ( ( $scope.cItem_Qtd *
											$scope.decimalpointiscoma($scope.oItemSelecionado.PRC_VENDA)) -
											$scope.decimalpointiscoma($scope.cItem_Desconto));

    //console.log('rResultado', rResultado);

		$scope.oItemSelecionado.ITEM_VALOR_TOTAL = $scope.decimalpointiscoma(rResultado);

  }


});
