var CONFIG = {
    URL: 'http://api.phalcon.local/api/v1',
    FILES_URL: 'http://phalcon.local',
    ENGINE_ID: 1,
    BANNERS: true,
    LOGGER: true,
    DEBBUG: true,
    REQUEST_TIMEOUT: 15000,
    DEFAULT_CURRENCY: 'UAH',
    ACCEPT_ENCODING: 'application/json; charset=utf-8',
    FORM_ENCODING: 'application/x-www-form-urlencoded; charset=utf-8',
    LOCAL: {
        CUSTOMER_AUTH_MENU: '/data/menu/customer-auth.json',
        CUSTOMER_MENU: '/data/menu/customer.json'
    },
    SLIDER: {
        TIMEOUT: 1000
    },
    LANGUAGES: {
        ACCEPT: ['en', 'ru', 'de', 'uk'],
        ALIASES: {
            'en_US': 'en',
            'en_GB': 'en',
            'de_DE': 'de',
            'ua_UK': 'uk',
            'ru-RU': 'ru'
        },
        DEFAULT: 'en',
        PREFIX: 'locale',
        TEMPLATE: '/data/languages/{lang}/{part}.json'
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
        SUBSCRIBE: '/subscribe'
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
                    AuthenticationService.logout(CONFIG.REST.AUTH).then(function() {
                       window.location.assign(CONFIG.LOCATIONS.HOME);
                    });
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