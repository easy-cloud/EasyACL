<?php

namespace ACL\Service;
use Zend\ServiceManager;
use ACL\Form\GroupForm;

class Group extends AbstractACLService
{
    public function getGroup($id=null)
    {
        if(!$id){
            return $this->getRepository()->findAll();    
        }else{
            return $this->getRepository()->find($id);
        }
    }

    public function addGroup($request=null)
    {
        $em = $this->getEntityManager();
        $group = new \ACL\Entity\Group();
        $form = new GroupForm();
        $form->get('submit')->setAttribute('value', 'Add');
        if($request!==null){
            if ($request->isPost()){
                $post=$request->getPost();
                $form->setInputFilter($group->getInputFilter());
                $form->setData($post);
                if ($form->isValid()){
                    $group->exchangeArray($form->getData());
                    $em->persist($group);
                    $em->flush();
                    return true;
                }
            }
        }
        return $form;
    }

    public function editGroup($request=null, $id)
    {
        $em = $this->getEntityManager();
        if(!$id||!is_numeric($id))
        {
            return true;
        }
        $group = $this->getGroup($id);
        $form = new GroupForm();
        $form->get('submit')->setAttribute('value', 'Edit');
        $form->bind($group);
        if($request!==null){
            if ($request->isPost()){
                $post=$request->getPost();
                $form->setInputFilter($group->getInputFilter());
                $form->setData($post);
                if ($form->isValid()){
                    $group->exchangeArray($form->getData());
                    $em->merge($group);
                    $em->flush();

                    return true;
                }
            }
        }
        return $form;
    }

    public function removeGroup($id)
    {
        if(!$id||!is_numeric($id))
        {
            return true;
        }
        $em=$this->getEntityManager();
        $group = $this->getGroup($id);
        $em->remove($group);
        $em->flush();
    }
}
