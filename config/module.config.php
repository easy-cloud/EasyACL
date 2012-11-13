<?php
namespace ACL;
return array(
    'controllers' => array(
        'invokables' => array(
            'ACL\Controller\User' => 'ACL\Controller\UserController',
            'ACL\Controller\Roles' => 'ACL\Controller\RolesController',
            'ACL\Controller\Group' => 'ACL\Controller\GroupController',
            'ACL\Controller\Permission' => 'ACL\Controller\PermissionController',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'orm_default' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Entity')
            ),
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'identity_class' => 'ACL\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => function($user, $passwordGiven) {
                    $bcrypt = new \Zend\Crypt\Password\Bcrypt();
                    $bcrypt->setSalt(51292170314052011201451452855644564);
                    $passwordGiven=$bcrypt->create($passwordGiven);

                    return ($user->password === $passwordGiven?true:false);
                },
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'acl' => __DIR__ . '/../view',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'Permission' => 'ACL\Plugin\Permission',
        )
    ),
);
