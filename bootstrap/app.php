<?php

use App\Application;
use App\UrlGenerator;

require_once __DIR__ . '/../vendor/autoload.php';

function app(?string $resource = null): mixed{
    static $app = null;
    if(!$app){
        $app = new Application(__DIR__.'/../config');
        $app->withContainer();
        $app->withRoutes();
    }
    return $resource ? $app->getContainer()->get($resource) : $app;
}
function urlGenerator(): UrlGenerator{
    return app(UrlGenerator::class);
}