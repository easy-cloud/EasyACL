<?php
namespace EasyACL;
return array(
    'router' => array(
        'routes' => array(
            'acl' => array(
                'type'      => 'Literal',
                'options'   => array(
                    'route'     => '/acl',
                    'defaults'  => array(
                        '__NAMESPACE__' => 'ACL\Controller',
                        'controller'    => 'User',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'users' => array(
                        'type'      => 'literal',
                        'options'   => array(
                            'route'     => '/users',
                            'defaults'  => array(
                                'controller'    => 'ACL\Controller\User',
                                'action'        => 'index'
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes'  => array(
                            'add' => array(
                                'type'      => 'literal',
                                'options'   => array(
                                    'route'     => '/add',
                                    'defaults'  => array(
                                        'controller'    => 'ACL\Controller\User',
                                        'action'        => 'add'
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'edit' => array(
                                'type'      => 'segment',
                                'options'   => array(
                                    'route'     => '/edit/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults'  => array(
                                        'controller'    => 'ACL\Controller\User',
                                        'action'        => 'edit'
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'remove' => array(
                                'type'      => 'segment',
                                'options'   => array(
                                    'route'     => '/remove/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults'  => array(
                                        'controller'    => 'ACL\Controller\User',
                                        'action'        => 'remove'
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                        ),
                    ),
                    'login' => array(
                        'type'      => 'literal',
                        'options'   => array(
                            'route'     => '/login',
                            'defaults'  => array(
                                'controller'    => 'ACL\Controller\User',
                                'action'        => 'login'
                            ),
                        ),
                        'may_terminate' => true
                    ),
                    'logout' => array(
                        'type'      => 'literal',
                        'options'   => array(
                            'route'     => '/logout',
                            'defaults'  => array(
                                'controller'    => 'ACL\Controller\User',
                                'action'        => 'logout'
                            ),
                        ),
                        'may_terminate' => true
                    ),
                    'groups' => array(
                        'type'      => 'literal',
                        'options'   => array(
                            'route'     => '/groups',
                            'defaults'  => array(
                                'controller'    => 'ACL\Controller\Group',
                                'action'        => 'index'
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes'  => array(
                            'add' => array(
                                'type'      => 'literal',
                                'options'   => array(
                                    'route'     => '/add',
                                    'defaults'  => array(
                                        'controller'    => 'ACL\Controller\Group',
                                        'action'        => 'add'
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'edit' => array(
                                'type'      => 'segment',
                                'options'   => array(
                                    'route'     => '/edit/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults'  => array(
                                        'controller'    => 'ACL\Controller\Group',
                                        'action'        => 'edit'
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'remove' => array(
                                'type'      => 'segment',
                                'options'   => array(
                                    'route'     => '/remove/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults'  => array(
                                        'controller'    => 'ACL\Controller\Group',
                                        'action'        => 'remove'
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                        ),
                    ),
                    'roles' => array(
                        'type'      => 'literal',
                        'options'   => array(
                            'route'     => '/roles',
                            'defaults'  => array(
                                'controller'    => 'ACL\Controller\Roles',
                                'action'        => 'index'
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes'  => array(
                            'add' => array(
                                'type'      => 'literal',
                                'options'   => array(
                                    'route'     => '/add',
                                    'defaults'  => array(
                                        'controller'    => 'ACL\Controller\Roles',
                                        'action'        => 'add'
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'edit' => array(
                                'type'      => 'segment',
                                'options'   => array(
                                    'route'     => '/edit/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults'  => array(
                                        'controller'    => 'ACL\Controller\Roles',
                                        'action'        => 'edit'
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'remove' => array(
                                'type'      => 'segment',
                                'options'   => array(
                                    'route'     => '/remove/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults'  => array(
                                        'controller'    => 'ACL\Controller\Roles',
                                        'action'        => 'remove'
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'rights' => array(
                                'type'      => 'segment',
                                'options'   => array(
                                    'route'     => '/rights/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults'  => array(
                                        'controller'    => 'ACL\Controller\Roles',
                                        'action'        => 'rights'
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                        ),
                    ),
                    'permission' => array(
                        'type'      => 'literal',
                        'options'   => array(
                            'route'     => '/permission',
                            'defaults'  => array(
                                'controller'    => 'ACL\Controller\Permission',
                                'action'        => 'index'
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes'  => array(
                            'remove' => array(
                                'type'      => 'segment',
                                'options'   => array(
                                    'route'     => '/remove/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults'  => array(
                                        'controller'    => 'ACL\Controller\Permission',
                                        'action'        => 'remove'
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                        ),
                    ),
                    'norights' => array(
                        'type'      => 'literal',
                        'options'   => array(
                            'route'     => '/norights',
                            'defaults'  => array(
                                'controller'    => 'ACL\Controller\Errors',
                                'action'        => 'norights'
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                ),
            ),
        ),
    ),
);
