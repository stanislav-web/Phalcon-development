var notify = null;

(function(angular) {

    "use strict";

    // application module
    angular.module('app', [
        'ngRoute',
        'app.logger',
        'app.document',
        'app.directives',
        'app.session',
        'app.socket',
        'app.authenticate',
        'app.common',
        'app.user',
        'app.catalogue'
    ])

    // configure application's routes
    .config(['$routeProvider', '$locationProvider',function($routeProvider, $locationProvider) {

        $locationProvider.hashPrefix('!');
        $locationProvider.html5Mode(true);

        for(var path in CONFIG.ROUTER) {
            $routeProvider.when(path, CONFIG.ROUTER[path]);
        }
        $routeProvider.otherwise({redirectTo: CONFIG.LOCATIONS.NOT_FOUND});
    }])

    // setup global scope variables
    .run(['$rootScope', 'amMoment', '$notification', '$location', 'LanguageService', 'CategoriesService', 'CurrenciesService', 'Document', 'Socket',
        function ($rootScope, amMoment, $notification, $location, LanguageService, CategoriesService, CurrenciesService, Document, Socket) {

            //  load engine's categories
            CategoriesService.load(function(response) {
                $rootScope.categories   = response.categories;
                $rootScope.engines      = response.engines;
                $rootScope.bannersOn    = CONFIG.BANNERS;
                $rootScope.banners      = response.banners;
                Document.setDescription(response.engines.description);
            });

            // load & configure shop currencies
            CurrenciesService.load(function(response) {
                $rootScope.currencies = response;
            });

            // getting store locale
            LanguageService.get();
            $rootScope.currentLanguage = LanguageService.get();

            // set date localization
            amMoment.changeLocale($rootScope.currentLanguage);

            // overwite global notify storage
            notify = $notification;

            $rootScope.location = $location;

            $rootScope.$on("$locationChangeStart",function(event, next, current) {

                (CONFIG.DEBBUG === true) ? debug('Current page:', next) : null;

                // detect user step & write by socket
                Socket.create($rootScope.location.path());

                if(current != next) {
                    Socket.message();
                }
            });
        }
    ])

})(angular);
