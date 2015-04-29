"use strict";

(function(angular) {

    // set routes config constants
    app.constant('ROUTES', (function () {

        return {
            HOME:       '/',
            PAGES:      '/page/:page',
            NOT_FOUND:  '/error/notfound',
            SERVER_ERROR:  '/error/uncaughtexception',
            ACCOUNT:    '/account',
            VERIFY :    '/sign/verify',
            LOGIN :     '/sign/login',
            REGISTER :  '/sign/register',
            RESTORE :   '/sign/restore',
            LOGOUT :    '/sign/logout'
        };
    })());

    // set routes config template paths
    app.constant('TEMPLATE', (function () {

        return {
            MENU_TOP:           'assets/phl/app/common/templates/menu_top.html',
            MENU_CATEGORIES:    'assets/phl/app/common/templates/menu_categories.html',
            MENU_SIDEBAR  :    'assets/phl/app/common/templates/sidebar.html',
            PAGES:      'assets/phl/app/common/templates/index.html',
            ERROR:      'assets/phl/app/common/templates/error.html',
            SIGN:       'assets/phl/app/authenticate/templates/sign.html',
            ACCOUNT:    'assets/phl/app/user/templates/account.html'
        };
    })());

// configure application's routes

    app.config(['$routeProvider', '$locationProvider', 'ROUTES', 'TEMPLATE', function($routeProvider, $locationProvider, ROUTES, TEMPLATE) {

        $locationProvider.hashPrefix('!');
        $locationProvider.html5Mode(true);

        $routeProvider.when(ROUTES.HOME, {
            templateUrl: TEMPLATE.PAGES,
            controller: "IndexController"
        })
            .when(ROUTES.PAGES, {
                templateUrl: TEMPLATE.PAGES,
                controller: "IndexController"
            })
            .when(ROUTES.LOGOUT, {
                controller: "IndexController",
                redirectTo: ROUTES.LOGOUT
            })
            .when(ROUTES.ACCOUNT, {
                templateUrl: TEMPLATE.ACCOUNT,
                controller: "UserCtrl",
                caseInsensitiveMatch: true,
                resolve: {
                    // route under secure verifying
                    isAuthenticated : function(Authentication) {
                        Authentication.requestUser(ROUTES.VERIFY);
                    }
                }
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
                        Authentication.requestUser(ROUTES.VERIFY);
                    }
                }
            })
            .otherwise({
                templateUrl: TEMPLATE.ERROR,
                controller: 'IndexController'
            }
        );
    }]);

})(angular);