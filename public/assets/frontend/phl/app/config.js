"use strict";

(function(angular){

    // create config constants

    phl.constant('ROUTES', (function () {

        return {
            HOME:       '/',
            CONTACTS:   '/contacts',
            HELP:       '/help',
            AGREEMENT:  '/agreement',
            ABOUT:      '/about',
            NOT_FOUND:  '/error/notfound'
        }
    })());

    phl.constant('TEMPLATE', (function () {

        return {
            ARTICLE:        'assets/frontend/phl/app/templates/index.html',
            ERROR:          'assets/frontend/phl/app/templates/error.html'
        }
    })());

    // configure application's routes

    phl.config(['$routeProvider', '$locationProvider', 'ROUTES', 'TEMPLATE', function($routeProvider, $locationProvider, ROUTES, TEMPLATE) {

        $locationProvider.hashPrefix('!');
        $locationProvider.html5Mode(true);

        $routeProvider.when(ROUTES.HOME, {
            templateUrl: TEMPLATE.ARTICLE,
            controller: "IndexController"
        })
        .when(ROUTES.CONTACTS, {
                templateUrl: TEMPLATE.ARTICLE,
                controller: "IndexController"
            })
        .when(ROUTES.HELP, {
                templateUrl: TEMPLATE.ARTICLE,
                controller: "IndexController"
        })
        .when(ROUTES.AGREEMENT, {
                templateUrl: TEMPLATE.ARTICLE,
                controller: "IndexController"
        })
        .when(ROUTES.ABOUT, {
                templateUrl: TEMPLATE.ARTICLE,
                controller: "IndexController"
        })
        .when(ROUTES.NOT_FOUND, {
                templateUrl: TEMPLATE.ERROR,
                controller: 'IndexController'
        })
        .otherwise({ redirectTo: ROUTES.HOME });

    }]);

    // configure localization service

    phl.config(['$translateProvider', function ($translateProvider) {

        $translateProvider.useLoader('customLoader', {});

        // which language to use?
        $translateProvider.preferredLanguage('en');

    }]);

})(angular);