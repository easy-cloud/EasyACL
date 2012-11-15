<?php

namespace ACL\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Permission extends AbstractPlugin
{
    protected $Service;
    public function getService($sm)
    {
        if (!$this->Service) {
            $this->Service=$sm->get('permission.service');
        }

        return $this->Service;

    }
    public function doAuthorization($e, $sm)
    {
        $controller = $e->getRouteMatch()->getParam('controller');
        $controllerClass = explode("\\", $controller);
        $namespace = (isset($controllerClass[2])?$controllerClass[0]:'API');
        $controller= (isset($controllerClass[2])?$controllerClass[2]:$controllerClass[0]);
        $action =$e->getRouteMatch()->getParam('action');
        $action=($action?$action:'index');
        $needed=$namespace."\\".$controller."\\".$action;
        $this->getService($sm)->exists(array(
                'namespace'=>$namespace,
                'controller'=>$controller,
                'action'=>$action,
            )
        );
        if (!$this->getService($sm)->isAllowed($needed)) {
            $router = $e->getRouter();
            if ($this->getService($sm)->getUser()) {
                $url      = $router->assemble(array(), array('name' => 'norights'));
                $response = $e->getResponse();
                $response->setStatusCode(401);
                $response->getHeaders()->addHeaderLine('Location', $url);
            } elseif ($needed!=="ACL\User\login"&&$needed!=="API\login\index") {
                $url      = $router->assemble(array(), array('name' => '/acl/login'));
                $response = $e->getResponse();
                $response->setStatusCode(302);
                $response->getHeaders()->addHeaderLine('Location', $url);
            }
        }
    }
}
