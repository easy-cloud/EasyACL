<?php
namespace EasyCloud\EasyACL;
return array(
    'service_manager'=>array(
        'factories' => array(
            'user.service'=> function(){
                return new Service\User(array('model'=>'ACL\Entity\User'));
            },
            'roles.service'=> function(){
                return new Service\Roles(array('model'=>'ACL\Entity\Roles'));
            },
            'group.service'=> function(){
                return new Service\Group(array('model'=>'ACL\Entity\Group'));
            },
            'permission.service'=> function(){
                return new Service\Permission(array('model'=>'ACL\Entity\Permission'));
            },
        ),
    ),
);
