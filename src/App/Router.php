<?php

namespace App;

use Capsule\Core\Container;
use Symfony\Component\HttpFoundation\Request;

class Router
{
    protected array $routes = [];
    protected array $flatRoutes = [];

    public function __construct(
        protected Container $container,
    )
    {
    }
    public function add($method, $path, $handler, $name): void
    {
        $this->routes[$method][$name] = [
            "handler" => $handler,
            "path" => $path,
        ];
    }

    public function getRoutes(): array
    {
        if ($this->flatRoutes) return $this->flatRoutes;
        foreach ($this->routes as $routes) {
            $this->flatRoutes = array_merge($this->flatRoutes, $routes);
        }
        return $this->flatRoutes;
    }

    /**
     * @throws \ReflectionException
     */
    public function dispatch(string $reqUri, string $reqMethod = 'GET'): void
    {
        $url = parse_url($reqUri, PHP_URL_PATH);
        $url = '/' . str_replace($this->container->get('baseUrl'), '', $url);

        foreach ($this->routes[$reqMethod] as $routes) {
            $pattern = preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $routes['path']);
            if (!preg_match("#^$pattern$#", $url, $matches)) continue;
            $routeParams = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            [$controllerClass, $methodName] = $routes['handler'];
            $controller = $this->container->get($controllerClass);
            $reflection = new \ReflectionMethod($controller, $methodName);
            $args = [];
            foreach ($reflection->getParameters() as $param) {
                $type = $param->getType();
                $name = $param->getName();
                if($type->getName() === 'Symfony\Component\HttpFoundation\Request'){
                    $args['request'] = Request::createFromGlobals();
                    continue;
                }
                if ($type && !$type->isBuiltin()) {
                    $args[] = $this->container->get($type->getName());
                    continue;
                }
                if (isset($routeParams[$name])) {
                    $value = $routeParams[$name];
                    if ($type && $type->isBuiltin()) {
                        if ($type->getName() === 'int') {
                            $value = (int)$value;
                        }
                    }
                    $args[] = $value;
                    continue;
                }
                if ($param->isDefaultValueAvailable()) {
                    $args[] = $param->getDefaultValue();
                    continue;
                }
                throw new \Exception("Cannot resolve parameter \$$name");
            }

            call_user_func_array([$controller, $methodName], $args);
            return;
        }
        throw new \Exception("No routes found for $url");
    }
}
