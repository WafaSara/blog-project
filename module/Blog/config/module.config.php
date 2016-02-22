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
          'contact' => array(
              'type' => 'Literal',
              'options' => array(
                  'route' => '/contact',
                  'defaults' => array(
                      'controller' => 'Index',
                      'action'     => 'contact',
                  ),
              ),
          ),
          'show_post' => array(
              'type' => 'Zend\Mvc\Router\Http\Segment',
              'options' => array(
                  'route' => '/post/:id',
                  'constraints' => array(
                    'id'     => '[0-9]*',
                  ),
                  'defaults' => array(
                      'controller' => 'Post',
                      'action'     => 'show',
                  ),
              ),
          ),
          'generate_captcha' => array(
              'type' => 'Zend\Mvc\Router\Http\Segment',
              'options' => array(
                  'route' => '/post/captcha/[:id]',
                  'defaults' => array(
                      'controller' => 'Post',
                      'action'     => 'generate',
                  ),
              ),
          ),
          'refresh_captcha_ajax' => array(
              'type' => 'Zend\Mvc\Router\Http\Segment',
              'options' => array(
                  'route' => '/post/refresh/captcha-ajax',
                  'defaults' => array(
                      'controller' => 'Post',
                      'action'     => 'refreshCaptchaAjax',
                  ),
              ),
          ),
              /*      'refresh_captcha_ajax' => array(
              'type' => 'Zend\Mvc\Router\Http\Segment',
              'options' => array(
                  'route' => '/post/refresh/captcha/:action',
                  'constraints' => array(
                    'action' => '\w+',
                  ),
                  'defaults' => array(
                      'controller' => 'Post',
                  ),
              ),
          ),*/
          // permet de filtrer les posts par catégories
          'show_category' => array(
              'type' => 'Zend\Mvc\Router\Http\Segment',
              'options' => array(
                  'route' => '/sport/[:slug]',
                  'constraints' => array(
                    'slug'     => '[a-zA-Z][a-zA-Z0-9_\/-]*',
                  ),
                  'defaults' => array(
                      'controller' => 'Category',
                      'action'     => 'show',
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
        'layout'                   => 'layout/layoutFront',
        'layoutError'              => 'layout/layout/layoutError',
        'blogAccueil'              => 'blog/index',

        'template_map' => array(
            'layout/layoutFront'      => __DIR__ . '/../view/layout/layout.phtml',
            'layout/layoutError'      => __DIR__ . '/../view/layout/layout-error.phtml',
            'blog/index'              => __DIR__ . '/../view/blog/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
         // The following adds an entry pointing to the view directory
         // of the current module. Make sure your keys differ between modules
         // to ensure that they are not overwritten -- or simply omit the key!
        'template_path_stack' => array(
          'blog' => __DIR__ . '/../view',
        ),
        'strategies' => array(
          'ViewJsonStrategy','Zend\View\Strategy\PhpRendererStrategy'
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
