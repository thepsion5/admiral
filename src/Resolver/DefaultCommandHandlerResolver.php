<?php
namespace Thepsion5\Admiral\Resolver;

use Thepsion5\Admiral\CommandInterface,
    Thepsion5\Admiral\Container\ContainerInterface;

class DefaultCommandHandlerResolver implements CommandHandlerResolverInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    private $handlers = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $commandClass
     * @param string $handlerClass
     */
    public function registerHandler($commandClass, $handlerClass)
    {
        $this->handlers[$commandClass] = $handlerClass;
    }

    /**
     * @param CommandInterface $command
     * @return \Thepsion5\Admiral\CommandHandlerInterface
     */
    public function toHandler(CommandInterface $command)
    {
        $handlerClass = $this->getHandlerClass($command);
        return $this->container->make($handlerClass);
    }

    /**
     * @param CommandInterface $command
     * @return string
     */
    protected function getHandlerClass(CommandInterface $command)
    {
        $commandClass = get_class($command);
        if(isset($this->handlers[$commandClass])) {
            $handlerClass = $this->handlers[$commandClass];
        } else {
            $handlerClass = $this->convertCommandClassToHandler($commandClass);
        }$this->registerHandler($commandClass, $handlerClass);

        return $handlerClass;
    }

    /**
     * @param $commandClass
     * @return string
     */
    protected function convertCommandClassToHandler($commandClass)
    {
        $commandClassArray = explode('\\', $commandClass);
        $commandClass = array_pop($commandClassArray);
        $handlerClass = str_replace('Command', 'CommandHandler', $commandClass);
        $commandClassArray[] = $handlerClass;
        return implode('\\', $commandClassArray);
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return \Thepsion5\Admiral\Container\ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}
