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
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'    => 'GET',
            'params'     => [
                'required' => 'login,password'
            ],
            'mapper'   => 'UserMapper'
        ],
        'post' => [
            'requests'  =>  [  // limit request per time
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'    => 'POST',
            'params'     => [
                'required' => 'login,password,name'
            ],
            'mapper'   => 'UserMapper'
        ],
        'put' => [
            'requests'  =>  [  // limit request per time
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'    => 'PUT',
            'params'     => [
                'required' => 'login'
            ],
            'mapper'   => 'UserMapper'
        ],
        'delete' => [
            'requests'  =>  [  // limit request per time
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'    => 'DELETE',
            'mapper'   => 'UserMapper'
        ],
    ],
    'users'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  2500,
                'time'  =>  60,
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
                'limit' =>  2500,
                'time'  =>  60,
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
                'limit' =>  2500,
                'time'  =>  60,
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
    'currencies'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'   =>  'GET',
            'mapper'    =>  'CurrencyMapper',
        ],
    ],
    'errors'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'   => 'GET',
            'mapper'   => 'ErrorMapper'
        ],
    ],
    'pages'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'   => 'GET,POST,PUT,DELETE',
            'mapper'   => 'PageMapper'
        ]
    ],
    'banners'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'   => 'GET,POST,PUT,DELETE',
            'mapper'   => 'BannersMapper'
        ]
    ],
    'categories'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'   => 'GET,POST,PUT,DELETE',
            'mapper'   => 'CategoryMapper'
        ]
    ]
];