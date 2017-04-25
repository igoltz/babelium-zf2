<?php

namespace ApiV3\Factory;

use ApiV3\Listener\ApiAuthenticationListener;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Interop\Container\ContainerInterface;

class AuthenticationListenerFactory
    implements FactoryInterface
{

    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = NULL
    )
    {

        $adapter = $container->get('ApiV3\Authentication\Adapter\HeaderAuthentication');
        $doctrine = $container->get('Doctrine\ORM\EntityManager');
        $response = $container->get('Response');

        $listener = new ApiAuthenticationListener($adapter, $response, $doctrine);
        return $listener;

    }

    public function createService(ServiceLocatorInterface $sl)
    {

        $adapter = $sl->get('ApiV3\Authentication\Adapter\HeaderAuthentication');
        $doctrine = $sl->get('Doctrine\ORM\EntityManager');
        $response = $sl->get('Response');

        $listener = new ApiAuthenticationListener($adapter, $response, $doctrine);
        return $listener;

    }

}