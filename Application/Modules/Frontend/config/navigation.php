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
            'url'       =>  '/page/agreement',
            'translate' =>  'AGREEMENT',
            'isAuthenticated'    =>  'false'
        ],
        [
            'title'     =>  'Help',
            'url'       =>  '/page/help',
            'translate' =>  'HELP',
            'isAuthenticated'    =>  'false'

        ],
        [
            'title'     =>  'Contacts',
            'url'       =>  '/page/contacts',
            'translate' =>  'CONTACTS',
            'isAuthenticated'    =>  'false'
        ],
        [
            'title'     =>  'About',
            'url'       =>  '/page/about',
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
            'title'     =>  'My Purchases',
            'url'       =>  '/transactions/purchases',
            'translate' =>  'PURCHASES',
            'isAuthenticated'    =>  'true'
        ],
        [
            'title'     =>  'My Observations',
            'url'       =>  '/transactions/observations',
            'translate' =>  'OBSERVATIONS',
            'isAuthenticated'    =>  'true'
        ],
        [
            'title'     =>  'My Bets',
            'url'       =>  '/transactions/bets',
            'translate' =>  'BETS',
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