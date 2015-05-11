"use strict";

(function(angular) {

    // set base config constants
    app.constant('BASE', (function () {

        return {
            URL:       'http://api.phalcon.local/api/v1',
            ENGINE_ID: 1,
            BANNERS: true,
            LOGGER: true,
            REQUEST_TIMEOUT  : 3000,
            DEFAULT_CURRENCY : 'UAH',
            ACCEPT_ENCODING : 'application/json; charset=utf-8',
            LOCAL: {
                CUSTOMER_AUTH_MENU :    '/assets/phl/app/data/menu/customer-auth.json',
                CUSTOMER_MENU :         '/assets/phl/app/data/menu/customer.json'
            },
            SLIDER : {
                TIMEOUT : 1000
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
            LIST : {
                PARTS : 5
            },
            CATCHED_ERRORS : [400, 401, 403, 404, 405, 406, 409, 414, 415, 422, 429, 500],
            TEMPLATES : {
                MENU_TOP:           'assets/phl/app/common/templates/menu_top.html',
                MENU_CATEGORIES:    'assets/phl/app/common/templates/menu_categories.html',
                MENU_SIDEBAR  :    'assets/phl/app/common/templates/sidebar.html',
                SLIDESHOW  :    'assets/phl/app/common/templates/slideshow.html',
                PAGES:      'assets/phl/app/common/templates/index.html',
                ERROR:      'assets/phl/app/common/templates/error.html',
                SIGN:       'assets/phl/app/authenticate/templates/sign.html',
                ACCOUNT:    'assets/phl/app/user/templates/account.html'
            },
            ROUTES : {
                HOME:       '/',
                SIGN:       '/sign',

                PAGES:      '/page/:page',
                NOT_FOUND:  '/error/notfound',
                SERVER_ERROR:  '/error/uncaughtexception',
                ACCOUNT:    '/account',
                VERIFY :    '/sign/verify',
                LOGIN :     '/sign/login',
                REGISTER :  '/sign/register',
                RESTORE :   '/sign/restore',
                LOGOUT :    '/sign/logout'
            }
        };
    })());

    // configure base rest loader
    app.config(['RestangularProvider', 'BASE', '$logProvider', function(RestangularProvider, BASE, $logProvider) {

        $logProvider.debugEnabled(BASE.LOGGER);
        RestangularProvider.setBaseUrl(BASE.URL);
        RestangularProvider.setDefaultHttpFields({cache: true, timeout: BASE.REQUEST_TIMEOUT});
        RestangularProvider.setDefaultRequestParams('get', {locale: localStorage.getItem(BASE.LANGUAGES.PREFIX)});
        RestangularProvider.setDefaultHeaders(
            { "Accept": BASE.ACCEPT_ENCODING}
        );

        RestangularProvider.setErrorInterceptor(function(response, deferred, responseHandler) {
            if(BASE.CATCHED_ERRORS.indexOf(response.status) != -1) {

                // set errors for transit to run watcher
                var error = response.data.error;
                notify.error(error.code +' ' +error.message, error.data[Object.keys(error.data)[0]]);
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
            urlTemplate: BASE.LANGUAGES.TEMPLATE,
            loadFailureHandler : 'TranslateErrorHandler'
        });
    }]);

})(angular);



