<?php
// Default navigation list
$navigation =   [

    'top'   =>  [
        [
            'title'     =>  'Home',
            'url'       =>  '/',
            'translate' =>  'HOME',
            'logged'    =>  'false'
        ],
        [
            'title'     =>  'Agreement',
            'url'       =>  '/agreement',
            'translate' =>  'AGREEMENT',
            'logged'    =>  'false'
        ],
        [
            'title'     =>  'Help',
            'url'       =>  '/help',
            'translate' =>  'HELP',
            'logged'    =>  'false'

        ],
        [
            'title'     =>  'Contacts',
            'url'       =>  '/contacts',
            'translate' =>  'CONTACTS',
            'logged'    =>  'false'
        ],
        [
            'title'     =>  'About',
            'url'       =>  '/about',
            'translate' =>  'ABOUT',
            'logged'    =>  'false'

        ],
        [
            'title'     =>  'Sign In',
            'url'       =>  '#',
            'translate' =>  'SIGN IN',
            'onclick'   =>  'openSplash()',
            'logged'    =>  'false'

        ],
        [
            'title'     =>  'My Account',
            'url'       =>  '/account',
            'translate' =>  'ACCOUNT',
            'logged'    =>  'true'
        ],
        [
            'title'     =>  'Logout',
            'url'       =>  '#',
            'translate' =>  'LOGOUT',
            'onclick'   =>  'logout()',
            'controller'=>  'SignCtrl',
            'logged'    =>  'true'
        ],
    ],

];