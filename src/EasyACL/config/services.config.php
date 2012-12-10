<?php
return array(
    'service_manager'=>array(
        'factories' => array(
            'user.service'=> function(){
                return new Service\User(array('model'=>'EasyACL\Entity\User'));
            },
            'roles.service'=> function(){
                return new Service\Roles(array('model'=>'EasyACL\Entity\Roles'));
            },
            'group.service'=> function(){
                return new Service\Group(array('model'=>'EasyACL\Entity\Group'));
            },
            'permission.service'=> function(){
                return new Service\Permission(array('model'=>'EasyACL\Entity\Permission'));
            },
        ),
    ),
);
