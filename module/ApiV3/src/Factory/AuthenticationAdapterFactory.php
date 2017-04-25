<?php

namespace ApiV3\Factory;

use ApiV3\Authentication\Adapter\HeaderAuthentication;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Interop\Container\ContainerInterface;

class AuthenticationAdapterFactory
    implements FactoryInterface
{

    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = NULL
    )
    {

        $request = $container->get('Request');
        $response = $container->get('Response');
        $doctrine = $container->get('Doctrine\ORM\EntityManager');

        $adapter = new HeaderAuthentication($request, $response, $doctrine);

        return $adapter;

    }

    public function createService(ServiceLocatorInterface $sl)
    {

        $request = $sl->get('Request');
        $response = $sl->get('Response');
        $doctrine = $sl->get('Doctrine\ORM\EntityManager');

        $adapter = new HeaderAuthentication($request, $response, $doctrine);
        return $adapter;

    }
}