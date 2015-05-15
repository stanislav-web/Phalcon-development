"use strict";

(function(angular) {

    angular.module('app.routes', ['ngRoute'])

    // Configure application's routes

    .config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {

        $locationProvider.hashPrefix('!');
        $locationProvider.html5Mode(true);

        $routeProvider
            .when(CONFIG.ROUTES.HOME, {
                templateUrl: CONFIG.TEMPLATES.PAGES,
                controller: "IndexController"
            })
            .when(CONFIG.ROUTES.AUTH, {
                templateUrl: CONFIG.TEMPLATES.SIGN,
                controller: "SignController"
            })
            .when(CONFIG.ROUTES.ACCOUNT, {
                templateUrl: CONFIG.TEMPLATES.ACCOUNT,
                controller: "UserController",
                caseInsensitiveMatch: true,
                resolve: {
                    // route under secure verifying
                    isLoggedIn : function(Authentication) {
                        Authentication.isLoggedIn();
                    }
                }
            })
            .when(CONFIG.ROUTES.PAGES, {
                templateUrl: CONFIG.TEMPLATES.PAGES,
                controller: "IndexController"
            })

            .when('/transactions/:name', {
                templateUrl: function(urlattr){
                    return '/app/transactions/templates/' + urlattr.name + '.html';
                },
                caseInsensitiveMatch: true,
                controller: "UserCtrl",
                resolve: {
                    // route under secure verifying
                    isAuthenticated : function(Authentication) {
                        Authentication.requestUser(CONFIG.ROUTES.VERIFY);
                    }
                }
            })
            .otherwise({
                templateUrl: CONFIG.TEMPLATES.ERROR,
                controller: 'IndexController'
            }
        );
    }]);

})(angular);