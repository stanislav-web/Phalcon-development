<?php
/**
 * BE CAREFUL!
 * This section contains the settings of global application
 * @version PRODUCTION
 */

$config = [

    // Global application config

    'application' => [
        'viewsFront' => APP_PATH . '/Modules/Frontend/views/',
        'viewsBack' => APP_PATH . '/Modules/Backend/views/',
        'baseUri' => '/',
        'cryptSalt' => '#1dj8$=dp?.ak//j1V$',
    ],

    // Configure database driver

    'database' => [
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'dbname' => 'phalcon.local',
        'port' => 3306,
        'charset' => 'utf8',
        'persistent' => true,
        'debug' => PDO::ERRMODE_SILENT,
    ],

    // Configure backend and frontend data caching

    'cache' => [
        'enable' => true,
        'lifetime' => 604800,
        'prefix' => 'cache_',
        'adapter' => 'memcached',
        'metadata' => true,
        'annotations' => true,

        'memcached' => [
            'host' => '127.0.0.1',
            'port' => 11211,
            'persistent' => true,
        ],
    ],

    // Mailing and subscribe configuration

    'mail' => [

        'driver' => 'smtp',
        'host'   => 'smtp.gmail.com',
        'port'   => 587,
        'encryption' => 'tls',
        'from'   => [
            'email' => 'bla@gmail.com',
            'name'    => 'Admin'
        ],
        'username'   => 'bla@gmail.com',
        'password'   => 'bla',
    ],

    // App localization by default

    'locale'    =>  [
        'language'  => 'en',
        'translates'  => APP_PATH . '/../languages/',
    ],

    // assets distributions

    'assets'    =>  [
        'css'   =>  [
            'header-css'    =>  [
                'assets/plugins/bootstrap/dist/css/bootstrap.min.css',
                'assets/frontend/:engine/css/style.css',
                'assets/frontend/:engine/css/menu.css',
                'assets/frontend/:engine/css/splash.css'
            ]
        ],
        'js'    =>  [
            'header-js'    =>  [
                'assets/plugins/store/store.min.js',
                'assets/plugins/angular/angular.min.js',
                'assets/plugins/angular-route/angular-route.min.js',
                'assets/plugins/angular-sanitize/angular-sanitize.min.js',
                'assets/plugins/angular-translate/angular-translate.min.js',
                'assets/plugins/angular-translate-loader-partial/angular-translate-loader-partial.min.js',
                'assets/plugins/angular-cookies/angular-cookies.min.js',
                'assets/plugins/angular-spinner/angular-spinner.min.js',
                'assets/plugins/angular-utf8-base64/angular-utf8-base64.min.js',
                'assets/plugins/angular-animate/angular-animate.min.js',
                'assets/plugins/jquery/dist/jquery.min.js',
                'assets/plugins/bootstrap/dist/js/bootstrap.min.js',
                'assets/plugins/ui-bootstrap-tpl/ui-bootstrap-tpl.min.js',
                'assets/plugins/spinner/spin.min.js',
            ],
            'footer-js'    =>  [
                'assets/frontend/:engine/app/app.js',
                'assets/frontend/:engine/app/app.config.js',
                'assets/frontend/:engine/app/common/directives/spinner.js',
                'assets/frontend/:engine/app/common/services/splash.js',
                'assets/frontend/:engine/app/common/services/session.js',
                'assets/frontend/:engine/app/common/controllers/menu.js',
                'assets/frontend/:engine/app/common/controllers/language.js',
                'assets/frontend/:engine/app/common/controllers/index.js',
                'assets/frontend/:engine/app/authenticate/services/authentication.js',
                'assets/frontend/:engine/app/authenticate/controllers/sign.js',
                'assets/frontend/:engine/app/user/controllers/user.js',
                'assets/frontend/:engine/js/menu.js',
                'assets/frontend/:engine/js/move-top.js',
                'assets/frontend/:engine/js/easing.js',
                'assets/frontend/:engine/js/rules.js',
            ],
        ]
    ],

    // sms api configurations
    'sms'   =>  [

        'Nexmo'         =>  [
            'from'      => 'Phalcon Dev',
            'api_key'   => 'ssss',
            'api_secret'=> 'ssss',
            'type'      => 'unicode'
        ],
    ]
];