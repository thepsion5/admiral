<?php
namespace Thepsion5\Admiral;

use Thepsion5\Admiral\Resolver\CommandHandlerResolverInterface;

class CommandBus
{
    /**
     * @var CommandHandlerResolverInterface
     */
    protected $resolver;

    public function __construct(CommandHandlerResolverInterface $resolver)
    {
        $this->setResolver($resolver);
    }

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

    public function setResolver(CommandHandlerResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

}
