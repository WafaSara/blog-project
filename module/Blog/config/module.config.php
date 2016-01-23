<?php

namespace Blog;

return array(
    'router' => array(
      'routes' => array(
      'blog' => array(
          'type' => 'literal',
              'options' => array(
                      'route' => '/blog',
                      'defaults' => array(
                      'controller' => 'blog-index',
                      'action' => 'index',
                  ),
              ),
          ),
      ),
    ),

    'controllers' => array(
      'invokables' => array(
          'blog-index' => 'Blog\Controller\IndexController'
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
            'blog/index/index'        => __DIR__ . '/../view/blog/index/index.phtml',
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
