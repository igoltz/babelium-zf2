<?php

namespace ApiV3\Listener;

use ApiV3\Authentication\Adapter\HeaderAuthentication;
use Zend\Mvc\MvcEvent;

class ApiAuthenticationListener
{

    protected $adapter;
    protected $doctrine;

    public function __construct(
        HeaderAuthentication $adapter,
        $response,
        $doctrine
    )
    {

        $this->adapter = $adapter;
        $this->doctrine= $doctrine;

        $result = $this->adapter->authenticate();

        if (!$result->isValid()) {

            $result = array(
                'code' => $result->getCode(),
                'messages' => $result->getMessages()
            );

            $headers = new \Zend\Http\Headers();
            $headers->addHeaderLine(
                'Content-Type:application/json; charset=utf-8'
            );

            $response->setHeaders($headers);
            $response->setStatusCode(401);
            $response->setContent(\Zend\Json\Json::encode($result));
            $response->send();
            die();
        }

    }

    public function __invoke(MvcEvent $event)
    {

        $result = $this->adapter->authenticate();

        if (!$result->isValid()) {
            $response = $event->getResponse();
            $response->setStatusCode(401);
            return $response;
        }

        $event->setParam('user', $result->getIdentity());

    }

}