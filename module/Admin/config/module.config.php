<?php

namespace Admin;

return array(
    'router' => array(
        'routes' => array(
            'dashboard' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard',
                    'defaults' => array(
                        'controller' => 'AdminDashboard',
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
            // ROUTES FOR CATEGORY
            'admin_list_category' => array(
              'type' => 'Segment',
              'options' => array(
                  'route' => '/dashboard/category[/:page][/:reset]',
                  'constraints' => array(
                    'page'     => '\d+',
                  ),
                  'defaults' => array(
                      'controller' => 'AdminCategory',
                      'action'     => 'list',
                      // 'page'       => 1
                  ),
              ),
            ),

            'admin_edit_category' => array(
              'type' => 'Segment',
              'options' => array(
                  'route' => '/dashboard/category/edit/:id',
                  'constraints' => array(
                    'id'     => '\d+',
                  ),
                  'defaults' => array(
                      'controller' => 'AdminCategory',
                      'action'     => 'edit',
                  ),
              ),
            ),

            'admin_delete_category' => array(
              'type' => 'Segment',
              'options' => array(
                  'route' => '/dashboard/category/delete/:id',
                  'constraints' => array(
                    'id'     => '\d+',
                  ),
                  'defaults' => array(
                      'controller' => 'AdminCategory',
                      'action'     => 'delete',
                  ),
              ),
            ),
           'admin_new_category' => array(
              'type' => 'Literal',
              'options' => array(
                  'route' => '/dashboard/category/new',
                  'defaults' => array(
                      'controller' => 'AdminCategory',
                      'action'     => 'new',
                  ),
              ),
          ),
          // END ROUTES FOR CATEGORY
        
          // ROUTES FOR POST
          'admin_list_post' => array(
              'type' => 'Segment',
              'options' => array(
                  'route' => '/dashboard/post[/:page][/:reset]',
                  'constraints' => array(
                    'page'     => '\d+',
                    'reset'     => '\d+',

                  ),
                  'defaults' => array(
                      'controller' => 'AdminPost',
                      'action'     => 'list',
                  ),
              ),
            ),

            'admin_edit_post' => array(
              'type' => 'Segment',
              'options' => array(
                  'route' => '/dashboard/post/edit/:id',
                  'constraints' => array(
                    'id'     => '\d+',
                  ),
                  'defaults' => array(
                      'controller' => 'AdminPost',
                      'action'     => 'edit',
                  ),
              ),
            ),

            'admin_delete_post' => array(
              'type' => 'Segment',
              'options' => array(
                  'route' => '/dashboard/post/delete/:id',
                  'constraints' => array(
                    'id'     => '\d+',
                  ),
                  'defaults' => array(
                      'controller' => 'AdminPost',
                      'action'     => 'delete',
                  ),
              ),
            ),
           'admin_new_post' => array(
              'type' => 'Literal',
              'options' => array(
                  'route' => '/dashboard/post/new',
                  'defaults' => array(
                      'controller' => 'AdminPost',
                      'action'     => 'new',
                  ),
              ),
          ),
          'admin_post_delete_groups' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/dashboard/post/delete/groups',
                'defaults' => array(
                    'controller' => 'AdminPost',
                    'action'     => 'deleteGroups',
                ),
            ),
          ),
          // END ROUTES FOR POST
          
          // ROUTES FOR COMMENT
          'admin_list_comment' => array(
              'type' => 'Segment',
              'options' => array(
                  'route' => '/dashboard/comment[/:page][/:reset]',
                  'constraints' => array(
                    'page'     => '\d+',
                    'reset'     => '\d+',

                  ),
                  'defaults' => array(
                      'controller' => 'AdminComment',
                      'action'     => 'list',
                  ),
              ),
            ),

            'admin_edit_comment' => array(
              'type' => 'Segment',
              'options' => array(
                  'route' => '/dashboard/comment/edit/:id',
                  'constraints' => array(
                    'id'     => '\d+',
                  ),
                  'defaults' => array(
                      'controller' => 'AdminComment',
                      'action'     => 'edit',
                  ),
              ),
            ),

            'admin_delete_comment' => array(
              'type' => 'Segment',
              'options' => array(
                  'route' => '/dashboard/comment/delete/:id',
                  'constraints' => array(
                    'id'     => '\d+',
                  ),
                  'defaults' => array(
                      'controller' => 'AdminComment',
                      'action'     => 'delete',
                  ),
              ),
            ),
           'admin_new_comment' => array(
              'type' => 'Literal',
              'options' => array(
                  'route' => '/dashboard/comment/new',
                  'defaults' => array(
                      'controller' => 'AdminComment',
                      'action'     => 'new',
                  ),
              ),
          ),
          'admin_comment_delete_groups' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/dashboard/comment/delete/groups',
                'defaults' => array(
                    'controller' => 'AdminComment',
                    'action'     => 'deleteGroups',
                ),
            ),
          ),
          // END ROUTES FOR COMMENT
        ),
     ),

    'controllers' => array(
        'invokables' => array(
            'AdminComment'   => Controller\AdminCommentController  ::class,
            'AdminPost'      => Controller\AdminPostController     ::class,
            'AdminCategory'  => Controller\AdminCategoryController ::class,
            'AdminDashboard' => Controller\AdminDashboardController ::class
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
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'admin/admin-category/index'    => __DIR__ . '/../view/admin/admin-category/index.phtml',
            'admin/admin-category/list'     => __DIR__ . '/../view/admin/admin-category/list.phtml',
            'admin/admin-category/edit'     => __DIR__ . '/../view/admin/admin-category/edit.phtml',
            'admin/admin-category/new'      => __DIR__ . '/../view/admin/admin-category/new.phtml',
        ),
         // The following adds an entry pointing to the view directory
         // of the current module. Make sure your keys differ between modules
         // to ensure that they are not overwritten -- or simply omit the key!
         'template_path_stack' => array(
           'admin' => __DIR__ . '/../view',
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
