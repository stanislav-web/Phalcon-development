"use strict";

var app;

(function(angular) {

    // init custom modules
    angular.module('ui.splash', ['ui.bootstrap']);

    // application module
    app = angular.module('app', [
        //'oc.lazyLoad',
        'angular-debug-bar',
        'ngRoute',
        'ngAnimate',
        'ngSanitize',
        'angularSpinner',
        'pascalprecht.translate',
        'ngCookies',
        'restangular',
        'ui.splash', function() {}
    ]);

    // setup global scope variables

    app.run(['$rootScope', 'ROUTES', '$translate', 'Authentication', 'Session', 'Restangular', 'BASE',
        function ($rootScope, ROUTES, $translate, Authentication, Session, Restangular, BASE) {

            $rootScope.engine = Restangular.all("engines/" +BASE.ENGINE_ID+"/categories").customGET("").$object;

            // set global scope for routes & template
            $rootScope.ROUTES = ROUTES;

            // getting store locale
            $rootScope.currentLanguage = Session.get(BASE.LANGUAGES.PREFIX) || BASE.LANGUAGES.DEFAULT;

            // update languages global
            $rootScope.$on('$translatePartialLoaderStructureChanged', function () {
                $translate.refresh();
            });

            // Every time the route in our app changes check auth status

            $rootScope.$on("$locationChangeSuccess", function(event, next, current) {

                if(!Authentication.isLoggedIn()) {}
            });
        }
    ]);

})(angular);
