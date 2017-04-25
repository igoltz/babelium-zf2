<?php

namespace ApiV3\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

abstract class AbstractController
    extends AbstractRestfulController
{
    protected $eventIdentifier = 'ApiV3\Controller';
}