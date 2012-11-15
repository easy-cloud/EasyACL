<?php

namespace ACL\Service;
use ACL\Form\UserForm;

class User extends AbstractACLService
{
    public function getUser($id=null)
    {
        if (!$id) {
            return $this->getRepository()->findAll();
        } else {
            return $this->getRepository()->find($id);
        }
    }

    public function addUser($request=null)
    {
        $em = $this->getEntityManager();
        $user = new \ACL\Entity\User();
        $form = new UserForm($em);
        $form->get('submit')->setAttribute('value', 'Add');
        $form->get('groups[]')->setValueOptions(array_merge(array(0=>'None'),$form->get('groups[]')->getValueOptions()));
        if ($request!==null) {
            if ($request->isPost()) {
                $post=$request->getPost();
                $form->setInputFilter($user->getInputFilter());
                $form->setData($post);
                if ($form->isValid()) {
                    $user->clearGroup();
                    foreach ($post['groups'] as $group) {
                        if ($group!=="0") {
                            $user->addGroup($this->getServiceLocator()->get('group.service')->getGroup($group));
                        }
                    }
                    $user->exchangeArray($form->getData());
                    $em->persist($user);
                    $em->flush();

                    return true;
                }
            }
        }

        return $form;
    }

    public function editUser($request=null, $id)
    {
        $em = $this->getEntityManager();
        if (!$id||!is_numeric($id)) {
            return true;
        }
        $user = $this->getUser($id);
        $form = new UserForm($em, $user->group);
        $form->get('submit')->setAttribute('value', 'Edit');
        $form->get('groups[]')->setValueOptions(array_merge(array(0=>'None'),$form->get('groups[]')->getValueOptions()));
        $form->bind($user);
        $form->get('password')->setValue('');
        if ($request!==null) {
            if ($request->isPost()) {
                $post=$request->getPost();
                $form->setInputFilter($user->getInputFilter());
                if (!$post['password']) {
                    $post['password']=$user->password;
                }
                $user->clearGroup();
                foreach ($post['groups'] as $group) {
                    if ($group!=="0") {
                        $user->addGroup($this->getServiceLocator()->get('group.service')->getGroup($group));
                    }
                }
                $form->setData($post);
                if ($form->isValid()) {
                    $user->exchangeArray($form->getData());
                    $em->merge($user);
                    $em->flush();

                    return true;
                }
            }
        }

        return $form;
    }

    public function removeUser($id)
    {
        if (!$id||!is_numeric($id)) {
            return true;
        }
        $em=$this->getEntityManager();
        $user = $this->getUser($id);
        $em->remove($user);
        $em->flush();
    }

    public function login($request)
    {
        $data = $request->getPost();
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $adapter = $authService->getAdapter();
        $adapter->setIdentityValue($data['email']);
        $adapter->setCredentialValue($data['password']);
        $authResult = $authService->authenticate();
        if ($authResult->isValid()) {
            $identity = $authResult->getIdentity();
            $authService->getStorage()->write($identity);
        }

        return $authResult->isValid();
    }
}
