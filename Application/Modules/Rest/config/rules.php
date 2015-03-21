<?php
/**
 * Validation rules. Follow syntax like
 *
 * return [
 *      'controller' => [
 *          'action'    =>  [
 *              'methods'    => 'GET',
 *              'param' => 'rules....'
 *          ]
 *      ]
 *      ...
 * ]
 */

use Application\Models\UserRoles;

return [
    'users'  =>  [
        'index'    =>  [
            'methods'   => 'GET,POST,PUT',
            'authentication'    =>  true,   // need access token ?
            'access'    =>   [  // access routes restrict for ACL
                UserRoles::ADMIN =>  [
                    'api/v1/users'
                ],
            ]
        ],
        'auth'    =>  [
            'methods'    => 'GET',
            'params'     => [
                'required' => 'access'
            ],
        ]
    ]
];