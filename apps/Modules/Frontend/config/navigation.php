<?php
// Default navigation list
$navigation =   [

    'top'   =>  [
        [
            'title'     =>  'Home',
            'url'       =>  '/',
            'translate' =>  'HOME',
            'isAuthenticated'    =>  'false'
        ],
        [
            'title'     =>  'Agreement',
            'url'       =>  '/agreement',
            'translate' =>  'AGREEMENT',
            'isAuthenticated'    =>  'false'
        ],
        [
            'title'     =>  'Help',
            'url'       =>  '/help',
            'translate' =>  'HELP',
            'isAuthenticated'    =>  'false'

        ],
        [
            'title'     =>  'Contacts',
            'url'       =>  '/contacts',
            'translate' =>  'CONTACTS',
            'isAuthenticated'    =>  'false'
        ],
        [
            'title'     =>  'About',
            'url'       =>  '/about',
            'translate' =>  'ABOUT',
            'isAuthenticated'    =>  'false'

        ],
        [
            'title'     =>  'Sign In',
            'url'       =>  '#',
            'translate' =>  'SIGN IN',
            'onclick'   =>  'openSplash()',
            'isAuthenticated'    =>  'false'

        ],
        [
            'title'     =>  'My Account',
            'url'       =>  '/account',
            'translate' =>  'ACCOUNT',
            'isAuthenticated'    =>  'true'
        ],
        [
            'title'     =>  'Bought',
            'url'       =>  '/transactions/bought',
            'translate' =>  'BOUGHT',
            'isAuthenticated'    =>  'true'
        ],
        [
            'title'     =>  'Observations',
            'url'       =>  '/transactions/observations',
            'translate' =>  'OBSERVATIONS',
            'isAuthenticated'    =>  'true'
        ],
        [
            'title'     =>  'Parlays',
            'url'       =>  '/transactions/parlays',
            'translate' =>  'PARLAYS',
            'isAuthenticated'    =>  'true'
        ],
        [
            'title'     =>  'Sell',
            'url'       =>  '/transactions/sell',
            'translate' =>  'SELL',
            'isAuthenticated'    =>  'true'
        ],
        [
            'title'     =>  'Sold Out',
            'url'       =>  '/transactions/sold',
            'translate' =>  'SOLD_OUT',
            'isAuthenticated'    =>  'true'
        ],
        [
            'title'     =>  'Logout',
            'url'       =>  '#',
            'translate' =>  'LOGOUT',
            'onclick'   =>  'logout()',
            'controller'=>  'SignCtrl',
            'isAuthenticated'    =>  'true'
        ],
    ],

];