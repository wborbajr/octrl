
var app = angular.module('rwApp', []);


app.controller('rwCtrl', function($scope, $http) {


    // Variáveis públicas
    $scope.varToolBar = 1;
    $scope.sAux = null;
    $scope.glt_dash_resumo5_selecao = 'data';

    // Alimenta os combos
    $scope.combosLoad = function(){
        $http({
                method: 'GET',
                url: './gelite/gelite.inc.php',
                params: {acao: 'glt_dash_combos'}
    
              }).then(function successCallback(e) {
    
                // console.log('sucesso: ', e);
                $scope.glt_dash_combos = e.data.data;
    
              }, function errorCallback(e) {
                console.log('erro glt_dash_combos: ', e);
        });
    }


    // Alimenta o table glt_dash_resumo1
    $scope.resumo1 = function(){
        $http({
                method: 'GET',
                url: './gelite/gelite.inc.php',
                params: {acao: 'glt_dash_resumo1'}
    
              }).then(function successCallback(e) {
    
                // console.log('sucesso glt_dash_resumo1: ', e);

                // $scope.glt_dash_resumo1 = JSON.stringify(e.data);
                $scope.glt_dash_resumo1 = e.data;

    
              }, function errorCallback(e) {
                console.log('erro glt_dash_resumo1: ', e);
        });
    }


    // Alimenta o table glt_dash_resumo1
    $scope.resumo2 = function(){
        $http({
                method: 'GET',
                url: './gelite/gelite.inc.php',
                params: {acao: 'glt_dash_resumo2'}
    
              }).then(function successCallback(e) {
                // console.log('sucesso glt_dash_resumo2: ', e);

                $scope.glt_dash_resumo2 = e.data;
    
              }, function errorCallback(e) {
                console.log('erro glt_dash_resumo2: ', e);
    
        });
    }


    // Alimenta o table ligações feitas e recebidas
    $scope.resumo3 = function(){
        $http({
                method: 'GET',
                url: './gelite/gelite.inc.php',
                params: {acao: 'glt_dash_resumo3'}
    
              }).then(function successCallback(e) {
                    
                    // console.log('sucesso glt_dash_resumo3: ', e);

                    var aRecebidas = [];
                    var aFeitas = [];
                    var items = e.data.data;
                    for (var i = 0; i < items.length; i++) {
                      var item = items[i];
                      if (item.glt05_tipo == '1') {
                        aRecebidas.push(item);
                      } else {
                        aFeitas.push(item);
                      }
                }
    
                $scope.glt_dash_resumo3a = { code: aRecebidas.length,
                  data: aRecebidas };
    
                $scope.glt_dash_resumo3b = { code: aFeitas.length,
                  data: aFeitas };
    
    
              }, function errorCallback(e) {
                console.log('erro glt_dash_resumo3: ', e);
        });
    }


    // Alimenta o table glt_dash_resumo4
    $scope.resumo4 = function(){
        $http({
                method: 'GET',
                url: './gelite/gelite.inc.php',
                params: {acao: 'glt_dash_resumo4'}
    
              }).then(function successCallback(e) {
                $scope.glt_dash_resumo4 = e.data;
                // console.log($scope.glt_dash_resumo4);
    
              }, function errorCallback(e) {
                console.log('erro glt_dash_resumo4: ', e);
    
        });
    }

    $scope.glt_dash_resumo4_separador = function(sSeparador){

      // console.log(sSeparador, $scope.sAux);

        if ($scope.sAux == null){
          $scope.sAux = sSeparador;
          return false;
        } else
        if ($scope.sAux != sSeparador) {
          $scope.sAux = sSeparador;
          return true;
        }

        return false;
    }




    // Alimenta o table glt_dash_resumo6
    $scope.resumo6 = function(){
        $http({
                method: 'GET',
                url: './gelite/gelite.inc.php',
                params: {acao: 'glt_dash_resumo6'}
    
              }).then(function successCallback(e) {
    
                console.log('sucesso glt_dash_resumo6: ', e.data);

                // $scope.glt_dash_resumo1 = JSON.stringify(e.data);
                $scope.glt_dash_resumo6 = e.data;

    
              }, function errorCallback(e) {
                console.log('erro glt_dash_resumo6: ', e);
        });
    }



    $scope.combosLoad();
    $scope.resumo1();
    $scope.resumo2();
    $scope.resumo3();
    $scope.resumo4();
    $scope.resumo6();


    //************

    $scope.loadFile = function(oLocalidade){
      console.log('Localidade:', oLocalidade);
      $scope.msgTitulo = "Importando registros";
      $scope.msgTexto  = oLocalidade.desc + " - AGUARDE...";
      $scope.iGaugeAux = 17;
      
      $http({
            method: 'GET',
            url: './gelite/gelite.inc.php',
            params: { acao: 'cargaRegistros',
                      opc0: oLocalidade.sigla}
          }).then(function successCallback(e) {
            var oObj = e.data;

            // console.log('sucesso cargaRegistros:', oObj);

            $scope.msgTitulo = "Importação concluída.";

            if (oObj.code >= 0){

              $scope.combosLoad();
              $scope.resumo1();
              $scope.resumo2();
              $scope.resumo3();
              $scope.resumo4();
              $scope.msgTexto = oLocalidade.desc + " - "+oObj.data.Update+" registros adicionados de "+oObj.data.Analisado+" analisados.";

            }else
              $scope.msgTexto = oLocalidade.desc + " - "+oObj.msg;

            $scope.iGaugeAux = 100;
            // $scope.bottom-msg.data-target="#bottom-menu";

          }, function errorCallback(e) {
            console.log('erro cargaRegistros: ', e);
            $scope.iGaugeAux = 100;

      });

    }


    $scope.loadRamalDetalhes = function(oRow){
        console.log(oRow);
          // Alimenta o table glt_dash_resumo5
          $http({
                  method: 'GET',
                  url: './gelite/gelite.inc.php',
                  params: { acao: 'glt_dash_resumo5',
                            opc0: oRow.sigla,
                            opc1: oRow.periodo,
                            opc2: oRow.glt10_ramal,
                            opc3: oRow.glt05_tipo}
                }).then(function successCallback(e) {
                  // console.log('sucesso glt_dash_resumo5:', e.data);
                  $scope.glt_dash_resumo5 = e.data;

                }, function errorCallback(e) {
                  console.log('erro glt_dash_resumo5: ', e);

          });
    };

    $scope.dash_resumo5_ordem = function(sCampo){
      $scope.glt_dash_resumo5_selecao = sCampo;

      if ($scope.dashResumo_Ordem_Inversa)
        $scope.glt_dash_resumo5_ordem = '-' + sCampo
      else
        $scope.glt_dash_resumo5_ordem = sCampo;
    }



    // Alimenta o table glt_dash_resumo6
    $scope.glt_dash_resumo6_pesq = function(sPesq){
        console.log(sPesq);
        var sSigla = '';
          $http({
                  method: 'GET',
                  url: './gelite/gelite.inc.php',
                  params: { acao: 'glt_dash_resumo6',
                            opc0: sSigla,
                            opc1: sPesq }
                }).then(function successCallback(e) {
                  // console.log(e.data);
                  $scope.glt_dash_resumo6 = e.data;

                }, function errorCallback(e) {
                  console.log('erro glt_dash_resumo6: ', e);

          });
    };


//**************************************************************

    function getDate(yourDate){
        var date = yourDate.toString();
        var divide = date.split('-');
        var newDate = divide[0]+divide[1]+divide[2];
        alert(newDate);
    }


    $scope.todoList = [
        {name: 'Learn Angular', completed: false},
        {name: 'Build a TodoList', completed: true}
    ];

    function Task(){
        this.name = '';
        this.completed = false;
    }

    function updateProgress() {
        $scope.progress = {
            total: $scope.todoList.length,
            getProgress: function() {
                var complete = 0;
                $scope.todoList.forEach(function(item){
                    if (item.completed) {
                        complete++;
                    }
                });
                return (complete * 100) / this.total + '%';
            }
        }
    }

    $scope.task = new Task();

    $scope.addItem = function () {
        $scope.todoList.push($scope.task);
        $scope.task = new Task();
        updateProgress();
    }

    $scope.deleteTasks = function() {
        var newList = [];
        $scope.todoList.forEach(function(item) {
            if (!item.completed) {
                newList.push(item);
            }
        });

        $scope.todoList = newList;
        updateProgress();
    }

    updateProgress();
});
