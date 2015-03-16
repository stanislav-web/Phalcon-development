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
return [
    'users'  =>  [
        'index'    =>  [
            'methods'   => 'GET,POST,PUT',
            'authentication'    =>  true,   // need access token ?
            'access'    =>   [  // access routes restrict for ACL
                '1' =>  [
                    '/api/v1/users'
                ],
            ]
        ],
        'access'    =>  [
            'methods'    => 'GET,PUT,DELETE',
            'params'     => [
                'required' => 'access'
            ],
        ]
    ]
];