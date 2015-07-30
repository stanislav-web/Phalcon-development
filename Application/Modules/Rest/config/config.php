<?php
/**
 * Global API configurations
 */
return [

    'api' => [
        'tokenKey'          => 'token',
        'authHeader'        => 'AUTHORIZATION',
        'notifyDir'         => ':engine/notifies/',
        'tokenLifetime'     =>  604800,
        'acceptContent'     => ['*/*', 'json', 'application/json'],
        'acceptLanguage'    => ['ru', 'en', 'ua', 'de', 'uk'],
        'acceptCharset'     => 'utf-8',
        'acceptFilters'    => [
            'columns', 'offset', 'limit', 'token', 'locale', 'login', 'password', 'order', 'name', 'format', 'code', '_profile', '_time','surname', 'id', 'mapper', 'email', 'code', 'exception', 'message'
        ],
        'acceptQueryLength'    => 121,

        // base startup api request's resolver
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
        ],

        // uploaded files params
        'files' =>  [
            'profile'  =>  [
                'directory' => '/files/users/:directoryId',
                'minsize'   =>  1000,
                'maxsize'   =>  1000000,
                'mimes'     =>  [       // any allowed mime types
                    'image/gif',
                    'image/jpeg',
                    'image/png',
                ],
                'extensions'     =>  [  // any allowed extensions
                    'gif',
                    'jpeg',
                    'jpg',
                    'png',
                ],
                'sanitize' => true,
                'hash'     => 'md5'
            ]
        ],

    ]
];