var CONFIG = {
    URL: 'http://api.phalcon.local/api/v1',
    ENGINE_ID: 1,
    BANNERS: true,
    LOGGER: true,
    REQUEST_TIMEOUT: 15000,
    DEFAULT_CURRENCY: 'UAH',
    ACCEPT_ENCODING: 'application/json; charset=utf-8',
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
    TEMPLATES: {
        MENU_TOP: '/app/common/templates/menu_top.html',
        MENU_CATEGORIES: '/app/common/templates/menu_categories.html',
        MENU_SIDEBAR: '/app/common/templates/sidebar.html',
        SLIDESHOW: '/app/common/templates/slideshow.html',
        PAGES: '/app/common/templates/index.html',
        ERROR: '/app/common/templates/error.html',
        SIGN: '/app/authenticate/templates/sign.html',
        ACCOUNT: '/app/user/templates/account.html'
    },
    ROUTES: {
        HOME: '/',
        AUTH: '/sign',
        ACCOUNT: '/account'
    }
};