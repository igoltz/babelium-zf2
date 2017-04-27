<?php

namespace ApiV3\Authentication\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Http\Request;

class HeaderAuthentication
    implements AdapterInterface
{

    /**
     * @var \Zend\Http\Request
     */
    protected $_request;

    /**
     * @var \Zend\Http\Response
     */
    protected $_response;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_doctrine;

    /**
     * @var \ApiV3\Services\Authentication
     */
    protected $_authService;

    /**
     * @var \ApiV3\Services\Consumers
     */
    protected $_consService;

    public function __construct(
        $container
    )
    {

        $this->_request = $container->get('Request');
        $this->_response = $container->get('Response');
        $this->_doctrine = $container->get('Doctrine\ORM\EntityManager');
        $this->_authService = $container->get('AuthenticationService');
        $this->_consService = $container->get('ConsumersService');

        return $this;

    }

    public function authenticate()
    {

        $headers = $this->_request->getHeaders();

        $path = $this->_request->getUri()->getPath();
        $isSubtitleVTT = $this->_authService->isSubtitleVTT($path);
        if ($isSubtitleVTT) {
            return new Result(Result::SUCCESS, array());
        }

        if (!$this->_authService->validHeaders($headers)) {
            return new Result(
                Result::FAILURE,
                null,
                array('Authorization header missing')
            );
        }

        $consumer = $this->_consService->getConsumerByHeaders($headers);
        if ($consumer === false) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                array('Invalid credentials')
            );
        }

        $subscriptionValid = $this->_authService->subscriptionValid(
            $consumer['subscriptionstart'],
            $consumer['subscriptionend']
        );
        if ($subscriptionValid !== true) {
            return new Result(Result::FAILURE, null, array($subscriptionValid));
        }

        $ipAddressValid = $this->_authService->ipAddressValid($consumer);
        if (!$ipAddressValid) {
            return new Result(
                Result::FAILURE,
                null,
                array('Unauthorized IP address')
            );
        }

        return new Result(Result::SUCCESS, $consumer);

    }

}