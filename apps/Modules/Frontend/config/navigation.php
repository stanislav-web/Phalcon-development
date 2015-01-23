<?php
// Default navigation list
$navigation =   [

    0  =>  [
        'top'   =>  [
            [
                'title'     =>  'Home',
                'url'       =>  '/',
                'translate' =>  'HOME'
            ],
            [
                'title'     =>  'Agreement',
                'url'       =>  '/agreement',
                'translate' =>  'AGREEMENT'
            ],
            [
                'title'     =>  'Help',
                'url'       =>  '/help',
                'translate' =>  'HELP'
            ],
            [
                'title'     =>  'Contacts',
                'url'       =>  '/contacts',
                'translate' =>  'CONTACTS'
            ],
            [
                'title'     =>  'About',
                'url'       =>  '/about',
                'translate' =>  'ABOUT'
            ],
            [
                'title'     =>  'Sign In',
                'url'       =>  '#',
                'translate' =>  'SIGN IN',
                'onclick'   =>  'openSplash()'
            ]
        ]
    ],

    1    =>  [
        'top'   =>  [
            [
                'title' =>  'Home',
                'url'   =>  '/',
                'translate' =>  'HOME'
            ],
            [
                'title' =>  'My Account',
                'url'   =>  '/account',
                'translate' =>  'ACCOUNT'
            ],
            [
                'title' =>  'Logout',
                'url'   =>  '#',
                'translate' =>  'LOGOUT',
                'onclick'   =>  'logout()',
                'controller'=>  'SignCtrl'
            ],
        ]
    ]
];