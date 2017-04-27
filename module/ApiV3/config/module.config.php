<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApiV3;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Interop\Container\ContainerInterface;

return [
    'service_manager' => array(
        'factories' => array(
            \ApiV3\Authentication\Adapter\HeaderAuthentication::class => \ApiV3\Factory\AuthenticationAdapterFactory::class,
            \ApiV3\Listener\ApiAuthenticationListener::class => \ApiV3\Factory\AuthenticationListenerFactory::class,
            'AuthenticationService' => function(ContainerInterface $container) {
                return new \ApiV3\Services\Authentication($container);
            },
            'ConsumersService' => function(ContainerInterface $container) {
                return new \ApiV3\Services\Consumers($container);
            },
            'ExercisesService' => function(ContainerInterface $container) {
                return new \ApiV3\Services\Exercises($container);
            },
            'ResponseService' => function(ContainerInterface $container) {
                return new \ApiV3\Services\Response($container);
            },
            'SubTitlesService' => function(ContainerInterface $container) {
                return new \ApiV3\Services\SubTitles($container);
            },


        )
    ),
    'controllers' => [
        'factories' => [],
        'invokables' => array(
            'ApiV3\Controller\SubTitles' => 'ApiV3\Controller\SubTitlesController',
            'ApiV3\Controller\Exercises' => 'ApiV3\Controller\ExercisesController',
            'ApiV3\Controller\Response' => 'ApiV3\Controller\ResponseController'
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
            /**
             * Sub-titles
             */
            'subtitles' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/sub-titles[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+(\.vtt)?',
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => Controller\SubTitlesController::class
                    )
                ]
            ],
            /**
             * Exercises
             */
            'exercises' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/exercises[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => Controller\ExercisesController::class
                    )
                ]
            ],
            /**
             * Response
             */
            'response' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/response[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => Controller\ResponseController::class
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
                    'dbname'   => 'babelium_data_new',
                    'charset'  => 'utf8mb4'
                )
            )
        )
    )
];
