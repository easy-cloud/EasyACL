<?php

namespace EasyACL\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ACL\Form\LoginForm;
class UserController extends AbstractActionController
{
    protected $Service;

    public function getService()
    {
        if (!$this->Service) {
            $this->Service=$this->getServiceLocator()->get('user.service');
        }

        return $this->Service;

    }
    public function indexAction()
    {
        return new ViewModel(
            array(
                'users'=>$this->getService()->getUser(),
            )
        );
    }

    public function addAction()
    {
        $addUser=$this->getService()->addUser($this->getRequest());
        if ($addUser===true) {
            return $this->redirect()->toRoute('acl/users');
        }

        return new ViewModel(
            array(
                'form'=>$addUser,
            )
        );
    }

    public function editAction()
    {
        $id=(int) $this->getEvent()->getRouteMatch()->getParam('id');
        $editUser=$this->getService()->editUser($this->getRequest(), $id);
        if ($editUser===true) {
            return $this->redirect()->toRoute('acl/users');
        }

        return new ViewModel(
            array(
                'form'=>$editUser,
                'id'=>$id,
            )
        );
    }

    public function removeAction()
    {
        $id=(int) $this->getEvent()->getRouteMatch()->getParam('id');
        $this->getService()->removeUser($id);

        return $this->redirect()->toRoute('acl/users');
    }

    public function loginAction()
    {
        // $this->layout('layout/nosession');
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if (!$authService->getIdentity()) {
            $login = new LoginForm();
            if ($this->getRequest()->isPost()) {
                $authenticate=$this->getService()->login($this->getRequest());
                if ($authenticate) {
                    return $this->redirect()->toRoute('home');
                } else {
                    return new ViewModel(
                        array(
                            'form'=>$login,
                            'error' => 'Your authentication credentials are not valid',
                        )
                    );
                }
            }

            return new ViewModel(
                array(
                    'form'=>$login,
                )
            );
        } else {
            return new ViewModel(
                array(
                    'error'=>"You are already logged in. <a href=".$this->url()->fromRoute('acl/logout').">Click here to logout</a>"
                )
            );
        }
    }

    public function logoutAction()
    {
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->clearIdentity();

        return $this->redirect()->toRoute('home');
    }
}
