"use strict";
var phl;

(function(angular){

    // application module

    phl = angular.module('phl', ['ngRoute', 'ngAnimate', 'ngSanitize', 'ngLoadingSpinner', 'pascalprecht.translate', function($httpProvider) {

        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

        $httpProvider.defaults.transformRequest = [function (data) {
            if (data === undefined) {
                data = {};
            }
            var token = $('meta[name=token]');

            phl.value('token_id', token.attr('title'));
            phl.value('token_val', token.attr('content'));

            data[token.attr('title')] = token.attr('content');
            return angular.isObject(data) && String(data) !== '[object File]' ? $.param(data) : data;
        }];
    }]);

    // create meta services

    phl.service('Meta', function() {

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

    // init custom storage interface. Marcus Westin thanks a lot!

   /* phl.factory('customStorage', function () {

        if (store.enabled) {

            // use store.min.js to save to localStorage

            return {

                set: function (name, value) {
                    // store `value` under `name` somehow
                    store.set(name, value);

                },
                get: function (name) {
                    // request value of `name` somehow
                    store.get(name);
                }
            };
        }
        else {

            // use cookies

        }
    });*/

    // setup global scope variables

    phl.run(['$rootScope', 'ROUTES', '$translate', function ($rootScope, ROUTES, $translate) {

        // set global scope for routes & template
        $rootScope.ROUTES = ROUTES;

        // update languages global
        $rootScope.$on('$translatePartialLoaderStructureChanged', function () {
            $translate.refresh();
        });

    }]);

})(angular);