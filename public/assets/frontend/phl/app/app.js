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

    phl.factory('customLoader', function ($http, $q) {
        return function (options) {
            var deferred = $q.defer();

            $http({
                method:'GET',
                url:'assets/frontend/phl/app/languages/' + options.key + '.json'
            }).success(function (data) {
                deferred.resolve(data);
            }).error(function () {
                deferred.reject(options.key);
            });

            return deferred.promise;
        }
    });

    // setup global scope variables

    phl.run(['$rootScope', 'ROUTES', function ($rootScope, ROUTES) {

        $rootScope.ROUTES = ROUTES;
    }]);

})(angular);