<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
'bjyauthorize' => array(
       'default_role' => 'guest',
       // Using the authentication identity provider, which basically reads the roles from the auth service's identity
       'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',

       'role_providers'        => array(
           // using an object repository (entity repository) to load all roles into our ACL
           'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
               'object_manager'    => 'doctrine.entitymanager.orm_default',
               'role_entity_class' => 'User\Entity\Role',
            ),
       ),
       'guards' => array(
           'BjyAuthorize\Guard\Route' => array(
               // array('route' => 'dashboard', 'roles' => array('super-admin')),
                array('route' => 'home', 'roles' => array('administrator', 'user', 'guest')),
                array('route' => 'contact', 'roles' => array('administrator', 'user', 'guest')),
                array('route' => 'show_post', 'roles' => array('administrator', 'user', 'guest')),
                array('route' => 'show_category', 'roles' => array('administrator', 'user', 'guest')),

                array('route' => 'dashboard', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_list_category', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_edit_category', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_delete_category', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_new_category', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_list_post', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_edit_post', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_delete_post', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_new_post', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_post_delete_groups', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_list_comment', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_edit_comment', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_delete_comment', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_new_comment', 'roles' => array('administrator', 'user')),
                array('route' => 'admin_comment_delete_groups', 'roles' => array('administrator', 'user')),

                // array('route' => 'zfcuser-logout', 'roles' => array('user', 'administrator')),
                array('route' => 'zfcuser-authenticate', 'roles' => array( 'guest', 'user', 'administrator')),
                // array('route' => 'zfcuser-register', 'roles' => array('guest', 'user', 'administrator')),
                array('route' => 'zfcuser', 'roles' => array('guest', 'user', 'administrator')),
                array('route' => 'zfcuser/login', 'roles' => array('guest', 'user', 'administrator')),
                array('route' => 'zfcuser/logout', 'roles' => array('guest', 'user', 'administrator')),
                array('route' => 'zfcuser/register', 'roles' => array('guest', 'user', 'administrator')),
                
                array('route' => 'refresh_captcha_ajax', 'roles' => array('guest', 'user', 'administrator')),
                
                array('route' => 'generate_captcha', 'roles' => array('guest', 'user', 'administrator')),
                array('route' => 'user_login', 'roles' => array('guest', 'user', 'administrator')),
                array('route' => 'user_forgot_password', 'roles' => array('guest', 'user', 'administrator')),
                array('route' => 'user_change_password', 'roles' => array('guest', 'user', 'administrator')),
           )
       )
   ),
);
