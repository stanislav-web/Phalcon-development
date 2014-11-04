<?php
// Main aplication config file

$config = [

    // Global application config

    'application' => [
        'modelsDir'         => APP_PATH.'/Models/',
        'libraryDir'        => APP_PATH.'/Libraries/',
        'logDir'            => APP_PATH.'../logs/',
        'baseUri'           => '/',
        'cryptSalt'         => '$9diko$.f#11',
    ],

    // Configure database driver

    'database' =>   [
        'adapter'       => 'Mysql',              // Mysql, Postgres, Sqlite
        'host'          => 'localhost',
        'username'      => 'root',
        'password'      => 'root',
        'dbname'        => 'phalcon.local',
        'port'          => 3306,
        'charset'       => 'utf8',
        'persistent'    => true,
        'profiler'	    => false,
        'debug'	        => PDO::ERRMODE_SILENT,
    ],

    // Configure backend and frontend data caching

    'cache'     =>  [
        'enable'        =>  true,
        'lifetime'      => '86400',
        'prefix'        => 'files_',
        'adapter'       => 'Apc',
        'metadata'      =>  true,
        'annotations'   =>  true,

        'memcached' => [
            'host'          => '127.0.0.1',
            'port'          => 11211,
            'persistent'    => true,
        ],
    ],

    // Log configuration

    'logger'    =>  [
        'enable'    =>  false,
    ],

    // Mailing and subscribe configuration

    'mail' => [
        'fromName'  => 'Stanislav WEB',
        'fromEmail' => 'stanisov@gmail.com',
        'smtp' => [
            'server'   => 'smtp.gmail.com',
            'port'     => 587,
            'security' => 'tls',
            'username' => 'stanisov@gmail.com',
            'password' => 'QWERTY!@#$%^&*()',
        ],
    ],

    // oAuth service's config

    'oAuth'  => [

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
$config = file_exists(dirname(__FILE__). DIRECTORY_SEPARATOR . APPLICATION_ENV .'.php')
    ? array_merge_recursive_replace($config, require(APPLICATION_ENV .'.php'))
    : $config;