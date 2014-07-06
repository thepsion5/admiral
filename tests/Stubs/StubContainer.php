<?php
namespace Thepsion5\Admiral\Testing\Stubs;

use Thepsion5\Admiral\Container\ContainerInterface;

class StubContainer implements ContainerInterface
{
    public function make($class, array $params = array())
    {
        return new $class($params);
    }

    public function bind($abstract, $concrete)
    {
        throw new \LogicException('Not implemented in stub class.');
    }

    public function bindSingleton($abstract, $concrete)
    {
        throw new \LogicException('Not implemented in stub class.');
    }
}
