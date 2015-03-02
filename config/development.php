<?php
/**
 * BE CAREFUL!
 * This section contains the settings of global application
 * Override production configs for development environment
 * @version DEVELOPMENT
 */

return [

    // Configure database driver

    'database' => [
        'adapter' => 'Mysql',     // Mysql, Postgres, Sqlite
        'username' => 'root',
        'password' => 'root',
        'dbname' => 'phalcon.local',
        'charset' => 'utf8',
        'port' => 3306,
        'persistent' => true,
        'debug' => PDO::ERRMODE_EXCEPTION,
    ],

    // Configure backend and frontend data caching

    // Configure backend and frontend data caching

    'cache' => [
        'enable' => false,
        'metadata' => false,
        'annotations' => false,

        'memcached' => [
            'host' => '127.0.0.1',
            'port' => 11211,
            'persistent' => false,
        ],
    ],

    // Mailing and subscribe configuration

    'mail' => [
        'fromName' => 'Admin',
        'fromEmail' => 'email@gmail.com',
        'smtp' => [
            'server' => 'smtp.gmail.com',
            'port' => 587,
            'security' => 'tls',
            'username' => 'Admin',
            'password' => '',
        ],
    ],

    // assets distributions
    'assets'    =>  [
        'css'   =>  [
            'header-css'    =>  [
                'assets/plugins/bootstrap/dist/css/bootstrap.css',
                'assets/frontend/:engine/css/style.css',
                'assets/frontend/:engine/css/menu.css',
                'assets/frontend/:engine/css/splash.css'
            ]
        ],
        'js'    =>  [
            'header-js'    =>  [
                'assets/plugins/store/store.js',
                'assets/plugins/angular/angular.js',
                'assets/plugins/angular-route/angular-route.js',
                'assets/plugins/angular-sanitize/angular-sanitize.js',
                'assets/plugins/angular-translate/angular-translate.js',
                'assets/plugins/angular-translate-loader-partial/angular-translate-loader-partial.js',
                'assets/plugins/angular-cookies/angular-cookies.js',
                'assets/plugins/angular-spinner/angular-spinner.js',
                'assets/plugins/angular-utf8-base64/angular-utf8-base64.js',
                'assets/plugins/angular-animate/angular-animate.js',
                'assets/plugins/jquery/dist/jquery.js',
                'assets/plugins/bootstrap/dist/js/bootstrap.js',
                'assets/plugins/ui-bootstrap-tpl/ui-bootstrap-tpl.js',
                'assets/plugins/spinner/spin.js',
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
    ]
];
