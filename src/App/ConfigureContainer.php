<?php

namespace App;

use Capsule\Core\Container;
use League\Plates\Engine as templateEngine;
use Laminas\Db\Adapter\Adapter as DbAdapter;

class ConfigureContainer
{
    public function __construct(
        protected array $config,
        protected Container $container,
        protected Router $router,
    ){

    }
    public function register()
    {
        foreach ($this->config as $name => $config) {
            $this->container->bindValue($name, $config);
        }
        $this->container->singleton(templateEngine::class, function () {
            $engine = new templateEngine($this->container->get('baseDir').'/views');
            $engine->addData([
                'baseUrl' => $this->container->get('baseUrl'),
            ]);
            return $engine;
        });
        $this->container->singleton(dbAdapter::class, function () {
            return new DbAdapter($this->container->get('dbConfig'));
        });
        $this->container->singleton(UrlGenerator::class , function () {
            return new UrlGenerator(
                $this->router->getRoutes(),
                $this->container->get('baseUrl'),
            );
        });
    }
}