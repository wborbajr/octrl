'use strict';

var app = angular.module('demo', []);


/*
angular.module('demo', ['ngRouter'])

    .config(function ($routeProvider) {
        $routeProvider
            .when("/home", {
                    templateUrl: "home.html",
                    controller: "homeCtrl"
                })
            .when("/cursos", {
                    templateUrl: "cursos.html",
                    controller: "homeCtrl"
                })
            .when("/alunos", {
                    templateUrl: "alunos.html",
                    controller: "homeCtrl"
                })
    })

    .controller("homeCtrl", function($scope){
        $scope.titulo = "Dashboard";
    })
    .controller("cursosCtrl", function($scope){
        $scope.titulo = "cursos";
    })
    .controller("alunosCtrl", function($scope){
        $scope.titulo = "alunos";
    })


;
*/