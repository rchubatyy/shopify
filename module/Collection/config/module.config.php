<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Collection;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Db;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\CollectionController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'collection' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/view/[:id]',
                    'constraints' => [
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\CollectionController::class,
                        'action'     => 'view',
                    ],
                ],
            ],
        ],
    ],
    /*'controllers' => [
        'factories' => [
            Controller\CollectionController::class => InvokableFactory::class,
        ],
    ],*/
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'collection/collection/index' => __DIR__ . '/../view/collection/index/index.phtml',
            'collection/collection/view' => __DIR__ . '/../view/collection/index/product.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/any'               => __DIR__ . '/../view/error/shopify_error.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'modules' => [
        'Laminas\Db',
    ],
];
