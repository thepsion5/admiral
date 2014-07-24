<?php
namespace Thepsion5\Admiral\AccessControl;

use Thepsion5\Admiral\CommandInterface;

interface AccessPolicyResolverInterface
{
    /**
     * Creates an Access Policy from a command, if one exists
     *
     * @param CommandInterface $command
     * @return AccessPolicyInterface|null
     */
    public function toPolicy(CommandInterface $command);

    /**
     * Registers an Access Policy class for a particular command class
     *
     * @param string $commandClass
     * @param string $policyClass
     */
    public function registerPolicy($commandClass, $policyClass);
}
