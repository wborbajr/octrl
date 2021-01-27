/**
 * Inicializamos o angular.module com o mesmo nome que definimos na diretiva ng-app
 * E inclu�mos a depend�ncia do ngRoute
 */
var app = angular.module('myApp', [
    'ngRoute'
]);

/**
 * Como possu�mos a variavel app definida acima com a inicializa��o do Angular
 * atrav�s do app.config conseguimos criar as configura��es
 * definimos que essa configura��o depende do $routeProvider e usamos na function($routeProvider)
 */
app.config(['$routeProvider', function ($routeProvider) {
    $routeProvider

        // aqui dizemos quando estivernos na url / vamos carregar o conte�do da pagina inicila a home
        // no segundo parametro definimos um objeto contendo o templateUrl da nossa pagina home e o controller que ir�
        // preparar o conteudo e processar outros eventos da p�gina que veremos posteriormente
        .when("/", {templateUrl: "templates/dash.html", controller: "dashCtrl"})
        // configura��o das rotas bem parecidas para as outras paginas
        .when("/atendimento/entrada", {templateUrl: "templates/atendimento.entrada.html", controller: "SobreCtrl"})
        .when("/atendimento/retirada", {templateUrl: "templates/atendimento.retirada.html", controller: "SobreCtrl"})
        .when("/suporte", {templateUrl: "templates/suporte.html", controller: "SobreCtrl"})
        .when("/gelite", {templateUrl: "gelite/gelite.php", controller: "SobreCtrl"})
        .when("/servicos", {templateUrl: "templates/servicos.html", controller: "ServicosCtrl"})
        .when("/precos", {templateUrl: "templates/precos.html", controller: "PrecosCtrl"})
        /* aqui voc� pode adicionar rotas para outras paginas que desejar criar */
        // por �ltimo dizemos se nenhuma url digitada for encontrada mostramos a p�gina 404 que n�o existe no nosso servidor
        .when('/404', {templateUrl: "templates/404.html"})
        .otherwise("/");
}]);

/*
 * Controllers
 */
app.controller('dashCtrl', function ($scope, $location) {
  console.log('dashCtrl');

  $scope.getClass = function (path) {
    console.log(path);
          if ($location.path().substr(0, path.length) === path) {
              return 'active';
          } else {
              return '';
          }
      };
});

app.controller('SobreCtrl', function ($scope, $location) {

});

app.controller('ServicosCtrl', function ($scope, $location) {

});

app.controller('PrecosCtrl', function ($scope, $location) {

});
