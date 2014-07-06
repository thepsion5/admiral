<?php
namespace Thepsion5\Admiral\Testing\Stubs;

use Thepsion5\Admiral\CommandHandlerInterface;

class StubCommandHandler implements CommandHandlerInterface
{
    public $handled = array();

    public function handle($command)
    {
        $handled[] = get_class($command);
        return $this;
    }
}
