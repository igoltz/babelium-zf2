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
        $requestName,
        array $options = NULL
    )
    {
        return new HeaderAuthentication($container);
    }

    public function createService(ServiceLocatorInterface $sl)
    {
        return new HeaderAuthentication($sl);
    }

}