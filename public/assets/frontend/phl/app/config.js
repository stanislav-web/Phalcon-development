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
            NOT_FOUND:  '/error/notfound',
            PROFILE:    '/profile',
            LOGOUT:     '/logout'
        }
    })());

    phl.constant('TEMPLATE', (function () {

        return {
            ARTICLE:    'assets/frontend/phl/app/templates/index.html',
            ERROR:      'assets/frontend/phl/app/templates/error.html',
            PROFILE:    'assets/frontend/phl/app/templates/profile.html'
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
        $routeProvider.when(ROUTES.LOGOUT, {
            controller: "IndexController",
            redirectTo: ROUTES.LOGOUT
        })
        .when(ROUTES.NOT_FOUND, {
                templateUrl: TEMPLATE.ERROR,
                controller: 'IndexController'
        })
        .when(ROUTES.PROFILE, {
                templateUrl: TEMPLATE.PROFILE,
                controller: "SignController",
                security: false
        })
        .when(ROUTES.LOGOUT, {
            templateUrl: TEMPLATE.ARTICLE,
            controller: "SignController"
        })
        .otherwise({ redirectTo: ROUTES.HOME });

    }]);

    // configure preload transliteration

    phl.config(['$translateProvider', '$translatePartialLoaderProvider', function ($translateProvider, $translatePartialLoader) {


        // try to find out preferred language by yourself

        $translateProvider.fallbackLanguage(['en', 'ru', 'de', 'uk'])
            .determinePreferredLanguage()
            .registerAvailableLanguageKeys(['en', 'de', 'ru', 'uk'], {
                'en_US': 'en',
                'en_GB': 'en',
                'de_DE': 'de',
                'ua_UK': 'uk'
            });

        // get all partitions of language {part} - controller

        $translateProvider.useLoader('$translatePartialLoader', {
            urlTemplate: 'assets/frontend/phl/app/languages/{lang}/{part}.json'
        });
    }]);

})(angular);