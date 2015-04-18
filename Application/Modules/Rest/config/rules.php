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

    'sign'    =>  [
        'get' => [
            'requests'  =>  [  // limit request per time
                'limit' =>  10,
                'time'  =>  1,
            ],
            'methods'    => 'GET',
            'params'     => [
                'required' => 'login,password'
            ],
            'mapper'   => 'UserMapper'
        ],
        'post' => [
            'requests'  =>  [  // limit request per time
                'limit' =>  10,
                'time'  =>  1,
            ],
            'methods'    => 'POST',
            'params'     => [
                'required' => 'login,password,name'
            ],
            'mapper'   => 'UserMapper'
        ],
        'put' => [
            'requests'  =>  [  // limit request per time
                'limit' =>  10,
                'time'  =>  1,
            ],
            'methods'    => 'PUT',
            'params'     => [
                'required' => 'login'
            ],
            'mapper'   => 'UserMapper'
        ],
        'delete' => [
            'requests'  =>  [  // limit request per time
                'limit' =>  10,
                'time'  =>  1,
            ],
            'methods'    => 'DELETE',
            'mapper'   => 'UserMapper'
        ],
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
    'engines'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  10,
                'time'  =>  1,
            ],
            'methods'   =>  'GET',
            'mapper'    =>  'EngineMapper',
            'relations' =>  [
                'categories' => [
                    'CategoryMapper' => [
                        'id' => 'engine_id'
                    ]
                ]
            ]
        ],
    ],
    'errors'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  10,
                'time'  =>  1,
            ],
            'methods'   => 'GET',
            'mapper'   => 'ErrorMapper'
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