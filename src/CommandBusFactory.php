<?php
namespace Thepsion5\Admiral;

use Illuminate\Container\Container,
    Thepsion5\Admiral\Container\ContainerInterface,
    Thepsion5\Admiral\Resolver\DefaultCommandHandlerResolver,
    Thepsion5\Admiral\Container\IlluminateContainer;

class CommandBusFactory
{
    public static function makeCommandBus(ContainerInterface $container = null)
    {
        $container = ($container) ?: self::makeContainer();
        $resolver = new DefaultCommandHandlerResolver($container);
        return new CommandBus($resolver);
    }

    public static function makeContainer()
    {
        return new IlluminateContainer(new Container);
    }
}
