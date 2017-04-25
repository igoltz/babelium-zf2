<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApiV3;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => array(
        'factories' => array(
            \ApiV3\Authentication\Adapter\HeaderAuthentication::class => \ApiV3\Factory\AuthenticationAdapterFactory::class,
            \ApiV3\Listener\ApiAuthenticationListener::class => \ApiV3\Factory\AuthenticationListenerFactory::class
        )
    ),
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\SubTitlesController::class => InvokableFactory::class
        ],
        'invokables' => array(
            'ApiV3\Controller\SubTitles' => 'ApiV3\Controller\SubTitlesController'
        )
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'subtitles' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/sub-titles[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+(\.vtt)?',
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => Controller\SubTitlesController::class,
                    )
                ]
            ]
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'api-v3/index/index'      => __DIR__ . '/../view/api-v3/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ],
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Entity')
            ),

            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'application_entities'
                )
            )
        ),
        'connection' => array(
            'orm_default' => array(
                'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => '151.80.161.84',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => 'B4b3l1umd4t4b4sE',
                    'dbname'   => 'babelium_data_new'
                )
            )
        )
    )
];
