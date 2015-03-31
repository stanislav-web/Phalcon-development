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
            'columns', 'offset', 'limit', 'token', 'locale', 'login', 'password', 'order', 'name', 'format', 'code'
        ],
        'acceptQueryLength'    => 121,

        'requestResolvers' => [
            '\Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveMethod',
            '\Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveRequestLimit',
            '\Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveAccept',
            '\Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveAccess',
            '\Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveRequestLength',
        ],
        // POST 304 Redirects
        'redirects' => [
            '/api/v1/sign' => '/api/v1/users',
        ]
    ]
];