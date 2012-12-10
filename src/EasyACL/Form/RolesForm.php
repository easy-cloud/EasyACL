<?php
namespace EasyACL\Form;

use Zend\Form\Form;

class RolesForm extends Form
{
    public function __construct($em, $name = 'roles')
    {
        parent::__construct('roles');
        $this->setAttribute('method', 'post');
        $this->add(array(
           'name'       => 'id',
           'attributes' => array(
                   'type'		=> 'hidden',
               ),
           ));
        $this->add(array(
           'name'       => 'name',
           'attributes' => array(
                   'type'		=> 'text',
               ),
           'options'	=> array(
                   'label'		=> 'Name',
               ),
           ));

        $this->add(array(
            'name' => 'user_id',
            'type' => 'DoctrineORMModule\Form\Element\DoctrineEntity',
            'options' => array(
                'label' => 'User',
                'object_manager' => $em,
                'target_class'   => '\ACL\Entity\User',
                'property'       => 'name'
            ),
        ));

        $this->add(array(
            'name' => 'group_id',
            'type' => 'DoctrineORMModule\Form\Element\DoctrineEntity',
            'options' => array(
                'label' => 'Group',
                'object_manager' => $em,
                'target_class'   => '\ACL\Entity\Group',
                'identifier'     => 'id',
                'property'       => 'name'
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));

        $this->add(array(
            'name' => 'reset',
            'attributes' => array(
                'type'  => 'reset',
                'value' => 'Cancel',
                'id' => 'resetbutton',
                'class' => 'btn red-btn',
            ),
        ));
    }
}
