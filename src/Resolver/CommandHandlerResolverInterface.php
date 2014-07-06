<?php
namespace Thepsion5\Admiral\Resolver;

use Thepsion5\Admiral\CommandInterface;

interface CommandHandlerResolverInterface
{
    /**
     * @param CommandInterface $command
     * @return \Thepsion5\Admiral\CommandHandlerInterface
     */
    public function toHandler(CommandInterface $command);

    /**
     * @param string $commandClass
     * @param string $handlerClass
     */
    public function registerHandler($commandClass, $handlerClass);
}
