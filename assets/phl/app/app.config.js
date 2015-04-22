"use strict";

(function(angular) {

    // set base constants
    app.constant('BASE', (function () {

        return {
            URL:       'http://api.phalcon.local/api/v1',
            CATCHED_ERRORS : []
        };
    })());

    // configure base rest loader
    app.config(['RestangularProvider', 'BASE', function(RestangularProvider, BASE) {
        RestangularProvider.setBaseUrl(BASE.URL);
        RestangularProvider.setDefaultHttpFields({timeout: 60*60*24});
        RestangularProvider.setDefaultHttpFields({cache: true});

        RestangularProvider.setErrorInterceptor(function(response, deferred, responseHandler) {
            if(response.status === 403) {
                return false; // error handled
            }
            return true; // error not handled
        });
    }]);

    // configure preload transliteration

    app.config(['$translateProvider', '$translatePartialLoaderProvider', function ($translateProvider, $translatePartialLoader) {

        // try to find out preferred language by yourself

        $translateProvider.fallbackLanguage(['en', 'ru', 'de', 'uk'])
            .determinePreferredLanguage()
            .registerAvailableLanguageKeys(['en', 'de', 'ru', 'uk'], {
                'en_US': 'en',
                'en_GB': 'en',
                'de_DE': 'de',
                'ua_UK': 'uk',
                'ru-RU': 'ru'
            });

        // get all partitions of language {part} - controller

        $translateProvider.useLoader('$translatePartialLoader', {
            urlTemplate: 'assets/phl/app/languages/{lang}/{part}.json'
        });
    }]);

})(angular);



