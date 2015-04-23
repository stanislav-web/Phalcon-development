"use strict";

(function(angular) {

    // set base config constants
    app.constant('BASE', (function () {

        return {
            URL:       'http://api.phalcon.local/api/v1',
            ENGINE_ID: 1,
            LOCAL: {
                CUSTOMER_AUTH_MENU :    '/assets/phl/app/data/menu/customer-auth.json',
                CUSTOMER_MENU :         '/assets/phl/app/data/menu/customer.json'
            },
            LANGUAGES: {
                ACCEPT: ['en', 'ru', 'de', 'uk'],
                ALIASES : {
                    'en_US': 'en',
                    'en_GB': 'en',
                    'de_DE': 'de',
                    'ua_UK': 'uk',
                    'ru-RU': 'ru'
                },
                DEFAULT : 'en',
                PREFIX  : 'locale',
                TEMPLATE: 'assets/phl/app/languages/{lang}/{part}.json'
            },
            CATCHED_ERRORS : [400, 401, 403, 404, 405, 406, 409, 414, 415, 422, 429, 500]
        };
    })());

    // configure base rest loader
    app.config(['RestangularProvider', '$httpProvider', 'BASE', function(RestangularProvider, $httpProvider, BASE) {

        RestangularProvider.setBaseUrl(BASE.URL);
        RestangularProvider.setDefaultHttpFields({cache: true});
        RestangularProvider.setDefaultHeaders(
            { "Accept": 'application/json; charset=utf-8'},
            { "Content-Type": "application/json; charset=utf-8" }
        );

        RestangularProvider.setErrorInterceptor(function(response, deferred, responseHandler) {
            if(BASE.CATCHED_ERRORS.indexOf(response.status) != -1) {
                console.log('Error', response);
                return false; // error handled
            }
            return true; // error not handled
        });

        RestangularProvider.setResponseExtractor(function(response, operation, what, url) {
            var extractedData;
            if (operation === "getList") {
                extractedData = response.data.data;
            } else {
                extractedData = response.data;
            }
            return extractedData;
        });

        RestangularProvider.setRequestInterceptor(function(request, operation, route) {

            if (operation === 'put') {
                if (request.links)
                    delete request.links;
            }
            return request;
        });

        // Using self link for self reference resources
        RestangularProvider.setRestangularFields({
            selfLink: 'self.link'
        });
    }]);

    // configure preload transliteration
    app.config(['$translateProvider', '$translatePartialLoaderProvider', 'BASE', function ($translateProvider, $translatePartialLoader, BASE) {

        // try to find out preferred language by yourself
        $translateProvider.fallbackLanguage(BASE.LANGUAGES.ACCEPT)
            .determinePreferredLanguage()
            .registerAvailableLanguageKeys(BASE.LANGUAGES.ACCEPT, BASE.LANGUAGES.ALIASES)
            .storagePrefix(BASE.LANGUAGES.PREFIX);

        // get all partitions of language {part} - controller
        $translateProvider.useLoader('$translatePartialLoader', {
            urlTemplate: BASE.LANGUAGES.TEMPLATE
        });
    }]);

})(angular);



