<?php
namespace Thepsion5\Admiral;

interface CommandHandlerInterface
{
    /**
     * @param \Thepsion5\Admiral\CommandInterface $command
     * @return mixed
     */
    public function handle(CommandInterface $command);
}
