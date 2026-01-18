<?php

use App\Controller\PageController;
use App\Controller\TodoController;

return [
    [
        '_controller' => [PageController::class, 'index'],
    ],
    [
        'path' => '/home',
        '_controller' => [PageController::class, 'index'],
        'name' => 'home',
    ],
    [
        'path' => '/create',
        '_controller' => [TodoController::class, 'view'],
        'name' => 'view',
    ],
    [
        'path' => '/store',
        '_controller' => [TodoController::class, 'store'],
        'name' => 'store_todo',
        'method' => 'POST',
    ]
];
