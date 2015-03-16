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
        'access'    =>  [
            'methods'    => 'GET,PUT,DELETE',
            'params'     => [
                'required' => 'access'
            ],
        ]
    ]
];