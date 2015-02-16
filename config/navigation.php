<?php
/**
 * Setup navigation array
 */

$navigation = [
    'Backend' => [
        'sidebar' => [
            'class' => 'nav main-menu',
            'id' => 'nav main-menu',

            // Elements

            'childs' => [
                [
                    'name' => 'Dashboard',
                    'url' => '/dashboard',
                    //'class'      	=> 	'dropdown',
                    //'classLink'  	=> 	'ajax-link',
                    'icon' => 'fa fa-home',
                    'action' => 'index',
                    'controller' => 'dashboard',
                    'module' => 'Backend',
                ],

                [
                    'name' => 'Users',
                    'url' => '#',
                    'class' => 'dropdown',
                    'classLink' => 'dropdown-toggle',
                    'icon' => 'fa fa-users',
                    'action' => 'index',
                    'controller' => 'users',
                    'module' => 'Backend',
                    'childs' => [
                        [
                            'name' => 'Lists',
                            'url' => '/dashboard/users',
                            'icon' => 'fa fa-list',
                            'action' => 'index',
                            'controller' => 'users',
                            'module' => 'Backend'
                        ],

                        [
                            'name' => 'Roles',
                            'url' => '/dashboard/users/roles',
                            'icon' => 'fa fa-group',
                            'action' => 'roles',
                            'controller' => 'users',
                            'module' => 'Backend'
                        ],
                    ]
                ],

                [
                    'name' => 'System',
                    'url' => '#',
                    'class' => 'dropdown',
                    'classLink' => 'dropdown-toggle',
                    'icon' => 'fa fa-dashboard',
                    'action' => 'index',
                    'controller' => 'database',
                    'module' => 'Backend',
                    'childs' => [
                        [
                            'name' => 'Database',
                            'url' => '/dashboard/database',
                            'icon' => 'fa fa-database',
                            'action' => 'index',
                            'controller' => 'database',
                            'module' => 'Backend'
                        ],
                        [
                            'name' => 'Server',
                            'url' => '/dashboard/server',
                            'icon' => 'fa fa-linux',
                            'action' => 'index',
                            'controller' => 'server',
                            'module' => 'Backend'
                        ],
                        [
                            'name' => 'Cache',
                            'url' => '#',
                            'class' => 'dropdown',
                            'classLink' => 'dropdown-toggle',
                            'icon' => 'fa fa-recycle',
                            'action' => 'index',
                            'controller' => 'cache',
                            'module' => 'Backend',
                            'childs' => [
                                [
                                    'name' => '&nbsp;&nbsp;Memcache',
                                    'url' => '/dashboard/cache/storage/memcache',
                                    'icon' => 'fa fa-cube',
                                    'action' => 'storage',
                                    'controller' => 'cache',
                                    'module' => 'Backend'
                                ],

                                [
                                    'name' => '&nbsp;&nbsp;MySQL',
                                    'url' => '/dashboard/cache/storage/mysql',
                                    'icon' => 'fa fa-cube',
                                    'action' => 'storage',
                                    'controller' => 'cache',
                                    'module' => 'Backend'
                                ],

                                [
                                    'name' => '&nbsp;&nbsp;APC',
                                    'url' => '/dashboard/cache/storage/apc',
                                    'icon' => 'fa fa-cube',
                                    'action' => 'storage',
                                    'controller' => 'cache',
                                    'module' => 'Backend'
                                ],
                            ],
                        ],
                        [
                            'name' => 'Logs',
                            'url' => '/dashboard/logs',
                            'icon' => 'fa fa-list-alt',
                            'action' => 'index',
                            'controller' => 'logs',
                            'module' => 'Backend'
                        ],

                    ],
                ],

                [
                    'name' => 'Settings',
                    'url' => '#',
                    'class' => 'dropdown',
                    'classLink' => 'dropdown-toggle',
                    'icon' => 'fa fa-cog',
                    'action' => 'index',
                    'controller' => 'settings',
                    'module' => 'Backend',
                    'childs' => [

                        [
                            'name' => 'Engines',
                            'url' => '/dashboard/engines',
                            'icon' => 'fa fa-tachometer',
                            'action' => 'index',
                            'controller' => 'engines',
                            'module' => 'Backend'
                        ],

                        [
                            'name' => 'Categories',
                            'url' => '/dashboard/categories',
                            'icon' => 'fa fa-bars',
                            'action' => 'index',
                            'controller' => 'categories',
                            'module' => 'Backend'
                        ],
                        [
                            'name' => 'Pages',
                            'url' => '/dashboard/pages',
                            'icon' => 'fa fa-info-circle',
                            'action' => 'index',
                            'controller' => 'pages',
                            'module' => 'Backend'
                        ],
                    ],
                ],

            ]
        ]
    ]
];