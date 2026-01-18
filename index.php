<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';
app()->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
