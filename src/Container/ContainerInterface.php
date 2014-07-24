<?php
namespace Thepsion5\Admiral\Container;

interface ContainerInterface
{
    /**
     * Returns an instance of the specified class
     *
     * @param string $class The name of the class to return
     * @param array $params Any parameters used to construct the class
     * @return mixed
     */
    public function make($class, array $params = array());

    /**
     * Registers a binding with the container in the form of a closure or class path
     *
     * @param string          $abstract
     * @param \Closure|string $concrete
     * @return mixed
     */
    public function bind($abstract, $concrete);

    /**
     * Registers a singleton binding with the container in the form of a closure or class path
     * When self::make($abstract) is called for this binding, it will always return the same
     * instance
     *
     * @param $abstract
     * @param $concrete
     * @return mixed
     */
    public function bindSingleton($abstract, $concrete);
}
