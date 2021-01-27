
var app = angular.module('myApp', []);

app.controller('AppCtrl', function($scope, $location, $http){

  console.log('angularjs');

  // Carrega o obj publico contendo a relação de atendentes
  $scope.atendenteCarga = function(){
    $scope.dbAtendente = {};

    $http({
      method : 'POST',
      url : 'entrada/angular.inc.php',
      data : {"acao": 'atendenteCarga', "obj": []}
      // headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
    })
    //função de callback quando a promise for sucesso
		.success(function(data) {
      // console.log('data', data);

			//verifica o retorno do servidor se o email foi enviado
      if (data.code) {
        $scope.dbAtendente = data.data;
        console.log($scope.dbAtendente);
      }
		})
		//função de callback quando a promise for erro (geralmente problema de conexão ou página não existente)
		.error(function(error){
      console.log('error', error);
			$scope.emailNaoEnviado = true;
		});

  }


  //criando o objeto em branco, porém após o submit todos os dados estaram nessa variável
	$scope.formData = {};
	//variavel para ebir ou não a mensagem que o email foi enviado
	$scope.emailEnviado = false;
	//variável para exibir mensagem de erro ao enviar o email
	$scope.emailNaoEnviado = false;

  $scope.docBusca = function(sDoc){
    console.log('docBusca',sDoc);
  }

  //função que será usada para preparar os dados no formato que poderemos usar no servidor para envio do email
	var param = function(data) {
        var returnString = '';
        for (d in data){
            if (data.hasOwnProperty(d))
               returnString += d + '=' + data[d] + '&';
        }
        // Remove o último & que não é necessário
        return returnString.slice( 0, returnString.length - 1 );
	};

	$scope.enviarEmail = function() {
		$http({
			method : 'POST',
			url : 'email.php',
			data : param($scope.formData),
			headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
		})
		//função de callback quando a promise for sucesso
		.success(function(data) {
			//verifica o retorno do servidor se o email foi enviado
			if (data.enviado) {
			   $scope.emailEnviado = true; //ocultamos o formulário e exibimos mensagem de sucesso
			} else {
			  	$scope.emailNaoEnviado = true;
			}
		})
		//função de callback quando a promise for erro (geralmente problema de conexão ou página não existente)
		.error(function(error){
			$scope.emailNaoEnviado = true;
		});
	};

  $scope.clie_busca = function(e){
    console.log('buscar: ', e);
  }

  function main(){
    $scope.atendenteCarga();
  }

  main();

});
