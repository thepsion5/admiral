<?php
namespace Thepsion5\Admiral\Testing\Stubs;

use Thepsion5\Admiral\CommandHandlerInterface,
    Thepsion5\Admiral\CommandInterface;

class StubCommandHandler implements CommandHandlerInterface
{
    public $handled = array();

    public function handle(CommandInterface $command)
    {
        $handled[] = get_class($command);
        return $this;
    }
}
