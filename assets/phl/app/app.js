"use strict";

var app;

(function(angular) {

    // init custom modules
    angular.module('ui.splash', ['ui.bootstrap']);

    // application module
    app = angular.module('app', [
        //'oc.lazyLoad',
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

    app.run(['$rootScope', 'ROUTES', '$translate', '$cookies', 'Authentication', 'Session', '$http',
        function ($rootScope, ROUTES, $translate, $cookies, Authentication, Session, $http) {

            // set global scope for routes & template
            $rootScope.ROUTES = ROUTES;

            if($cookies) {

                // getting from cookies
                $rootScope.currentLanguage = $cookies.NG_TRANSLATE_LANG_KEY || 'ru';
            }
            else {
                // getting from storage
                $rootScope.currentLanguage = Session.get('NG_TRANSLATE_LANG_KEY') || 'ru';
            }

            // update languages global
            $rootScope.$on('$translatePartialLoaderStructureChanged', function () {
                $translate.refresh();
            });

            // Every time the route in our app changes check auth status

            $rootScope.$on("$locationChangeSuccess", function(event, next, current) {

                if(!Authentication.isLoggedIn()) {
                    $http.defaults.headers.common['X-Token'] = Session.get('token');
                }
            });
        }
    ]);

})(angular);
