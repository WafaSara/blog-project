<?php

namespace Blog;

return array(
    'router' => array(
        'routes' => array(
          'home' => array(
              'type' => 'Literal',
              'options' => array(
                  'route' => '/',
                  'defaults' => array(
                      'controller' => 'Index',
                      'action'     => 'index',
                  ),
              ),
            ),
            'dashboard' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard',
                    'defaults' => array(
                        'controller' => 'Dashboard',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
              ),
           ),
        ),
     ),

    'controllers' => array(
        'invokables' => array(
            'Comment'   => Controller\CommentController  ::class,
            'Post'      => Controller\PostController     ::class,
            'Category'  => Controller\CategoryController ::class,
            'Dashboard' => Controller\DashboardController ::class,
            'Index' => Controller\IndexController ::class
        ),
    ),

    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'layout'                   => 'layout/layout',

        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'dashboard/index'         => __DIR__ . '/../view/blog/dashboard/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
         // The following adds an entry pointing to the view directory
         // of the current module. Make sure your keys differ between modules
         // to ensure that they are not overwritten -- or simply omit the key!
         'template_path_stack' => array(
           'blog' => __DIR__ . '/../view',
          ),
     ),
    // Doctrine
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
);
