<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Admin\Form\Fieldset\CategoryFieldset;
use Admin\Form\Fieldset\PostCreateFieldset;
use Admin\Form\Fieldset\PostFilterFieldset;
use Admin\Form\Fieldset\CommentFieldset;

class Module implements FormElementProviderInterface
{

    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'CategoryFieldset' => function($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $em = $serviceLocator->get('Doctrine\ORM\EntityManager');
                    $fieldset = new CategoryFieldset($em);
                    return $fieldset;
                },
                'PostCreateFieldset' => function($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $em = $serviceLocator->get('Doctrine\ORM\EntityManager');
                    $fieldset = new PostCreateFieldset($em);
                    return $fieldset;
                },

                'PostFilterFieldset' => function($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $em = $serviceLocator->get('Doctrine\ORM\EntityManager');
                    $fieldset = new PostFilterFieldset($em);
                    return $fieldset;
                },
                'CommentFieldset' => function($sm) {
                    // die('ok');
                    $serviceLocator = $sm->getServiceLocator();
                    $em = $serviceLocator->get('Doctrine\ORM\EntityManager');
                    $fieldset = new CommentFieldset($em);
                    return $fieldset;
                }
            )
        );
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
