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

    /**
     * Returns an instance of the specified class
     *
     * @param string $class  The name of the class to return
     * @param array  $params Any parameters used to construct the class
     * @throws ContainerResolutionException
     * @return mixed
     */
    public function make($class, array $params = array())
    {
        try {
            return $this->container->make($class, $params);
        } catch(BindingResolutionException $e) {
            throw new ContainerResolutionException("Unable to correctly resolve [$class].", 0, $e);
        }
    }

    /**
     * Registers a binding with the container in the form of a closure or class path
     *
     * @param string          $abstract
     * @param \Closure|string $concrete
     * @return mixed
     */
    public function bind($abstract, $concrete)
    {
        $this->container->bind($abstract, $concrete);
    }

    /**
     * Registers a singleton binding with the container in the form of a closure or class path
     * When self::make($abstract) is called for this binding, it will always return the same
     * instance
     *
     * @param $abstract
     * @param $singleton
     * @return mixed
     */
    public function bindSingleton($abstract, $singleton)
    {
        $this->container->singleton($abstract, $singleton);
    }

    /**
     * Returns true if the container can resolve the specified class, false otherwise
     *
     * @param string $abstract
     * @return bool
     */
    public function canBeInstantiated($abstract)
    {
        return class_exists($abstract) || $this->container->bound($abstract);
    }
}
