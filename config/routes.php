<?php

use App\Controller\PageController;
use App\Controller\TodoController;

return [
    [
        'path' => '',
        '_controller' => [PageController::class, 'index'],
        'name' => 'home',
    ],
    [
        'path' => 'create',
        '_controller' => [TodoController::class, 'store'],
        'name' => 'view',
    ],
    [
        'path' => 'store',
        '_controller' => [TodoController::class, 'store'],
        'name' => 'store_todo',
        'method' => 'GET,POST',
    ],
    [
        'path' => 'edit/{id}',
        '_controller' => [TodoController::class, 'edit'],
        'name' => 'edit_todo',
    ],
    [
        'path' => 'update/{id}',
        '_controller' => [TodoController::class, 'edit'],
        'name' => 'update_todo',
        'method' => 'GET,POST',
    ],
    [
        'path' => 'delete/{id}',
        '_controller' => [TodoController::class, 'delete'],
        'name' => 'delete_todo',
        'method' => 'POST',
    ],
    [
        'path' => 'clone/{id}',
        '_controller' => [TodoController::class, 'clone'],
        'name' => 'clone_todo',
    ]
];
