<?php

namespace ACL;

use Zend\Mvc\MvcEvent,
    Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface;
class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $app          = $e->getApplication();
        $services     = $app->getServiceManager();
        $events       = $app->getEventManager();
        $this->config = $services->get('config');
        $services->setService('MvcEvent', $e);
        $app->getEventManager()->attach('route', array($this, 'checkACL'), -100);

    }

    public function checkACL($e)
    {
        $routeMatch = $e->getRouteMatch();
        if (!$routeMatch) {
            return;
        }
        $app     = $e->getApplication();
        $locator = $app->getServiceManager();
        $auth    = $locator->get('ControllerPluginManager')->get('Permission')->doAuthorization($e, $locator);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/',
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                }
            )
        );
    }

    public function getConfig()
    {
        return array_merge(array_merge(include __DIR__ . '/config/module.config.php',include __DIR__ . '/config/routes.config.php'), include __DIR__ . '/config/services.config.php');
    }
}
