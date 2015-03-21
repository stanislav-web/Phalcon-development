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
            'requests'  =>  [  // limit request per seconds
                    'limit' =>  1000,
                    'time'  =>  1,
                ],
            'methods'   => 'GET,POST,PUT',
            'authentication'    =>  true,   // need access token ?
            'access'    =>   [  // access routes restrict for ACL
                UserRoles::ADMIN =>  [
                    'api/v1/users'
                ],
            ]
        ],
        'auth'    =>  [
            'requests'  =>  [  // limit request per time
                'limit' =>  12,
                'time'  =>  1,
            ],            'methods'    => 'GET',
            'params'     => [
                'required' => 'access'
            ],
        ]
    ]
];