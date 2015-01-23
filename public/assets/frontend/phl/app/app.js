"use strict";

var phlModule;
var spinnerModule;
var splashModule;

(function(angular){

    spinnerModule = angular.module('ngLoadingSpinner', ['angularSpinner']);
    splashModule = angular.module('ui.splash', ['ui.bootstrap']);

    // application module
    phlModule = angular.module('phl', ['ngRoute', 'ngAnimate', 'ngSanitize', 'ngLoadingSpinner', 'pascalprecht.translate', 'ngCookies', 'ui.splash', function($httpProvider) {

        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

        $httpProvider.defaults.transformRequest = [function (data) {
            if (data === undefined) {
                data = {};
            }
            var token = $('meta[name=token]');

            phlModule.value('token_id', token.attr('title'));
            phlModule.value('token_val', token.attr('content'));

            data[token.attr('title')] = token.attr('content');
            return angular.isObject(data) && String(data) !== '[object File]' ? $.param(data) : data;
        }];
    }]);

    // create meta services

    phlModule.service('Meta', function() {

        var metaDescription = '';
        var metaKeywords = '';

        return {

            metaDescription: function() {
                return metaDescription;
            },

            metaKeywords: function() {
                return metaKeywords;
            },

            reset: function() {
                metaDescription = '';
                metaKeywords = '';
            },

            setMetaDescription: function(newMetaDescription) {
                metaDescription = newMetaDescription;
            },

            appendMetaKeywords: function(newKeywords) {
                for (var key in newKeywords) {
                    if (metaKeywords === '') {
                        metaKeywords += newKeywords[key].name;
                    } else {
                        metaKeywords += ', ' + newKeywords[key].name;
                    }
                }
            }

        };
    });

    // setup global scope variables

    phlModule.run(['$rootScope', 'ROUTES', '$translate', '$cookies', 'access', 'authService', '$location',
        function ($rootScope, ROUTES, $translate, $cookies, access, authService, $location) {

        // set access token (if exist)
        access.init();

        // set global scope for routes & template
        $rootScope.ROUTES = ROUTES;

        if(store.enabled) {

            // getting from storage
            $rootScope.currentLanguage = store.get('NG_TRANSLATE_LANG_KEY') || 'ru';
        }
        else {

            // getting from cookies
            $rootScope.currentLanguage = $cookies.NG_TRANSLATE_LANG_KEY || 'ru';
        }

        // update languages global
        $rootScope.$on('$translatePartialLoaderStructureChanged', function () {
            $translate.refresh();
        });

        // Everytime the route in our app changes check auth status

        $rootScope.$on("$routeChangeStart", function(event, next, current) {

            // if you're logged out send to login page.
           if (!authService.isLoggedIn() && next.security) {

                $location.path('/');
                event.preventDefault();
            }
            else {
               $rootScope.user     =   authService.getUser();
               console.log('Authorized');
           }
        });

    }]);

})(angular);