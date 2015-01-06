// create application && configure
var phl = angular.module('phl',['ngRoute'])

    .config(function($routeProvider, $locationProvider) {

        "use strict";

        // configure router

        $routeProvider
            .when("/", {
                controller : "IndexController",
                templateUrl: "views/index.html"
            })
            .when("/user/:name", {
                controller : "UserController",
                templateUrl: "views/user.html"
            })
            .otherwise({
                redirectTo: "/"
            });

        $locationProvider
            .html5Mode(false);
});