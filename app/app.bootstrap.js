"use strict";

var notify = null;

(function(angular) {

    // application module
    angular.module('app', [
        'ngRoute',
        'app.document',
        'app.directives',
        'app.session',
        'app.common',
        'app.authenticate',
        'app.user'
    ])

    // configure application's routes
    .config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {

        $locationProvider.hashPrefix('!');
        $locationProvider.html5Mode(true);

        for(var path in CONFIG.ROUTER) {
            $routeProvider.when(path, CONFIG.ROUTER[path]);
        }
        $routeProvider.otherwise({redirectTo: CONFIG.LOCATIONS.NOT_FOUND});
    }])

    // setup global scope variables
    .run(['$rootScope', 'Restangular', 'amMoment', '$notification',
        function ($rootScope, Restangular, amMoment, $notification) {

            // get engine -> categories
            Restangular.one("engines", CONFIG.ENGINE_ID).customGET("categories").then(function(response) {

                response.categories.map(function(category) {
                    if(category.hasOwnProperty('childs')) {
                        // partition array by fixed chunk
                        category.childs = _.chunk(category.childs, CONFIG.LIST.PARTS);
                    }
                });
                $rootScope.categories   = response.categories;
                $rootScope.engines      = response.engines;
                $rootScope.bannersOn    = CONFIG.BANNERS;
                $rootScope.banners      = response.banners;
            });

            // get & configure shop currencies
            Restangular.all("currencies").getList().then(function(response) {

                $rootScope.currencies = [];

                response.forEach(function(value) {
                    $rootScope.currencies.push({
                        icon : '<img class="lang-sm lang-lbl" lang="' +value.code.toLowerCase()+ '">',
                        name : value.name,
                        maker : value.symbol,
                        ticked : (value.code === CONFIG.DEFAULT_CURRENCY) ? true : false
                    });
                });
            });

            // getting store locale
            $rootScope.currentLanguage = localStorage.getItem(CONFIG.LANGUAGES.PREFIX) || CONFIG.LANGUAGES.DEFAULT;

            amMoment.changeLocale($rootScope.currentLanguage);

            // overwite global notify storage
            notify = $notification;

            // Every time the route in our app changes check auth status
            $rootScope.$on("$locationChangeSuccess", function(event, next, current) {
                $rootScope.bannersOn = true;
            });
        }
    ])



})(angular);
