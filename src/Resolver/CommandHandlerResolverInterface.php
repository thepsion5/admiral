<?php
namespace Thepsion5\Admiral\Resolver;

use Thepsion5\Admiral\CommandInterface;

interface CommandHandlerResolverInterface
{
    /**
     * Translates an instance of a command into a command handler
     *
     * @param CommandInterface $command
     * @return \Thepsion5\Admiral\CommandHandlerInterface
     */
    public function toHandler(CommandInterface $command);

    /**
     * Registers a handler class for a specific command
     *
     * @param string $commandClass The full class path of the command
     * @param string $handlerClass The full class path of the command handler
     */
    public function registerHandler($commandClass, $handlerClass);
}
