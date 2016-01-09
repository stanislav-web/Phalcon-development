<?php
    /**
     * BE CAREFUL!
     * This section contains the settings of global application
     * @version DEVELOPMENT
     */

    ini_set('display_errors', 'On');
    error_reporting(E_ALL & ~E_WARNING);

    return [

        // Global application config

        'application'   => [
            'cryptSalt'         => '#1dj8$asssV$',
        ],

        // Configure database driver

        'database'      => [
            'host'              => 'localhost',
            'username'          => 'root',
            'password'          => 'root',
            'dbname'            => 'backend.local',
            'port'              => 3306,
            'profiling'         => true,
            'debug'             => PDO::ERRMODE_EXCEPTION,
        ],

        // Configure backend and frontend data caching

        'cache'         => [
            'enable'            => false,
            'lifetime'          => 0,
            'prefix'            => 'cache_',
            'adapter'           => 'memcached',
            'metadata'          => false,
            'annotations'       => false,
            'code'              => false,
        ]
    ];