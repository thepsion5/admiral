<?php
namespace Thepsion5\Admiral\Testing\Stubs;

use Thepsion5\Admiral\Container\ContainerInterface;

class StubContainer implements ContainerInterface
{
    /**
     * @var array
     */
    public $classes = [];

    public function make($class, array $params = array())
    {
        if(class_exists($class)) {
            $this->classes[$class] = new $class($params);
            $class = $this->classes[$class];
        } else {
            $class = null;
        }
        return $class;
    }

    public function bind($abstract, $concrete)
    {
        throw new \LogicException('Not implemented in stub class.');
    }

    public function bindSingleton($abstract, $concrete)
    {
        throw new \LogicException('Not implemented in stub class.');
    }

    public function canBeInstantiated($abstract)
    {
        return class_exists($abstract);
    }
}
