<?php
namespace Thepsion5\Admiral\Testing\Stubs;

use Thepsion5\Admiral\AccessControl\AccessPolicyInterface;
use Thepsion5\Admiral\CommandInterface;

class StubAccessPolicy implements AccessPolicyInterface
{
    public $assessed = [];

    public function assess(CommandInterface $command)
    {
        $this->assessed[] = get_class($command);
    }
}
