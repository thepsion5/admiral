<?php
namespace Thepsion5\Admiral;

use Thepsion5\Admiral\Resolver\CommandHandlerResolverInterface;

class CommandBus implements CommandBusInterface
{
    /**
     * @var CommandHandlerResolverInterface
     */
    protected $resolver;

    public function __construct(CommandHandlerResolverInterface $resolver)
    {
        $this->setResolver($resolver);
    }

    /**
     * @param CommandInterface $command
     * @return mixed
     */
    public function execute(CommandInterface $command)
    {
        $handler = $this->resolver->toHandler($command);
        return $handler->handle($command);
    }

    /**
     * @return CommandHandlerResolverInterface
     */
    public function getResolver()
    {
        return $this->resolver;
    }

    /**
     * @param CommandHandlerResolverInterface $resolver
     * @return $this
     */
    public function setResolver(CommandHandlerResolverInterface $resolver)
    {
        $this->resolver = $resolver;
        return $this;
    }

}
