<?php
namespace Thepsion5\Admiral\AccessControl;

use Thepsion5\Admiral\CommandInterface;

interface AccessPolicyInterface
{
    /**
     * Evaluates whether a command can be executed in the current context
     *
     * @param CommandInterface $command
     * @return mixed
     */
    public function assess(CommandInterface $command);
}
