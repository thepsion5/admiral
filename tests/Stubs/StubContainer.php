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
        $this->classes[$class] = new $class($params);
        return $this->classes[$class];
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
        return true;
    }
}
