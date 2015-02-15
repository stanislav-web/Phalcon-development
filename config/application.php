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
        'cryptSalt' => '$9diko$.f#11',
    ],

    // Configure database driver

    'database' => [
        'adapter' => 'Mysql',              // Mysql, Postgres, Sqlite
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
        'lifetime' => 86400,
        'prefix' => 'cache_',
        'adapter' => 'apc',        //	Memcache, xCache, Apc
        'metadata' => true,
        'annotations' => true,

        'memcached' => [
            'host' => '127.0.0.1',
            'port' => 11211,
            'persistent' => true,
        ],
    ],

    // Log configuration

    'logger' =>  true,

    // Mailing and subscribe configuration

    'mail' => [

        'driver' => 'smtp', // mail, sendmail, smtp
        'host'   => 'smtp.gmail.com',
        'port'   => 587,
        'encryption' => 'tls',
        'from'   => [
            'email' => 'blabla@gmail.com',
            'name'    => 'Admin'
        ],
        'username'   => 'blabla@gmail.com',
        'password'   => '',
    ],

    // Default language

    'language'  => 'en',
    'translates'  => APP_PATH . '/../languages/',

    // Remember state
    'rememberKeep'   => 604800,
    'cookieCryptKey' => '#1dj8$=dp?.ak//j1V$',

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
        'BulkSMS'   =>  [
            'username'  => 'SWEB',
            'password'  => 'QWERTY123',
        ],
        'Clickatell'    =>  [
            'api_id'    => '3524819',
            'user'      => 'SWEB-TEST',
            'password'  => 'JRdaZcAGbaZSgR',
            'form'      => 'SWEB'
        ],
        'MessageBird'   => [
            'originator'        => 'Stanislav',
            'access_key'    =>  'test_UHaeiTLfAe3avOULhawXvn7iR',
        ],
        'Nexmo'         =>  [
            'from'      => 'SWEB',
            'api_key'       => '90c8f84f',
            'api_secret'  => 'e7e15653',
            'type'      => 'unicode'
        ],
        'SmsAero'       =>  [
            'from'          => 'INFORM',
            'user'          => 'stanisov@gmail.com',
            'password'      => '96e79218965eb72c92a549dd5a330112',
        ],
        'SMSC'       =>  [
            'login'     => 'SWEB',
            'psw'       => '11111111',
            'charset'   => 'utf-8',
            'sender'    => 'Stanislav',
            'translit'  => 0,
            'fmt'       => 3, // response as json
        ],
        'SmsUkraine'       =>  [
            'from'        => 'SWEB',
            'login'     => '380954916517',
            'password'  => '1111111111',
            'version'  => 'http',
            'flash'     => 0,
        ],
    ]
];