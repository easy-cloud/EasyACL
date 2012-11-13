<?php
namespace ACL;
return array(
    'router' => array(
        'routes' => array(
            'acl\user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/acl/user[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ACL\Controller\User',
                        'action'     => 'index',
                    ),
                ),
            ),
            'acl\login' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/acl/login',
                    'defaults' => array(
                        'controller' => 'ACL\Controller\User',
                        'action'     => 'login',
                    ),
                ),
            ),
            'acl\logout' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/acl/logout',
                    'defaults' => array(
                        'controller' => 'ACL\Controller\User',
                        'action'     => 'logout',
                    ),
                ),
            ),
            'acl\group' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/acl/group[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ACL\Controller\Group',
                        'action'     => 'index',
                    ),
                ),
            ),
            'acl\roles' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/acl/roles[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ACL\Controller\Roles',
                        'action'     => 'index',
                    ),
                ),
            ),
            'acl\permission' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/acl/permission[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ACL\Controller\Permission',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
);
