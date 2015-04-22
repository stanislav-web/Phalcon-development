"use strict";

(function(angular) {

    // configure http responses
    app.config(['$httpProvider', function($httpProvider) {
        $httpProvider.interceptors.push('httpRequestInterceptor');
    }
    ]);

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



