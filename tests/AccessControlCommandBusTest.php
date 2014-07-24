<?php
namespace Thepsion5\Admiral\Testing;

use Thepsion5\Admiral\AccessControl\DefaultAccessPolicyResolver;
use Thepsion5\Admiral\CommandBusFactory;
use Thepsion5\Admiral\Testing\Stubs\StubCommand;
use Thepsion5\Admiral\Testing\Stubs\StubCommandResolver;
use Thepsion5\Admiral\Testing\Stubs\StubContainer;

/**
 * @group A
 */
class AccessControlCommandBusTest extends TestCase
{

    /**
     * @var \Thepsion5\Admiral\Testing\Stubs\StubContainer
     */
    protected $container;

    /**
     * @var \Thepsion5\Admiral\AccessControlCommandBus
     */
    protected $bus;

    public function setUp()
    {
        $this->container = new StubContainer;
        $this->bus = CommandBusFactory::makeAccessControlCommandBus($this->container);
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
    /**
     * @test
     */
    public function it_resolves_an_access_policy_and_calls_assess_on_it()
    {
        $this->bus->execute(new StubCommand);
        $policy = $this->container->classes['Thepsion5\\Admiral\\Testing\\Stubs\\StubAccessPolicy'];

        $this->assertNotNull($policy);
        $this->assertContains('Thepsion5\\Admiral\\Testing\\Stubs\\StubCommand', $policy->assessed);
    }

    /**
     * @test
     */
    public function it_sets_and_retrieves_the_access_control_policy_resolver()
    {
        $resolver = new DefaultAccessPolicyResolver(new StubContainer);
        $this->bus->setPolicyResolver($resolver);

        $setResolver = $this->bus->getPolicyResolver();

        $this->assertEquals($resolver, $setResolver);
    }
}
