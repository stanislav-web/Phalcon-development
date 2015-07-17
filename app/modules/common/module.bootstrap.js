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
        .config(['RestangularProvider', '$logProvider', 'SerializeProvider',
                 function(RestangularProvider, $logProvider, SerializeProvider) {

            //set defaults
            $logProvider.debugEnabled(CONFIG.LOGGER);
            RestangularProvider.setBaseUrl(CONFIG.URL);
            RestangularProvider.setDefaultHttpFields({
                cache: true,
                etag: 'Etag',
                timeout: CONFIG.REQUEST_TIMEOUT,
                transformRequest : function(data) {
                    return angular.isObject(data) && String(data) !== '[object File]' ? SerializeProvider.urlencode(data) : data;
                }
            });
            RestangularProvider.setDefaultRequestParams('get', {locale: localStorage.getItem(CONFIG.LANGUAGES.PREFIX)});
            RestangularProvider.setDefaultHeaders(
                { "Accept": CONFIG.ACCEPT_ENCODING}
            );

            // set errors interceptors
            RestangularProvider.setErrorInterceptor(function(response, deferred, responseHandler) {
                if(CONFIG.CATCHED_ERRORS.indexOf(response.status) != -1) {

                    // set errors for transit to run watcher
                    var error = response.data.error;
                    notify.error(error.code + ' ' +error.message, error.data[Object.keys(error.data)[0]]);
                }
            });

            // separate response by array keys
            RestangularProvider.setResponseExtractor(function(response, operation, what, url) {
                return SerializeProvider.separateResponse(response, operation);
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