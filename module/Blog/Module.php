<?php
namespace Blog;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;

class Module
{
    public function onBootstrap(EventInterface $e) {
      $application = $e->getApplication();
      $eventManager = $application->getEventManager();
      $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this,'onDispatchError'), 100);    
    }
 
    public function onDispatchError(MvcEvent $e) {
      $viewModel = $e->getViewModel();
      $viewModel->setTemplate('layout/layout-error');
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
