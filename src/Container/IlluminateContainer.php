<?php
namespace Thepsion5\Admiral\Container;

use Illuminate\Container\BindingResolutionException,
    Illuminate\Container\Container;

class IlluminateContainer implements ContainerInterface
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function make($class, array $params = array())
    {
        try {
            return $this->container->make($class, $params);
        } catch(BindingResolutionException $e) {
            throw new ContainerResolutionException("Unable to correctly resolve [$class].", 0, $e);
        }
    }

    public function bind($abstract, $concrete)
    {
        $this->container->bind($abstract, $concrete);
    }

    public function bindSingleton($abstract, $singleton)
    {
        $this->container->singleton($abstract, $singleton);
    }

}
