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
            'mapper'   => 'UserMapper',
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
            'mapper'   => 'UserMapper',
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
            'mapper'   => 'UserMapper',
            'authentication'    =>  true,   // need access token ?
            'access'    =>   [  // access routes restrict for ACL
                UserRoles::ADMIN =>  [
                    'api/v1/users'
                ],
                UserRoles::USER =>  [
                    'api/v1/users'
                ]
            ],

        ],
    ],
    'subscribe'    =>  [
        'post' => [
            'requests'  =>  [  // limit request per time
                'limit' =>  1,
                'time'  =>  60,
            ],
            'methods'    => 'POST',
            'params'     => [
                'required' => 'email'
            ],
            'mapper'   => 'SubscribeMapper'
        ]
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
        'put'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'   => 'GET,POST,PUT',
            'authentication'    =>  true,   // need access token ?
            'access'    =>   [  // access routes restrict for ACL
                UserRoles::USER =>  [
                    'api/v1/users'
                ],
                UserRoles::ADMIN =>  [
                    'api/v1/users'
                ],
            ],
            'params'     => [
                'required' => 'id'
            ],
            'mapper'   => 'UserMapper'
        ],
    ],
    'files'  =>  [
        'post'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'   => 'GET,POST,PUT,DELETE',
            'authentication'    =>  true,   // need access token ?
            'access'    =>   [  // access routes restrict for ACL
                UserRoles::USER =>  [
                    'api/v1/users'
                ],
                UserRoles::ADMIN =>  [
                    'api/v1/users'
                ],
            ],
            'mapper'   => 'FileMapper'
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
                    'mapper' => 'CategoryMapper',
                    'rel'     => [
                        'id' => 'engine_id'
                    ],
                    'order' => 'lft, sort'
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
    'attributes'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'   =>  'GET',
            'mapper'    =>  'ItemAttributesMapper',
        ],
    ],
    'values'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'   =>  'GET',
            'mapper'    =>  'ItemAttributeValuesMapper',
        ],
    ],
    'items'  =>  [
        'get'    =>  [
            'requests'  =>  [  // limit request per seconds
                'limit' =>  2500,
                'time'  =>  60,
            ],
            'methods'   =>  'GET',
            'mapper'    =>  'ItemsMapper',
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