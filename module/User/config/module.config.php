<?php

namespace User;

return array(
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action

          'zfcuser' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/member',
                    'defaults' => array(
                        'controller' => 'zfcuser',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'login',
                            ),
                        ),
                    ),
            )),
            'zfcuser-register' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/register',
                    'defaults' => array(
                        'controller' => 'zfcuser',
                        'action'     => 'register',
                    ),
                ),
            ),
             'zfcuser-authenticate' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/authenticate',
                    'defaults' => array(
                        'controller' => 'zfcuser',
                        'action' => 'authenticate',
                    ),
                ),
            ),
            'zfcuser-logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'zfcuser',
                        'action'     => 'logout',
                    ),
                ),
            ),
            'zfcuser-changepassword' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/change-password',
                    'defaults' => array(
                        'controller' => 'zfcuser',
                        'action'     => 'changepassword',
                    ),
                ),                        
            ),
            'zfcuser-changeemail' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/change-email',
                    'defaults' => array(
                        'controller' => 'zfcuser',
                        'action' => 'changeemail',
                    ),
                ),                        
            ),
            'user_login' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/test',
                    'defaults' => array(
                        'controller'    => 'UserController',
                        'action'        => 'index',
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
            'UserController' => Controller\IndexController::class
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'layout'                   => 'layout/user',
        'template_map' => array(
            'layout/user'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'             => __DIR__ . '/../view/error/404.phtml',
            'error/index'           => __DIR__ . '/../view/error/index.phtml',
        ),
         // The following adds an entry pointing to the view directory
         // of the current module. Make sure your keys differ between modules
         // to ensure that they are not overwritten -- or simply omit the key!
         'template_path_stack' => array(
             'user' => __DIR__ . '/../view', // on met le nom du module qui permettra d'override les templae des zfc-user
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
    'zfcuser' => array(
            // telling ZfcUser to use our own class
            'user_entity_class'       => 'User\Entity\MyUser',
            // telling ZfcUserDoctrineORM to skip the entities it defines
            'enable_default_entities' => false,
            'enable_registration' => false,
            'login_redirect_route' => 'dashboard',
            'logout_redirect_route' => 'zfcuser/login',
    ),

);
