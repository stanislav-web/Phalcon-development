"use strict";

var app;
var spinnerModule;
var splashModule;

(function(angular){

    spinnerModule = angular.module('ngLoadingSpinner', ['angularSpinner']);
    splashModule = angular.module('ui.splash', ['ui.bootstrap']);

    // application module
    app = angular.module('app', ['ngRoute', 'ngAnimate', 'ngSanitize', 'ngLoadingSpinner', 'pascalprecht.translate', 'ngCookies', 'ui.splash', function($httpProvider) {

        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

        $httpProvider.defaults.transformRequest = [function (data) {
            if (data === undefined) {
                data = {};
            }
            var token = $('meta[name=token]');

            app.value('token_id', token.attr('title'));
            app.value('token_val', token.attr('content'));

            data[token.attr('title')] = token.attr('content');
            return angular.isObject(data) && String(data) !== '[object File]' ? $.param(data) : data;
        }];
    }]);

    // create meta services

    app.service('Meta', function() {

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

    app.run(['$rootScope', 'ROUTES', '$translate', '$cookies', 'Authentication', '$http',
        function ($rootScope, ROUTES, $translate, $cookies, Authentication, $http) {

        // set global scope for routes & template
        $rootScope.ROUTES = ROUTES;

        if($cookies) {

            // getting from cookies
            $rootScope.currentLanguage = $cookies.NG_TRANSLATE_LANG_KEY || 'ru';
        }
        else {
            // getting from storage
            $rootScope.currentLanguage = store.get('NG_TRANSLATE_LANG_KEY') || 'ru';
        }

        // update languages global
        $rootScope.$on('$translatePartialLoaderStructureChanged', function () {
            $translate.refresh();
        });

        // Every time the route in our app changes check auth status

        $rootScope.$on("$locationChangeSuccess", function(event, next, current) {

            if(!Authentication.isLoggedIn()) {
                $http.defaults.headers.common['X-Token'] = $cookies.token;
            }
        });

    }]);

})(angular);