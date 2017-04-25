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

        $em->attach(MvcEvent::EVENT_FINISH, array($this, 'onRenderError'));

    }

    public function onRenderError(MvcEvent $event)
    {
        $statusCode = $event->getResponse()->getStatusCode();
        if ($statusCode > 400) {

            $result = array(
                'code' => $statusCode,
                'messages' => $event->getResponse()->getReasonPhrase()
            );

            $headers = new \Zend\Http\Headers();
            $headers->addHeaderLine(
                'Content-Type:application/json; charset=utf-8'
            );

            $event->getResponse()->setHeaders($headers);
            $event->getResponse()->setStatusCode(401);
            $event->getResponse()->setContent(\Zend\Json\Json::encode($result));
            $event->getResponse()->send();
            die();

        }
    }

}
