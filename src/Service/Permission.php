<?php

namespace ACL\Service;
use Zend\ServiceManager,
    ACL\Form\PermissionForm,
    Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Permission extends AbstractACLService
{

    protected $serviceLocator;

    protected $RolesService;

    protected function getACL()
    {
        $acl = new Acl();
        $roles=$this->getRolesService()->getRoles();
        $resources=$this->getPermission();
        foreach ($resources as $resource) {
            $action = $resource->namespace . "\\" . $resource->controller . "\\" . $resource->action;
            $controller = $resource->namespace . "\\" . $resource->controller;
            $namespace = $resource->namespace;
            if (!$acl->hasResource($namespace)) { $acl->addResource($namespace); }
            if (!$acl->hasResource($controller)) { $acl->addResource($controller, $namespace); }
            if (!$acl->hasResource($action)) { $acl->addResource($action, $controller); }
        }
        foreach ($roles as $role) {
            $acl->addRole(new Role($role->name));
            $all=$role->allowed_all;
            if (isset($all[0])&&$all[0]==="master") {
                $acl->allow($role->name);
            } elseif (isset($all['namespace'])&&is_array($all['namespace'])&&!empty($all['namespace'])) {
                foreach ($all['namespace'] as $namespace) {
                    $acl->allow($role->name, $namespace);
                }
            } else {
                if (isset($all)&&is_array($all)) {
                    foreach ($all as $key=>$permission) {
                        if ($key!=="action") {
                            $acl->allow($role->name, $permission);
                        }
                    }
                }
            }
            foreach ($role->permissions as $permission) {
                $pm = $permission->namespace . "\\" . $permission->controller . "\\" . $permission->action;
                $acl->allow($role->name, $pm);
            }
        }
        \Zend\View\Helper\Navigation\HelperAbstract::setDefaultAcl($acl);
        \Zend\View\Helper\Navigation\HelperAbstract::setDefaultRole('Guest');

        return $acl;
    }

    public function getRolesService()
    {
        if (!$this->RolesService) {
            $this->RolesService=$this->getServiceLocator()->get('roles.service');
        }

        return $this->RolesService;

    }
    public function getPermission($id=null)
    {
        if (!$id) {
            return $this->getRepository()->findAll();
        } else {
            return $this->getRepository()->find($id);
        }
    }

    public function getPermissions()
    {
        $permissions=$this->getRepository()->findAll();
        foreach ($permissions as $permission) {
            $result[$permission->namespace][$permission->controller][$permission->action]=$permission->id;
        }

        return $result;
    }

    public function getActions()
    {
        $permissions=$this->getRepository()->findAll();
        foreach ($permissions as $permission) {
            $result[$permission->action]='';
        }

        return $result;
    }

    public function exists($permission)
    {
        if (!$this->getRepository()->findOneBy($permission)) {
            return $this->addPermission($permission);
        } else {
            return $this->getRepository()->findOneBy($permission);
        }
    }

    public function addPermission($data)
    {
        $em= $this->getEntityManager();
        $permission=new \ACL\Entity\Permission();
        $permission->exchangeArray($data);
        $em->persist($permission);
        foreach ($this->getRolesService()->getRoles() as $roles) {
            $all=$roles->allowed_all;
            if (isset($all[0])&&$all[0]==="master") {
                $roles->addPermission($permission);
            } elseif (isset($all['namespace'])&&is_array($all['namespace'])) {
                if (in_array($data['namespace'],$all['namespace'])) {
                    $roles->addPermission($permission);
                }
            } elseif (isset($all[$data['namespace']])&&is_array($all[$data['namespace']])) {
                if (in_array($data['namespace']."\\".$data['controller'],$all[$data['namespace']])) {
                    $roles->addPermission($permission);
                }
            } elseif (isset($all['action'])&&is_array($all['action'])) {
                if (in_array($data['action'],$all['action'])) {
                    $roles->addPermission($permission);
                }
            }
        }
        $em->merge($permission);
        $em->flush();
    }
    public function removePermission($id)
    {
        if (!$id||!is_numeric($id)) {
            return true;
        }
        $em=$this->getEntityManager();
        $permission = $this->getPermission($id);
        $em->remove($permission);
        $em->flush();
    }
    public function getUser()
    {
        $authenticationService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $loggedUser = $authenticationService->getIdentity();
    }
    public function isAllowed($needed)
    {
        $acl = $this->getACL();
        $loggedUser = $this->getUser();
        if ($loggedUser) {
            if (is_object($loggedUser->roles)) {
                $allowed_all=$loggedUser->roles->allowed_all;
                if (isset($allowed_all[0])&&$allowed_all[0]==="master") {
                    return true;
                }
                if ($acl->isAllowed($loggedUser->roles->name, $needed)) {
                    return true;
                }
            }
            foreach ($loggedUser->group as $group) {
                if ($acl->isAllowed($group->roles->name, $needed)) {
                     return true;
                }
            }
        } else {
            if ($acl->isAllowed('Guest', $needed)) {
                 return true;
            }
        }

        return false;
    }

}
