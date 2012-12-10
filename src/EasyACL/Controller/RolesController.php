<?php

namespace EasyACL\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RolesController extends AbstractActionController
{
    protected $Service;
    public function getService()
    {
        if (!$this->Service) {
            $this->Service=$this->getServiceLocator()->get('roles.service');
        }

        return $this->Service;

    }
    public function indexAction()
    {
        return new ViewModel(array(
            'roles'=>$this->getService()->getRoles(),
        ));
    }

    public function addAction()
    {
        $addRoles=$this->getService()->addRoles($this->getRequest());
        if ($addRoles===true) {
            return $this->redirect()->toRoute('acl/roles');
        }

        return new ViewModel(array(
            'form'=>$addRoles,
        ));
    }

    public function editAction()
    {
        $id=(int) $this->getEvent()->getRouteMatch()->getParam('id');
        $editRoles=$this->getService()->editRoles($this->getRequest(), $id);
        if ($editRoles===true) {
            return $this->redirect()->toRoute('acl/roles');
        }

        return new ViewModel(array(
            'form'=>$editRoles,
            'id'=>$id,
        ));
    }

    public function removeAction()
    {
        $id=(int) $this->getEvent()->getRouteMatch()->getParam('id');
        $this->getService()->removeRoles($id);

        return $this->redirect()->toRoute('acl/roles');
    }

    public function rightsAction()
    {
        $id=(int) $this->getEvent()->getRouteMatch()->getParam('id');
        $editPermissions=$this->getService()->editPermissions($this->getRequest(), $id);
        if ($editPermissions===true) {
            return $this->redirect()->toRoute('acl/roles');
        }

        return new ViewModel(array(
            'form'=>$editPermissions,
            'id'=>$id,
        ));
    }

}
