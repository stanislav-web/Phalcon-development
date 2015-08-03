var CONFIG = {};

(function(window) {

    "use strict";

    CONFIG = {
        TITLE : 'Phalcon Shop',
        URL: 'http://backend.local/api/v1',
        FILES_URL: 'http://backend.local',
        ENGINE_ID: 1,
        BANNERS: true,
        LOGGER: true,
        DEBBUG: false,
        REQUEST_TIMEOUT: 3000,
        UPLOAD_FILE_METHOD: 'POST',
        DEFAULT_CURRENCY: 'UAH',
        ACCEPT_ENCODING: 'application/json; charset=utf-8',
        FORM_ENCODING: 'application/x-www-form-urlencoded; charset=utf-8',
        LOCAL: {
            CUSTOMER_AUTH_MENU: '/assets/data/menu/customer-auth.json',
            CUSTOMER_MENU: '/assets/data/menu/customer.json'
        },
        SLIDER: {
            INTERVAL: 1000
        },
        DEFAULT_IMAGES : {
            BANNERS : '/assets/images/default_banner.png'
        },
        LANGUAGES: {
            ACCEPT: ['en', 'ru', 'uk'],
            ALIASES: {
                'en_US': 'en',
                'en_GB': 'en',
                'ua_UK': 'uk',
                'ru-RU': 'ru'
            },
            DEFAULT: 'en',
            PREFIX: 'locale',
            TEMPLATE: '/assets/data/languages/{lang}/{part}.json'
        },
        LIST: {
            PARTS: 5
        },
        CATCHED_ERRORS: [400, 401, 403, 404, 405, 406, 409, 414, 415, 422, 429, 500],
        DIRECTIVES: {
            TOP:            '/app/modules/common/templates/directives/top.tpl.html',
            BOTTOM:         '/app/modules/common/templates/directives/bottom.tpl.html',
            CATEGORIES:     '/app/modules/common/templates/directives/categories.tpl.html',
            SIDEBAR:        '/app/modules/common/templates/directives/sidebar.tpl.html',
            BANNERS:        '/app/modules/common/templates/directives/banners.tpl.html',
            SOCIAL:         '/app/modules/common/templates/directives/social.tpl.html',
            SUBSCRIBE:      '/app/modules/common/templates/directives/subscribe.tpl.html'
        },
        LOCATIONS: {
            HOME: '/',
            AUTH: '/sign',
            ACCOUNT: '/user/account',
            NOT_FOUND : '/404',
            FORBIDDEN : '/403'
        },
        REST: {
            AUTH: '/sign',
            USERS: '/users',
            FILES: '/files',
            SUBSCRIBE: '/subscribe',
            LOG      : '/logger',
            CATEGORY : '/categories',
            ITEM_ATTRIBUTES : '/items/:ids/attributes'

        },
        ROUTER : {
            '/': {
                templateUrl: '/app/modules/common/templates/index.tpl.html',
                controller:  'CommonController'
            },
            '/logout': {
                controller: 'SignController',
                resolve: {
                    isLoggedIn: function (AuthenticationService) {
                        var logged = AuthenticationService.logout(CONFIG.REST.AUTH);
                        if(logged) {
                            logged.then(function() {
                                window.location.assign(CONFIG.LOCATIONS.HOME);
                            });
                        }
                        window.location.assign(CONFIG.LOCATIONS.HOME);
                    }
                }
            },
            '/sign': {
                templateUrl: '/app/modules/authenticate/templates/sign.tpl.html',
                controller: 'SignController'
            },
            '/user/:name': {
                templateUrl: function(urlattr) {
                    return '/app/modules/user/templates/' + urlattr.name + '.tpl.html';
                },
                controller: 'UserController',
                caseInsensitiveMatch: true,
                access : ['User', 'Admin'],
                authorization : true,
                resolve: {
                    isLoggedIn: function (AuthenticationService) {
                        return AuthenticationService.isLoggedIn();
                    }
                }
            },
            '/category/:main*': {
                templateUrl: '/app/modules/catalogue/templates/items.tpl.html',
                controller: 'ItemsController',
                resolve: {

                }
            },
            '/page/:page' : {
                templateUrl: '/app/modules/common/templates/pages.tpl.html',
                controller: 'CommonController'
            },
            '/404': {
                templateUrl: '/app/modules/common/templates/404.tpl.html',
                controller: 'CommonController'
            },
            '/403': {
                templateUrl: '/app/modules/common/templates/403.tpl.html',
                controller: 'CommonController'
            }
        },
        SOCIAL : {
            VK : 'http://vk.com/stanislav_web',
            FACEBOOK : 'http://fb.com',
            YOUTUBE : 'http://youtube.com',
            TWITTER : 'http://twitter.com',
            GOOGLE : 'http://google.com'
        }
    };
})(window);