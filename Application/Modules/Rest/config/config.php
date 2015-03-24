<?php
/**
 * Global API configurations
 */
return [

    'api' => [
        'tokenLifetime'     =>  604800,
        'acceptContent'     => ['*/*', 'json'],
        'acceptLanguage'    => ['ru', 'en', 'ua', 'de'],
        'acceptCharset'     => 'utf-8',
        'acceptFilters'    => [
            'fields', 'offset', 'limit', 'token', 'locale', 'login', 'password'
        ],
    ]
];