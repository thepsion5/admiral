<?php
namespace Thepsion5\Admiral\Testing;

use Thepsion5\Admiral\Resolver\DefaultCommandHandlerResolver,
    Thepsion5\Admiral\Testing\Stubs\StubCommand,
    Thepsion5\Admiral\Testing\Stubs\StubContainer;

class CommandHandlerResolverTest extends TestCase
{
    /**
     * @var StubCommand
     */
    protected $command;

    /**
     * @var DefaultCommandHandlerResolver
     */
    protected $resolver;

    public function setUp()
    {
        $this->command = new StubCommand;
        $this->resolver = new DefaultCommandHandlerResolver(new StubContainer);
    }

    /** @test */
    public function it_resolves_an_unregistered_handler_from_command_object_class_name()
    {
        $handler = $this->resolver->toHandler($this->command);
        $this->assertInstanceOf('Thepsion5\\Admiral\\Testing\\Stubs\\StubCommandHandler', $handler);
    }

    /** @test */
    public function it_resolves_a_registered_handler_from_the_registered_class_name()
    {
        $this->resolver->registerHandler(
            'Thepsion5\\Admiral\\Testing\\Stubs\\StubCommand',
            'Thepsion5\\Admiral\\Testing\\Stubs\\OtherStubCommandHandler'
        );

        $handler = $this->resolver->toHandler($this->command);
        $this->assertInstanceOf('Thepsion5\\Admiral\\Testing\\Stubs\\OtherStubCommandHandler', $handler);;
    }
}
