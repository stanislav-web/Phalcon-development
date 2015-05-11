"use strict";

(function(angular) {

    // Configure application's routes

    app.config(['$routeProvider', '$locationProvider', 'BASE', function($routeProvider, $locationProvider, BASE) {

        $locationProvider.hashPrefix('!');
        $locationProvider.html5Mode(true);

        $routeProvider
            .when(BASE.ROUTES.HOME, {
                templateUrl: BASE.TEMPLATES.PAGES,
                controller: "IndexController"
            })
            .when(BASE.ROUTES.AUTH, {
                templateUrl: BASE.TEMPLATES.SIGN,
                controller: "SignController"
            })
            .when(BASE.ROUTES.ACCOUNT, {
                templateUrl: BASE.TEMPLATES.ACCOUNT,
                controller: "UserController",
                caseInsensitiveMatch: true,
                resolve: {
                    // route under secure verifying
                    isLoggedIn : function(Authentication) {
                        Authentication.isLoggedIn();
                    }
                }
            })
            .when(BASE.ROUTES.PAGES, {
                templateUrl: BASE.TEMPLATES.PAGES,
                controller: "IndexController"
            })
            .when(BASE.ROUTES.LOGOUT, {
                controller: "IndexController",
                redirectTo: BASE.ROUTES.LOGOUT
            })

            .when('/transactions/:name', {
                templateUrl: function(urlattr){
                    return 'assets/phl/app/transactions/templates/' + urlattr.name + '.html';
                },
                caseInsensitiveMatch: true,
                controller: "UserCtrl",
                resolve: {
                    // route under secure verifying
                    isAuthenticated : function(Authentication) {
                        Authentication.requestUser(BASE.ROUTES.VERIFY);
                    }
                }
            })
            .otherwise({
                templateUrl: BASE.TEMPLATES.ERROR,
                controller: 'IndexController'
            }
        );
    }]);

})(angular);