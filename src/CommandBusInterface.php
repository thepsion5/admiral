<?php
namespace Thepsion5\Admiral;

use Thepsion5\Admiral\Resolver\CommandHandlerResolverInterface;

interface CommandBusInterface
{
    /**
     * Retrieves the Command Handler resolver
     *
     * @return \Thepsion5\Admiral\Resolver\CommandHandlerResolverInterface
     */
    public function getResolver();

    /**
     * Sets the command handler resolver instance
     *
     * @param \Thepsion5\Admiral\Resolver\CommandHandlerResolverInterface $resolver
     * @return $this
     */
    public function setResolver(CommandHandlerResolverInterface $resolver);

    /**
     * Executes a command
     *
     * @param \Thepsion5\Admiral\CommandInterface $command
     * @return mixed
     */
    public function execute(CommandInterface $command);
}
