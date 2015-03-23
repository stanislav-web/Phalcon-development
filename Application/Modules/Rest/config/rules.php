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

    // configure controllers => actions

    'users'  =>  [
        'index'    =>  [
            'requests'  =>  [  // limit request per seconds
                    'limit' =>  1,
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
                'limit' =>  1,
                'time'  =>  1,
            ],
            'methods'    => 'GET',
            'params'     => [
                'required' => 'access'
            ],
        ]
    ],

    'pages'  =>  [
        'index'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  1,
                'time'  =>  1,
            ],
            'methods'   => 'GET,POST,PUT,DELETE'
        ]
    ]
];