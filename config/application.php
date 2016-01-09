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

        'application'   => [
            'baseUri'           => '/',
            'cryptSalt'         => '#1dj8$=dp?.ak//j1V$',
        ],

        // CLI task's configuration
        'cli'   =>  [
            // Backup task configuration
            'backup'    =>  [
                'logfile'       =>  APP_PATH.'/../logs/backup.log',
                'directory'     =>  APP_PATH.'/../build/migrations',
                'exclusion'     =>  [
                    // excluded tables here
                ],
                'routines' => true,
            ],

            // Sonar task configuration
            'sonar' =>  [
                'debug'     =>   false,  // verbose mode !Disable for production
                'errors'    =>   true,  // add errors to logfile
                'cache'     =>   true,  // enable cache
                'errorLog'  =>   APP_PATH.'/../logs/sonar-error.log',

                // queue client configurations
                'beanstalk'        =>  [
                    'host'  =>  '127.0.0.1',
                    'port'  =>  11300,
                ],

                // webscoket server configuration
                'socket'        =>  [
                    'host'  =>  '127.0.0.1',
                    'port'  =>  9003,
                ],

                // db storage configuration (Mongo)
                'storage'       =>  [
                    'host'      =>  '127.0.0.1',
                    'port'      =>  27017,
                    'user'      =>  'root',
                    'password'  =>  'root',
                    'dbname'    =>  'sonar',
                ]
            ]
        ],

        // Configure database driver

        'database'      => [
            'host'              => 'localhost',
            'username'          => 'root',
            'password'          => 'root',
            'dbname'            => 'backend.local',
            'port'              => 3306,
            'charset'           => 'utf8',
            'persistent'        => false,
            'profiling'         => false,
            'debug'             => PDO::ERRMODE_SILENT,
        ],

        // Configure session adapter

        'session'       => [
            'lifetime'          => 604800,
            'prefix'            => 'session_',
            'adapter'           => 'memcache',
            'salt'              => 'sjdif3434234',

            'memcache'  => [
                'host'          => '127.0.0.1',
                'port'          => 11211,
                'persistent'    => true,
            ],
        ],

        // Configure backend and frontend data caching

        'cache'         => [
            'enable'            => true,
            'lifetime'          => 300,
            'prefix'            => 'cache_',
            'adapter'           => 'memcached',
            'metadata'          => true,
            'annotations'       => true,
            'code'              => true,

            'memcached' => [
                'host'          => '127.0.0.1',
                'port'          => 11211,
                'persistent'    => false,
            ],
        ],

        // Mailing and subscribe configuration

        'mail'          => [
            'driver'            => 'smtp',
            'host'              => 'smtp.gmail.com',
            'port'              => 587,
            'encryption'        => 'tls',
            'from'              => [
                'email'             => '',
                'name'              => 'Admin'
                                ],
            'username'          => '',
            'password'          => '',
        ],

        // SMS api configurations

        'sms'           =>  [
            'Nexmo'             =>  [
                'from'              => 'Phalcon Dev',
                'api_key'           => '',
                'api_secret'        => '',
                'type'              => 'unicode'
                                ],
        ],

        // App localization by default

        'locale'        =>  [
            'language'          => 'en',
            'translates'        => APP_PATH . '/Modules/Rest/Languages/',
        ],

        // Image generator config
        'images'    =>  [
            'adapter'   =>  '\Phalcon\Image\Adapter\Imagick',
            'config'    =>  [
                'resize'   =>  [
                    // x,y prefix, quality
                    'mini'      =>  [64, 64,   '_mini', 80],
                    'small'     =>  [150, 150, '_small', 80],
                    'middle'    =>  [350, 350, '_middle', 80],
                    'big'       =>  [1024, 768, '_big', 80],
                ]
            ]
        ],
    ];