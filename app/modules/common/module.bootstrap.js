"use strict";

(function(angular) {

    // common module
    angular.module('app.common', [
        'ngAnimate',
        'ngSanitize',
        'angularSpinner',
        'pascalprecht.translate',
        'ngCookies',
        'restangular',
        'ui.bootstrap',
        'duScroll',
        'notifications',
        'isteven-multi-select',
        'angularMoment',
        'ui.bootstrap',
        'ngFileUpload'
    ])

        // configure base rest loader
        .config(['RestangularProvider', '$logProvider', function(RestangularProvider, $logProvider) {

            /**
             * The workhorse; converts an object to x-www-form-urlencoded serialization.
             * @param {Object} obj
             * @return {String}
             */
            var param = function(obj) {
                var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

                for(name in obj) {
                    value = obj[name];

                    if(value instanceof Array) {
                        for(i=0; i<value.length; ++i) {
                            subValue = value[i];
                            fullSubName = name + '[' + i + ']';
                            innerObj = {};
                            innerObj[fullSubName] = subValue;
                            query += param(innerObj) + '&';
                        }
                    }
                    else if(value instanceof Object) {
                        for(subName in value) {
                            subValue = value[subName];
                            fullSubName = name + '[' + subName + ']';
                            innerObj = {};
                            innerObj[fullSubName] = subValue;
                            query += param(innerObj) + '&';
                        }
                    }
                    else if(value !== undefined && value !== null)
                            query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
                }

                return query.length ? query.substr(0, query.length - 1) : query;
            };

            $logProvider.debugEnabled(CONFIG.LOGGER);

            RestangularProvider.setBaseUrl(CONFIG.URL);
            RestangularProvider.setDefaultHttpFields({
                cache: true,
                etag: 'Etag',
                timeout: CONFIG.REQUEST_TIMEOUT,
                transformRequest : function(data) {
                    return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
                }
            });
            RestangularProvider.setDefaultRequestParams('get', {locale: localStorage.getItem(CONFIG.LANGUAGES.PREFIX)});
            RestangularProvider.setDefaultHeaders(
                { "Accept": CONFIG.ACCEPT_ENCODING}
            );

            RestangularProvider.setErrorInterceptor(function(response, deferred, responseHandler) {
                if(CONFIG.CATCHED_ERRORS.indexOf(response.status) != -1) {

                    // set errors for transit to run watcher
                    var error = response.data.error;
                    notify.error(error.code + ' ' +error.message, error.data[Object.keys(error.data)[0]]);
                }
            });

            RestangularProvider.setResponseExtractor(function(response, operation, what, url) {
                var newResponse = {};
                if(operation === 'getList') {
                    newResponse = response.data;
                    if(response.debug) {
                        newResponse.meta = response.meta;
                    }
                    if(response.debug) {
                        newResponse.debug = response.debug;
                    }
                }
                else {
                    newResponse = response.data
                }
                return newResponse;
            });
        }])

        // configure preload transliteration
        .config(['$translateProvider', '$translatePartialLoaderProvider', function ($translateProvider, $translatePartialLoader) {

            // try to find out preferred language by yourself
            $translateProvider.fallbackLanguage(CONFIG.LANGUAGES.ACCEPT)
                .determinePreferredLanguage()
                .registerAvailableLanguageKeys(CONFIG.LANGUAGES.ACCEPT, CONFIG.LANGUAGES.ALIASES)
                .storagePrefix(CONFIG.LANGUAGES.PREFIX);

            // get all partitions of language {part} - controller
            $translateProvider.useLoader('$translatePartialLoader', {
                urlTemplate: CONFIG.LANGUAGES.TEMPLATE
            });
        }]);

})(angular);