<?php
// Main aplication config file

$config = [

    // Global application config

    'application' => [
        'controllersFront' => APP_PATH . '/Modules/Frontend/Controllers/',
        'controllersBack' => APP_PATH . '/Modules/Backend/Controllers/',
        'formsBack' => APP_PATH . '/Modules/Backend/Forms/',
        'viewsFront' => APP_PATH . '/Modules/Frontend/views/',
        'viewsBack' => APP_PATH . '/Modules/Backend/views/',
        'modelsDir' => APP_PATH . '/Models/',
        'helpersDir' => APP_PATH . '/Helpers/',
        'libraryDir' => APP_PATH . '/Libraries/',
        'pluginsDir' => APP_PATH . '/Plugins/',
        'logDir' => APP_PATH . '../logs/',
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

    'logger' => [
        'enable' => true,
        'file' => DOCUMENT_ROOT . '/../logs/phalcon.log',
        'format' => '[%date%][%type%] %message%',
    ],

    // Mailing and subscribe configuration

    'mail' => [

        'driver' => 'smtp', // mail, sendmail, smtp
        'host'   => 'smtp.gmail.com',
        'port'   => 587,
        'from'   => [
            'address' => '1@gmail.com',
            'name'    => 'Admin'
        ],
        'encryption' => 'tls',
        'username'   => '1@gmail.com',
        'password'   => '1',
        'sendmail'   => '/usr/sbin/sendmail -bs',
    ],

    // Default language

    'language'  => 'en',

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
                'assets/plugins/ui-bootstrap-tpl/ui-bootstrap-tpl.min.js'
            ],
            'footer-js'    =>  [

            ],
        ]
    ]
];

/**
 * array_merge_recursive_replace() Replace config by system stage environment
 *
 * @return array
 */
function array_merge_recursive_replace()
{
    $arrays = func_get_args();
    $base = array_shift($arrays);

    foreach ($arrays as $array) {
        reset($base);
        while (list($key, $value) = @each($array)) {
            if (is_array($value) && @is_array($base[$key])) {
                $base[$key] = array_merge_recursive_replace($base[$key], $value);
            } else {
                $base[$key] = $value;
            }
        }
    }
    return $base;
}

// override production config by enviroment config
$config = file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . APPLICATION_ENV . '.php')
    ? array_merge_recursive_replace($config, require(APPLICATION_ENV . '.php'))
    : $config;
