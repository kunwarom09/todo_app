<?php
namespace App;
use Capsule\Core\Container;
class Application
{
    protected array $configs;
    protected ?Router $router = null;
    protected ?Container $container = null;

    public function __construct(
        protected string $configDir
    )
    {
        $this->configs = require $this->configDir . '/env.php';
    }
    public function getContainer(): Container
    {
        if ($this->container) return $this->container;
        $this->container = new Container();
        return $this->container;
    }
    public function getRouter(): Router
    {
        if ($this->router) return $this->router;
        $this->router = new Router($this->getContainer());
        return $this->router;
    }
    public function withContainer(): static
    {
        $configureContainer = new ConfigureContainer($this->configs,
            $this->getContainer(),
            $this->getRouter()
        );
        $configureContainer->register();

        return $this;
    }

    public function withRoutes(): static
    {
        $routes = require $this->configDir . '/routes.php';
        foreach ($routes as $route) {
            $this->getRouter()->add(
                method: $route['method'] ?? "GET",
                path: $route['path'] ?? '/',
                handler: $route['_controller'],
                name: $route['name'] ?? ''
            );
        }
        return $this;
    }
    public function handleRequest(string $uri, string $method = 'GET'): void
    {
        $this->getRouter()->dispatch($uri, $method);
    }
}