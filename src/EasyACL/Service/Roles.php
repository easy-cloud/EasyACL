<?php
namespace EasyACL\Service;

use Zend\ServiceManager,
    ACL\Form\RolesForm,
    ACL\Form\PermissionsForm;

class Roles extends AbstractACLService
{

    protected $userService;

    protected $groupService;

    protected $permissionService;

    public function getPermissionService()
    {
        if (!$this->permissionService) {
            $this->permissionService=$this->getServiceLocator()->get('permission.service');
        }

        return $this->permissionService;
    }

    public function getUserService()
    {
        if (!$this->userService) {
            $this->userService=$this->getServiceLocator()->get('user.service');
        }

        return $this->userService;
    }

    public function getGroupService()
    {
        if (!$this->groupService) {
            $this->groupService=$this->getServiceLocator()->get('group.service');
        }

        return $this->groupService;
    }

    public function getRoles($id=null)
    {
        if (!$id) {
            return $this->getRepository()->findAll();
        } else {
            return $this->getRepository()->find($id);
        }
    }

    public function getPermissionsArray($roles)
    {
        $result=array();
        foreach ($roles->permissions as $permission) {
            $result[]=$permission->id;
        }

        return $result;
    }

    public function addRoles($request=null)
    {
        $em = $this->getEntityManager();
        $roles = new \ACL\Entity\Roles();
        $form = new RolesForm($em);
        $form->get('submit')->setAttribute('value', 'Add');
        $form->get('user_id')->setValueOptions(array_merge(array(0=>'None'),$form->get('user_id')->getValueOptions()));
        $form->get('group_id')->setValueOptions(array_merge(array(0=>'None'),$form->get('group_id')->getValueOptions()));
        if ($request!==null) {
            if ($request->isPost()) {
                $post=$request->getPost();
                $form->setInputFilter($roles->getInputFilter());
                $form->setData($post);
                if ($form->isValid()) {
                    $data=$form->getData();
                    $data['group_id']=null;
                    $data['user_id']=null;
                    $roles->exchangeArray($data);
                    if ($post['group_id']) {
                        $roles->setGroup($this->getGroupService()->getGroup($post['group_id']));
                    }
                    if ($post['user_id']) {
                        $roles->setUser($this->getUserService()->getUser($post['user_id']));
                    }
                    $em->persist($roles);
                    $em->flush();

                    return true;
                }
            }
        }

        return $form;
    }

    public function editRoles($request=null, $id)
    {
        $em = $this->getEntityManager();
        if (!$id||!is_numeric($id)) {
            return true;
        }
        $roles = $this->getRoles($id);
        $form = new RolesForm($em);
        $form->get('submit')->setAttribute('value', 'Edit');
        $form->get('user_id')->setValueOptions(array_merge(array(0=>'None'),$form->get('user_id')->getValueOptions()));
        $form->get('group_id')->setValueOptions(array_merge(array(0=>'None'),$form->get('group_id')->getValueOptions()));
        $form->bind($roles);
        if ($request!==null) {
            if ($request->isPost()) {
                $post=$request->getPost();
                $form->setInputFilter($roles->getInputFilter());
                $form->setData($post);
                if ($form->isValid()) {
                    $data=$form->getData()->getArrayCopy();
                    $data['group_id']=null;
                    $data['user_id']=null;
                    $roles->exchangeArray($data);
                    if ($post['group_id']) {
                        $roles->setGroup($this->getGroupService()->getGroup($post['group_id']));
                    }
                    if ($post['user_id']) {
                        $roles->setUser($this->getUserService()->getUser($post['user_id']));
                    }
                    $em->persist($roles);
                    $em->flush();

                    return true;
                }
            }
        }

        return $form;
    }

    public function removeRoles($id)
    {
        if (!$id||!is_numeric($id)) {
            return true;
        }
        $em=$this->getEntityManager();
        $roles = $this->getRoles($id);
        $em->remove($roles);
        $em->flush();
    }

    public function editPermissions($request=null, $id)
    {
        $em = $this->getEntityManager();
        if (!$id||!is_numeric($id)) {
            return true;
        }
        $roles = $this->getRoles($id);
        $permissions=$this->getPermissionService()->getPermissions();
        $actions=$this->getPermissionService()->getActions();
        $form = new PermissionsForm($permissions, $actions, $this->getPermissionsArray($roles));
        $form->get('submit')->setAttribute('value', 'Edit');
        $form->bind($roles);
        if ($request!==null) {
            if ($request->isPost()) {
                $post = $request->getPost();
                foreach ($this->getPermissionService()->getPermission() as $permission) {
                    if (array_key_exists($permission->id, (array) $post)) {
                        $roles->addPermission($permission);
                    } else {
                        $roles->removePermission($permission);
                    }
                }
                if (isset($post['all'])&&is_array($post['all'])) {
                    foreach ($post['all'] as $all) {
                        if ($all=="master") {
                            $result=array("master");
                        } else {
                            $explode=explode("_", $all);
                            if (isset($explode[1])) {
                                $result[$explode[0]][]=($explode[0]!=="action"&&$explode[0]!=="namespace"?$explode[0]."\\".$explode[1]:$explode[1]);
                            }
                        }
                    }
                    if (isset($result[0])&&$result[0]==="master") {
                        $roles->__set("allowed_all",array($result[0]));
                    } else {
                        $roles->__set("allowed_all", $result);
                    }
                }
                $em->persist($roles);
                $em->flush();

                return true;
            }
        }

        return $form;
    }
}
