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
    'user'  =>  [
        'access'    =>  [
            'methods'    => 'GET',
            'params'     => [
                'required' => 'access'
            ],
        ]
    ]
];