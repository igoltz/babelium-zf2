<?php

namespace ApiV3\Listener;

use ApiV3\Authentication\Adapter\HeaderAuthentication;
use Zend\Mvc\MvcEvent;

class ApiAuthenticationListener
{

    /**
     * @var \ApiV3\Authentication\Adapter\HeaderAuthentication
     */
    protected $_adapter;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_doctrine;

    public function __construct(
        HeaderAuthentication $adapter,
        $response,
        $doctrine
    )
    {

        $this->_adapter = $adapter;
        $this->_doctrine= $doctrine;

        $result = $this->_adapter->authenticate();

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

        $result = $this->_adapter->authenticate();

        if (!$result->isValid()) {
            $response = $event->getResponse();
            $response->setStatusCode(401);
            return $response;
        }

        $event->setParam('user', $result->getIdentity());

    }

}