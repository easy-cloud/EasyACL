<?php
namespace ACL;
return array(
    'router' => array(
        'routes' => array(
            'acl\user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/user[/:action][/:id]',
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
                    'route'    => '/admin/login',
                    'defaults' => array(
                        'controller' => 'ACL\Controller\User',
                        'action'     => 'login',
                    ),
                ),
            ),
            'acl\logout' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/logout',
                    'defaults' => array(
                        'controller' => 'ACL\Controller\User',
                        'action'     => 'logout',
                    ),
                ),
            ),
            'acl\group' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/group[/:action][/:id]',
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
                    'route'    => '/admin/roles[/:action][/:id]',
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
                    'route'    => '/admin/permission[/:action][/:id]',
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