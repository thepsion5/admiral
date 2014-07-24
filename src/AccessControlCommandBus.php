<?php
namespace Thepsion5\Admiral;

use Thepsion5\Admiral\AccessControl\AccessPolicyResolverInterface,
    Thepsion5\Admiral\Resolver\CommandHandlerResolverInterface;

class AccessControlCommandBus implements CommandBusInterface
{

    /**
     * @var CommandBusInterface
     */
    protected $commandBus;

    /**
     * @var AccessPolicyResolverInterface
     */
    protected $policyResolver;

    public function __construct(CommandBusInterface $commandBus, AccessPolicyResolverInterface $policyResolver)
    {
        $this->commandBus = $commandBus;
        $this->setPolicyResolver($policyResolver);
    }

    /**
     * Retrieves the Command Handler resolver
     *
     * @return \Thepsion5\Admiral\Resolver\CommandHandlerResolverInterface
     */
    public function getResolver()
    {
        return $this->commandBus->getResolver();
    }

    /**
     * Sets the command handler resolver instance
     *
     * @param \Thepsion5\Admiral\Resolver\CommandHandlerResolverInterface $resolver
     * @return $this
     */
    public function setResolver(CommandHandlerResolverInterface $resolver)
    {
        return $this->commandBus->setResolver($resolver);
    }

    /**
     * Executes a command
     *
     * @param \Thepsion5\Admiral\CommandInterface $command
     * @return mixed
     */
    public function execute(CommandInterface $command)
    {
        $policy = $this->policyResolver->toPolicy($command);
        if(!is_null($policy)) {
            $policy->assess($command);
        }
        return $this->commandBus->execute($command);
    }

    /**
     * Sets the Access Policy Resolver
     *
     * @param AccessPolicyResolverInterface $policyResolver
     * @return $this
     */
    public function setPolicyResolver(AccessPolicyResolverInterface $policyResolver)
    {
        $this->policyResolver = $policyResolver;
        return $this;
    }

    /**
     * Retrieves the Access Policy resolver
     *
     * @return AccessPolicyResolverInterface
     */
    public function getPolicyResolver()
    {
        return $this->policyResolver;
    }
}
