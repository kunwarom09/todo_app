<?php

namespace Capsule\Core;


class Container
{
    public array $factory = [];
    public array $instances = []; //cache for shared
    public array $shared = [];
    protected static ?Container $instance = null;
    public function __construct()
    {

    }
    public static function getInstance(): self
    {
        if(!self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }


    public function singleton(string $key, callable $value)
    {
        $this->shared[$key] = $value;
    }

    public function bindValue(string $key, mixed $value)
    {
        $this->instances[$key] = $value;
    }

    public function bind(string $key, callable $value)
    {
        $this->factory[$key] = $value;
    }

    /**
     * @throws \Exception
     */
    public function get(string $key)
    {
        if($key === self::class){
            return $this;
        }
        if(isset($this->instances[$key])) {
            return $this->instances[$key];
        }
        if(isset($this->shared[$key])) {
            $instance = $this->shared[$key]($this);
            $this->instances[$key] = $instance;
            return $this->instances[$key];
        }
        if(isset($this->factory[$key])) {
            return $this->factory[$key]($this);
        }

        if(!class_exists($key)) {
            throw new \Exception("Class {$key} not found");
        }
        return $this->resolve($key);
    }


    public function has(string $key): bool
    {
        return isset($this->instances[$key])
            || isset($this->shared[$key])
            || isset($this->factory[$key])
            || class_exists($key);
    }

    protected function createInstance($instance)
    {
        if($instance instanceof ContainerAwareInterface){
            $instance->setContainer($this);
        }

        return $instance;
    }

    protected function resolve(string $key)
    {
        if($key==='Capsule\Core\Container'){
            return $this;
        }
        $reflection = new \ReflectionClass($key);
        if(!$reflection->getConstructor()){
            return $this->createInstance($reflection->newInstance());
        }
        $args = $reflection->getConstructor()->getParameters();
        if(!$args){
            return $this->createInstance($reflection->newInstance());
        }
        $params = [];
        foreach($args as $arg){
            if($arg->getType()->isBuiltin()){
                $paramKey = $arg->getName();
                if(!$this->has($paramKey)){
                    throw new \Exception("Value {$paramKey} not found in container!");
                }
                $params[] = $this->get($paramKey);
                continue;
            }
            $instance = $this->get($arg->getType()->getName());
            $params[] = $instance;
        }

        return $this->createInstance($reflection->newInstanceArgs($params));
    }
}