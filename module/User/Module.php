<?php
namespace User;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\I18n\Translator\Translator;

use Zend\Validator\AbstractValidator;

class Module
{
    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication ()->getEventManager ();
        /*$moduleRouteListener = new ModuleRouteListener ();
        $moduleRouteListener->attach ( $eventManager );
        $eventManager->attach('dispatch', array($this, 'checkLoginChangeLayout'));*/
        $translator = new Translator();
$translator->addTranslationFile(
 'phpArray',
 'vendor/zendframework/zendframework/resources/languages/fr/Zend_Validate.php'
/* 'default',
 'fr_FR'*/
);
AbstractValidator::setDefaultTranslator(
    new \Zend\Mvc\I18n\Translator($translator)
);
        
    }

 /*   public function checkLoginChangeLayout(MvcEvent $e) {
    if (! $e->getApplication ()->getServiceManager ()->get( 'zfcuser_auth_service' )->hasIdentity ()) {
        $controller = $e->getTarget ();
        $controller->layout ( 'layout/authentication.phtml' );
        }
    }*/

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
            $controller->layout('layout/user');
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
