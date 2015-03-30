<?php
/**
 * BE CAREFUL!
 * This section contains the settings of global application
 * @version PRODUCTION
 */

ini_set('display_errors', 'Off');
error_reporting(0);

$config = [

    // Global application config

    'application' => [
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
        'persistent' => false,
        'debug' => PDO::ERRMODE_SILENT,
    ],

    // Configure backend and frontend data caching

    'cache' => [
        'enable' => false,
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
];