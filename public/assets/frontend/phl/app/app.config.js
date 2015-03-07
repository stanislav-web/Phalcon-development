"use strict";

(function(angular){

    // create config constants

    app.constant('ROUTES', (function () {

        return {
            HOME:       '/',
            PAGES:      '/page/:page',
            NOT_FOUND:  '/error/notfound',
            ACCOUNT:    '/account',
            VERIFY :    '/sign/verify',
            LOGIN :     '/sign/login',
            REGISTER :  '/sign/register',
            RESTORE :   '/sign/restore',
            LOGOUT :    '/sign/logout'
        };
    })());

    app.constant('TEMPLATE', (function () {

        return {
            PAGES:    'assets/frontend/phl/app/common/templates/index.html',
            ERROR:      'assets/frontend/phl/app/common/templates/error.html',
            SIGN:       'assets/frontend/phl/app/authenticate/templates/sign.html',
            ACCOUNT:    'assets/frontend/phl/app/user/templates/account.html'
        };
    })());

    // configure application's routes

    app.config(['$routeProvider', '$locationProvider', 'ROUTES', 'TEMPLATE', function($routeProvider, $locationProvider, ROUTES, TEMPLATE) {

        $locationProvider.hashPrefix('!');
        $locationProvider.html5Mode(true);

        $routeProvider.when(ROUTES.HOME, {
            templateUrl: TEMPLATE.PAGES,
            controller: "IndexCtrl"
        })
        .when(ROUTES.PAGES, {
            templateUrl: TEMPLATE.PAGES,
            controller: "IndexCtrl"
        })
        .when(ROUTES.LOGOUT, {
            controller: "IndexCtrl",
            redirectTo: ROUTES.LOGOUT
        })
        .when(ROUTES.NOT_FOUND, {
            templateUrl: TEMPLATE.ERROR,
            controller: 'IndexCtrl'
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
                    return 'assets/frontend/phl/app/transactions/templates/' + urlattr.name + '.html';
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
        .otherwise({ redirectTo: ROUTES.HOME });
    }]);

    // configure preload transliteration

    app.config(['$translateProvider', '$translatePartialLoaderProvider', function ($translateProvider, $translatePartialLoader) {

        // try to find out preferred language by yourself

        $translateProvider.fallbackLanguage(['en', 'ru', 'de', 'uk'])
            .determinePreferredLanguage()
            .registerAvailableLanguageKeys(['en', 'de', 'ru', 'uk'], {
                'en_US': 'en',
                'en_GB': 'en',
                'de_DE': 'de',
                'ua_UK': 'uk',
                'ru-RU': 'ru'
            });

        // get all partitions of language {part} - controller

        $translateProvider.useLoader('$translatePartialLoader', {
            urlTemplate: 'assets/frontend/phl/app/languages/{lang}/{part}.json'
        });
    }]);

})(angular);