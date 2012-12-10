<?php

namespace EasyACL\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GroupController extends AbstractActionController
{
    protected $Service;
    public function getService()
    {
        if (!$this->Service) {
            $this->Service=$this->getServiceLocator()->get('group.service');
        }

        return $this->Service;

    }
    public function indexAction()
    {
        return new ViewModel(array(
            'groups'=>$this->getService()->getGroup(),
        ));
    }

    public function addAction()
    {
        $addGroup=$this->getService()->addGroup($this->getRequest());
        if ($addGroup===true) {
            return $this->redirect()->toRoute('acl/groups');
        }

        return new ViewModel(array(
            'form'=>$addGroup,
        ));
    }

    public function editAction()
    {
        $id=(int) $this->getEvent()->getRouteMatch()->getParam('id');
        $editGroup=$this->getService()->editGroup($this->getRequest(), $id);
        if ($editGroup===true) {
            return $this->redirect()->toRoute('acl/groups');
        }

        return new ViewModel(array(
            'form'=>$editGroup,
            'id'=>$id,
        ));
    }

    public function removeAction()
    {
        $id=(int) $this->getEvent()->getRouteMatch()->getParam('id');
        $this->getService()->removeGroup($id);

        return $this->redirect()->toRoute('acl/groups');
    }

}
