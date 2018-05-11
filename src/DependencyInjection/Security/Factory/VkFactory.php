<?php

namespace App\DependencyInjection\Security\Factory;

use App\Security\Authentication\Provider\VkProvider;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class VkFactory implements SecurityFactoryInterface
{

    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        //связываем в единый firewall наши listener и provider.
        $providerId = 'security.authentication.provider.vk.' . $id;
        $container
            ->setDefinition($providerId, new ChildDefinition(VkProvider::class))
//                ->replaceArgument(0, new Reference($userProvider))
        ;

        $container
            ->setAlias('Symfony\Component\Security\Core\User\UserProviderInterface', $userProvider)
        ;

        $listenerId = 'security.authentication.listener.vk.' . $id;
        $listener = $container->setDefinition($listenerId, new ChildDefinition(VkProvider::class));

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'vk';
    }

    public function addConfiguration(NodeDefinition $builder) {}
}