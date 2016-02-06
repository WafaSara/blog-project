<?php
namespace Blog;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\ModuleManager;

class Module
{
    public function onBootstrap(EventInterface $e) {
      $application = $e->getApplication();
      $eventManager = $application->getEventManager();
      $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this,'onDispatchError'), 100);
      $eventManager->attach('dispatch', array($this, 'loadConfiguration' ));
    }
 
    public function onDispatchError(MvcEvent $e) {
      $viewModel = $e->getViewModel();
      $viewModel->setTemplate('layout/layout-error');
    }

    public function loadConfiguration(MvcEvent $e)
    {
      $sm = $e->getApplication()->getServiceManager();
      $em = $sm->get('doctrine.entitymanager.orm_default');
      $categorys = $em->getRepository('Blog\Entity\Category')->findBy(array(),array('label' => 'ASC'));
      
      $controller = $e->getTarget();
      $controller->layout()->categorys = $categorys;
    }
     /**
     * @param  ModuleManager
     * @return [type]
     */
    public function init(ModuleManager $moduleManager)
    {
        $events = $moduleManager->getEventManager();
        $sharedEvents = $events->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            $controller = $e->getTarget();
            $controller->layout('layout/layoutFront');
        }, 100);

        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach('ZfcUser', 'dispatch', function($e) {
        // This event will only be fired when an ActionController under the ZfcUser namespace is dispatched.
        $controller = $e->getTarget();
        $controller->layout('layout/layoutFront');
        }, 100);
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
