<?php
/**
 * Global API configurations
 */
return [

    'api' => [
        'exceptionLog'      =>  true,
        'tokenLifetime'     =>  604800,
        'acceptContent'     => ['*/*', 'json'],
        'acceptLanguage'    => ['ru', 'en', 'ua', 'de'],
        'acceptCharset'     => 'utf-8'
    ]
];