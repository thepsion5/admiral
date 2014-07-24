<?php
namespace Thepsion5\Admiral\AccessControl;

use Thepsion5\Admiral\CommandInterface;
use Thepsion5\Admiral\Container\ContainerInterface;

class DefaultAccessPolicyResolver implements AccessPolicyResolverInterface
{

    /**
     * @var array
     */
    protected $policies = [];

    /**
     * @var \Thepsion5\Admiral\Container\ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param CommandInterface $command
     * @return AccessPolicyInterface|null
     */
    public function toPolicy(CommandInterface $command)
    {
        $commandClass = get_class($command);
        if(isset($this->policies[$commandClass])) {
            $policyClass = $this->policies[$commandClass];
        } else {
            $policyClass = $this->convertCommandClassToPolicy($commandClass);
            $this->registerPolicy($commandClass, $policyClass);
        }

        if($this->container->canBeInstantiated($policyClass)) {
            $policy = $this->container->make($policyClass);
        } else {
            $policy = null;
        }
        return $policy;
    }

    /**
     * @param string $commandClass
     * @return string
     */
    protected function convertCommandClassToPolicy($commandClass)
    {
        $commandClassArray = explode('\\', $commandClass);
        $commandClass = array_pop($commandClassArray);
        $policyClass = str_replace('Command', 'AccessPolicy', $commandClass);
        $commandClassArray[] = $policyClass;
        return implode('\\', $commandClassArray);
    }

    /**
     * @param string $commandClass
     * @param string $policyClass
     */
    public function registerPolicy($commandClass, $policyClass)
    {
        $this->policies[$commandClass] = $policyClass;
    }
}
