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

    'auth'    =>  [
        'get' => [
            'requests'  =>  [  // limit request per time
                'limit' =>  10,
                'time'  =>  1,
            ],
            'methods'    => 'GET',
            'params'     => [
                'required' => 'access'
            ],
            'mapper'   => 'UserMapper'
        ]
    ],
    'users'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                    'limit' =>  10,
                    'time'  =>  1,
                ],
            'methods'   => 'GET,POST,PUT',
            'authentication'    =>  true,   // need access token ?
            'access'    =>   [  // access routes restrict for ACL
                UserRoles::ADMIN =>  [
                    'api/v1/users'
                ],
            ],
            'mapper'   => 'UserMapper'
        ],
    ],

    'logs'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  10,
                'time'  =>  1,
            ],
            'methods'   => 'GET',
            'authentication'    =>  true,   // need access token ?
            'access'    =>   [  // access routes restrict for ACL
                UserRoles::ADMIN =>  [
                    'api/v1/logs'
                ],
            ],
            'mapper'   => 'LogMapper'
        ],
    ],

    'pages'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  5,
                'time'  =>  10,
            ],
            'methods'   => 'GET,POST,PUT,DELETE',
            'mapper'   => 'PageMapper'
        ]
    ],
    'categories'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  5,
                'time'  =>  10,
            ],
            'methods'   => 'GET,POST,PUT,DELETE',
            'mapper'   => 'CategoryMapper'
        ]
    ]
];