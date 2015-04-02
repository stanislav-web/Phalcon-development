<?php
/**
 * BE CAREFUL!
 * This section contains the settings of global application
 * Override production configs for development environment
 * @version DEVELOPMENT
 */

ini_set('display_errors', 'On');
error_reporting(7);

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
        'driver' => 'smtp',
        'host'   => 'smtp.gmail.com',
        'port'   => 587,
        'encryption' => 'tls',
        'from'   => [
            'email' => 'stanisov@gmail.com',
            'name'    => 'Admin'
        ],
        'username'   => 'stanisov@gmail.com',
        'password'   => '04d7019c',
    ],

    // SMS api configurations

    'sms'   =>  [
        'Nexmo'         =>  [
            'from'      => 'Phalcon Dev',
            'api_key'   => '90c8f84',
            'api_secret'=> 'e7e15653',
            'type'      => 'unicode'
        ],
    ]
];
