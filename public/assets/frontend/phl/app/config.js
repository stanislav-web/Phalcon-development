"use strict";

(function(angular){

    // create config constants

    phlModule.constant('ROUTES', (function () {

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

    phlModule.constant('TEMPLATE', (function () {

        return {
            ARTICLE:    'assets/frontend/phl/app/common/templates/index.html',
            ERROR:      'assets/frontend/phl/app/common/templates/error.html',
            PROFILE:    'assets/frontend/phl/app/user/templates/profile.html'
        }
    })());

    // configure application's routes

    phlModule.config(['$routeProvider', '$locationProvider', 'ROUTES', 'TEMPLATE', function($routeProvider, $locationProvider, ROUTES, TEMPLATE) {

        $locationProvider.hashPrefix('!');
        $locationProvider.html5Mode(true);

        $routeProvider.when(ROUTES.HOME, {
            templateUrl: TEMPLATE.ARTICLE,
            controller: "IndexCtrl"
        })
        .when(ROUTES.CONTACTS, {
                templateUrl: TEMPLATE.ARTICLE,
                controller: "IndexCtrl"
        })
        .when(ROUTES.HELP, {
                templateUrl: TEMPLATE.ARTICLE,
                controller: "IndexCtrl"
        })
        .when(ROUTES.AGREEMENT, {
                templateUrl: TEMPLATE.ARTICLE,
                controller: "IndexCtrl"
        })
        .when(ROUTES.ABOUT, {
                templateUrl: TEMPLATE.ARTICLE,
                controller: "IndexCtrl"
        })
        $routeProvider.when(ROUTES.LOGOUT, {
            controller: "IndexCtrl",
            redirectTo: ROUTES.LOGOUT
        })
        .when(ROUTES.NOT_FOUND, {
                templateUrl: TEMPLATE.ERROR,
                controller: 'IndexCtrl'
        })
        .when(ROUTES.PROFILE, {
                templateUrl: TEMPLATE.PROFILE,
                controller: "SignCtrl",
                security: false
        })
        .when(ROUTES.LOGOUT, {
            templateUrl: TEMPLATE.ARTICLE,
            controller: "SignCtrl"
        })
        .otherwise({ redirectTo: ROUTES.HOME });

    }]);

    // configure preload transliteration

    phlModule.config(['$translateProvider', '$translatePartialLoaderProvider', function ($translateProvider, $translatePartialLoader) {


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