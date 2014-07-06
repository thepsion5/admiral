<?php
namespace Thepsion5\Admiral\Testing;

use Illuminate\Container\Container,
    Thepsion5\Admiral\Container\IlluminateContainer;

class IlluminateContainerTest extends TestCase
{
    /**
     * @var \Thepsion5\Admiral\Container\IlluminateContainer
     */
    protected $container;

    public function setUp()
    {
        $this->container = new IlluminateContainer(new Container);
    }

    /** @test */
    public function it_binds_a_class_to_an_implementation()
    {
        $binding = 'Thepsion5\\Admiral\\CommandHandlerInterface';
        $handlerClass = 'Thepsion5\\Admiral\\Testing\\Stubs\\StubCommandHandler';
        $this->container->bind(
            $binding,
            $handlerClass
        );

        $handler = $this->container->make('Thepsion5\\Admiral\\CommandHandlerInterface');
        $this->assertInstanceOf($handlerClass, $handler);
    }

    /** @test */
    public function it_binds_a_class_to_a_singleton()
    {
        $binding = 'Thepsion5\\Admiral\\CommandHandlerInterface';
        $handlerClass = 'Thepsion5\\Admiral\\Testing\\Stubs\\StubCommandHandler';
        $this->container->bindSingleton(
            $binding,
            $handlerClass
        );

        $handler1 = $this->container->make($binding);
        $handler2 = $this->container->make($binding);

        $this->assertTrue($handler1 === $handler2);
    }

    /**
     * @test
     * @expectedException \Thepsion5\Admiral\Container\ContainerResolutionException
     */
    public function it_throws_an_exception_if_no_class_found_for_binding()
    {
        $this->container->make('Thepsion5\\Admiral\\CommandHandlerInterface');
    }
}
