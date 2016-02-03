<?php
namespace User;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;

class Module
{
    /*public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication ()->getEventManager ();
        $moduleRouteListener = new ModuleRouteListener ();
        $moduleRouteListener->attach ( $eventManager );
        $eventManager->attach('dispatch', array($this, 'checkLoginChangeLayout'));

    }

    public function checkLoginChangeLayout(MvcEvent $e) {
    if (! $e->getApplication ()->getServiceManager ()->get( 'zfcuser_auth_service' )->hasIdentity ()) {
        $controller = $e->getTarget ();
        $controller->layout ( 'layout/authentication.phtml' );
        }
    }*/

    /**
     * @param  ModuleManager
     * @return [type]
     */
   /* public function init(ModuleManager $moduleManager)
    {
        $moduleManager->getEventManager()->getSharedManager()->attach(__NAMESPACE__,
        'dispatch', function($e) {
            $e->getTarget()->layout('layout/user');
        });

        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach('ZfcUser', 'dispatch', function($e) {
        // This event will only be fired when an ActionController under the ZfcUser namespace is dispatched.
        $controller = $e->getTarget();
        $controller->layout('layout/user');
        }, 100);
    }
*/
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
