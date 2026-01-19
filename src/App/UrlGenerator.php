<?php

namespace App;

class UrlGenerator
{
    public function __construct(
        protected array $routes,
        protected string $baseUrl = '',
    )
    {
    }
    public function generatePath(string $name, array $params = []): string
    {
        if (!isset($this->routes[$name])) {
            throw new \Exception("Route $name not found");
        }
        preg_match_all('/\{(\w+)\}/', $this->routes[$name]['path'], $matches);
        $paramNames = $matches[1];
        $path = $this->routes[$name]['path'];
        foreach ($paramNames as $paramName) {
            if (!array_key_exists($paramName, $params)) {
                throw new \Exception("Missing parameter '{$paramName}'");
            }
            $path = str_replace('{' . $paramName . '}', $params[$paramName], $path);
            unset($params[$paramName]);
        }
        $url = $path;
        //$url = trim($path,'/');
        $queryStrings = [];
        foreach ($params as $key => $value) {
            $queryStrings[] = "{$key}={$value}";
        }

        if($queryStrings) $url .= '?' . implode('&', $queryStrings);
        return $this->baseUrl.''.$url;
    }
}
