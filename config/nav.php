<?php

return [
    [
        'icon' => 'fa fa-home',
        'title' => 'Dashboard',
        'main-title' => 'Home',
        // 'list' => ['Index'],
        'route' => ['dashboard.dashboard']

    ],
    [
        'icon' => 'fa fa-th-list',
        'title' => 'Human Resources',
        'main-title' => 'Categories',
        'list' => ['Index', 'Create'],
        'route' => ['dashboard.categories.index', 'dashboard.categories.create']
    ],
    [
        'icon' => 'fa fa-cog',
        'title' => 'Setting',
        'main-title' => 'Categories',
        'list' => ['Index', 'Create'],
        'route' => ['dashboard.categories.index', 'dashboard.categories.create']
    ],
];
