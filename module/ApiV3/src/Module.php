<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApiV3;

use Zend\Mvc\MvcEvent;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event)
    {
        $app = $event->getApplication();
        $sm  = $app->getServiceManager();
        $em  = $app->getEventManager();

        $listener = $sm->get('ApiV3\Listener\ApiAuthenticationListener');
        $em->getSharedManager()->attach(
            '\ApiV3\Controller',
            'dispatch',
            $listener
        );

    }

}
