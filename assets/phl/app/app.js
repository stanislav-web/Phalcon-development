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
        'ui.bootstrap',
        'duScroll',
        'isteven-multi-select',
        'ui.splash', function() {}
    ]);

    // setup global scope variables

    app.run(['$rootScope', 'ROUTES', '$translate', 'Authentication', 'Session', 'Restangular', 'Engines', 'BASE',
        function ($rootScope, ROUTES, $translate, Authentication, Session, Restangular, Engines, BASE) {

            // get engine -> categories

            $rootScope.root = Engines.getOne(BASE.ENGINE_ID);

            Restangular.all("currencies").getList().then(function(response) {

                $rootScope.currencies = [];

                response.forEach(function(value) {
                    $rootScope.currencies.push({
                        icon : '<img class="lang-sm lang-lbl" lang="' +value.code.toLowerCase()+ '">',
                        name : value.name,
                        maker : value.symbol,
                        ticked : (value.code === BASE.DEFAULT_CURRENCY) ? true : false
                    });
                });
            });

            // set global scope for routes & template
            $rootScope.ROUTES = ROUTES;

            // getting store locale
            $rootScope.currentLanguage = Session.get(BASE.LANGUAGES.PREFIX) || BASE.LANGUAGES.DEFAULT;
            moment.locale($rootScope.currentLanguage);

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
