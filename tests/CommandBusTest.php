<?php
namespace Thepsion5\Admiral\Testing;

use Thepsion5\Admiral\CommandBusFactory,
    Thepsion5\Admiral\Testing\Stubs\StubCommand,
    Thepsion5\Admiral\Testing\Stubs\StubCommandResolver;

class CommandBusTest extends TestCase
{

    /**
     * @var \Thepsion5\Admiral\CommandBus
     */
    protected $bus;

    public function setUp()
    {
        $this->bus = CommandBusFactory::makeCommandBus();
    }

    /** @test */
    public function it_resolves_a_command_to_a_handler_and_invokes_the_handle_function_on_it()
    {
        $result = $this->bus->execute(new StubCommand);
        $this->assertInstanceOf('Thepsion5\\Admiral\\Testing\\Stubs\\StubCommandHandler', $result);
    }

    /** @test */
    public function it_sets_and_retrieves_the_command_handler_resolver()
    {
        $resolver = new StubCommandResolver;
        $this->bus->setResolver($resolver);
        $this->assertTrue($resolver === $this->bus->getResolver());
    }


}
