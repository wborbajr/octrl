
var app = angular.module('myApp', []);

app.controller('AppCtrl', function($scope, $http){

  console.log('AppCtrl');

  // $scope.servicoLista = [
  //   { id: 0, desc: "serviço 1"},
  //   { id: 1, desc: "serviço 1"},
  //   { id: 2, desc: "serviço 2"},
  //   { id: 3, desc: "serviço 3"},
  //   { id: 4, desc: "serviço 4"}
  // ];

  $scope.itemBuscar = function(e){
    console.log("bucar o quê? ",e);
    $http
        .get("venda/venda.inc.php?acao=itens_busca&obj=iphone")
        .then(function(e) {
            console.log('e', e.data);
            $scope.servicoLista = e.data.data;
        });
  }

  $scope.count = 0;
      $scope.myFunc = function() {
          $scope.count++;
      };
      
  console.log($scope.servicoLista);


});
