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
        'providers',
        'ui.splash', function() {}
    ]);

    // setup global scope variables

    app.run(['$rootScope', 'ROUTES', '$translate', 'Authentication', 'Session', 'Restangular', 'BASE',
        function ($rootScope, ROUTES, $translate, Authentication, Session, Restangular, BASE) {

            // get engine -> categories
            Restangular.one("engines", BASE.ENGINE_ID).customGET("categories").then(function(response) {

                response.engines.categories.map(function(category) {
                    if(category.hasOwnProperty('childs')) {
                        // partition array by fixed chunk
                        category.childs = _.chunk(category.childs, BASE.LIST.PARTS);
                    }
                });
                $rootScope.categories   = response.engines.categories;
                $rootScope.engines      = response.engines;
                $rootScope.title        = response.engines.name;
            });

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
