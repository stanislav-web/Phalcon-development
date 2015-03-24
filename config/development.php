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

    // Rest configuration
];
