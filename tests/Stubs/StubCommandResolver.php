<?php
namespace Thepsion5\Admiral\Testing\Stubs;

use Thepsion5\Admiral\CommandInterface;
use Thepsion5\Admiral\Resolver\CommandHandlerResolverInterface;

class StubCommandResolver implements CommandHandlerResolverInterface
{

    public $handlers = array();

    /**
     * @param CommandInterface $command
     * @return \Thepsion5\Admiral\CommandHandlerInterface
     */
    public function toHandler(CommandInterface $command)
    {
        return new StubCommandResolver;
    }

    /**
     * @param string $commandClass
     * @param string $handlerClass
     */
    public function registerHandler($commandClass, $handlerClass)
    {
        $this->handlers[$commandClass] = $handlerClass;
    }
}
