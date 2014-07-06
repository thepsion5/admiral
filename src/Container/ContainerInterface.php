<?php
namespace Thepsion5\Admiral\Container;

interface ContainerInterface
{
    public function make($class, array $params = array());

    public function bind($abstract, $concrete);

    public function bindSingleton($abstract, $concrete);
}
