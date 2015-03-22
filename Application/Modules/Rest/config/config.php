<?php
/**
 * Global API configurations
 */

return [

    'api' => [
        'token' =>  [
            'lifetime'  =>  604800
        ],
        'acceptContent'    => ['*/*', 'json'],
        'acceptLanguage'   => ['ru', 'en', 'ua', 'de'],
        'acceptCharset'    => 'utf-8'
    ]
];