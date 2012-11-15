<?php

namespace ACL\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PermissionController extends AbstractActionController
{
    protected $Service;
    public function getService()
    {
        if (!$this->Service) {
            $this->Service=$this->getServiceLocator()->get('permission.service');
        }

        return $this->Service;

    }
    public function indexAction()
    {
        return new ViewModel(array(
            'permissions'=>$this->getService()->getPermission(),
        ));
    }

    public function removeAction()
    {
        $id=(int) $this->getEvent()->getRouteMatch()->getParam('id');
        $this->getService()->removePermission($id);

        return $this->redirect()->toRoute('acl/permission');
    }

}
