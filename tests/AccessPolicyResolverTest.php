<?php
namespace Thepsion5\Admiral\Testing;

use Thepsion5\Admiral\AccessControl\DefaultAccessPolicyResolver;
use Thepsion5\Admiral\Testing\Stubs\DifferentStubCommand;
use Thepsion5\Admiral\Testing\Stubs\StubCommand;
use Thepsion5\Admiral\Testing\Stubs\StubContainer;

class AccessPolicyResolverTest extends TestCase
{
    /**
     * @var StubCommand
     */
    protected $command;

    /**
     * @var DefaultAccessPolicyResolver
     */
    protected $resolver;

    /**
     * @var StubContainer
     */
    protected $container;

    public function setUp()
    {
        $this->command = new StubCommand;
        $this->container = new StubContainer;
        $this->resolver = new DefaultAccessPolicyResolver($this->container);
    }

    /** @test */
    public function it_resolves_an_unregistered_policy_from_command_object_class_name()
    {
        $policyInstance = $this->resolver->toPolicy($this->command);

        $this->assertNotNull($policyInstance);
    }

    /** @test */
    public function it_resolves_a_registered_policy_from_the_registered_class_name()
    {
        $this->resolver->registerPolicy(
            'Thepsion5\\Admiral\\Testing\\Stubs\\StubCommand',
            'Thepsion5\\Admiral\\Testing\\Stubs\\OtherStubAccessPolicy'
        );
        $policyInstance = $this->resolver->toPolicy($this->command);

        $this->assertInstanceOf('Thepsion5\\Admiral\\Testing\\Stubs\\OtherStubAccessPolicy', $policyInstance);
    }

    /** @test */
    public function it_returns_null_if_a_policy_is_not_found()
    {
        $policyInstance = $this->resolver->toPolicy(new DifferentStubCommand);
        $this->assertNull($policyInstance);
    }
}
