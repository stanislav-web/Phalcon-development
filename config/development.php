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

    'profiling' =>  true,

    // Configure database driver

    'database' => [
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
            'api_key'   => '90c8f84f',
            'api_secret'=> 'e7e15653',
            'type'      => 'unicode',
            'request_method' => 'GET'
        ],

        'BulkSMS'   =>  [
            'username'  => 'SWEB',
            'password'  => 'e7e15653',
        ],
        'SmsAero' => [
            'from'          => 'Test',
            'user'          => 'stanisov@gmail.com',
            'password'      => 'e7e15653',
        ],

        'SmsUkraine'       =>  [
            'from'          => 'Stanislav',
            'login'         => '380954916517',
            'password'      => 'e7e15653',
            'version'       => 'http',
        ],

        'SMSC'       =>  [
            'login'     => 'SwebTester',
            'psw'       => 'e7e15653',
            'charset'   => 'utf-8',
            'sender'    => 'SWEB',
            'translit'  => 0,
        ],

        'SMSRu' => [
            'api_id'    => '66bf9913-5cda-2654-9980-f440a1f293eb'
        ],

        'Clickatell'    => [
            'api_id'    => 3537200,
            'user'      => 'SWEBTEST',
            'password'  => 'e7e15653',
            'from'      => 'Stanislav',
            'request_method' => 'GET'
        ],

        'MessageBird'   => [
            'originator'   => '434',
            'access_key'   => 'test_UHaeiTLfAe3avOULhawXvn7iR',
            'request_method' => 'GET'
        ],
    ]
];
