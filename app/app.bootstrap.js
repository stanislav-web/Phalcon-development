"use strict";

var notify = null;

(function(angular) {

    // application module
    angular.module('app', [
        'app.routes',
        'app.common',
        'app.authenticate',
        'app.user'
    ])

    // setup global scope variables
    .run(['$rootScope', 'Authentication', 'Restangular', 'amMoment', '$notification',
        function ($rootScope, Authentication, Restangular, amMoment, $notification) {

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
                //if(!Authentication.isLoggedIn()) {}
            });

            $rootScope.$on("$routeChangeStart", function(event, next, current) {

            // Auth checkout

                    var user = Authentication.isLoggedIn();
                    if(user === true) {
                        //@TODO Checkout ACL
//                        if(CONFIG.ACL[user.role].indexOf(next.originalPath) == -1) {
//                            console.log('403 Access Forbidden');
//                            $location.path(CONFIG.routes.error403);
//                            event.preventDefault();
//                        }
                    }
            });
        }
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
                newResponse.meta = response.meta;
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
            urlTemplate: CONFIG.LANGUAGES.TEMPLATE,
            loadFailureHandler : 'TranslateErrorHandler'
        });
    }]);

})(angular);
