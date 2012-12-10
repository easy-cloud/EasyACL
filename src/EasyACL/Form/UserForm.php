<?php
namespace EasyACL\Form;

use Zend\Form\Form;

class UserForm extends Form
{
    public function __construct($em, $groups="", $name = 'form')
    {
        parent::__construct('form');
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
           'name'       => 'surname',
           'attributes' => array(
                   'type'		=> 'text',
               ),
           'options'	=> array(
                   'label'		=> 'Surname',
               ),
           ));

           $this->add(array(
           'name'       => 'email',
           'attributes' => array(
                   'type'		=> 'email',
               ),
           'options'	=> array(
                   'label'		=> 'E-Mail',
               ),
           ));

        $this->add(array(
           'name'       => 'password',
           'attributes' => array(
                   'type'		=> 'password',
               ),
           'options'	=> array(
                   'label'		=> 'Password',
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

        if (is_object($groups)) {
               foreach ($groups as $group) {
                   $this->add(array(
                   'name'       => 'groups[]',
                   'type'          => 'Zend\Form\Element\Hidden',
                   'attributes' => array(
                           'type'		=> 'hidden',
                           'value' 	=> $group->id,
                       ),
                   ));
                   $this->add(array(
                   'name'       => 'group[]',
                   'type'          => 'Zend\Form\Element\Text',
                   'attributes' => array(
                           'value'		=> $group->getName(),
                           'disabled'	=> 'disabled',
                           'data-id'	=> $group->id,
                       ),
                   'options'	=> array(
                           'label'		=> 'Group',
                           'appendIcon'   => 'icon-remove',
                       ),
                   ));
            }
        }

        $this->add(array(
            'name' => 'groups[]',
            'type' => 'DoctrineORMModule\Form\Element\DoctrineEntity',
            'attributes' => array(
                'class' => 'extras',
            ),
            'options' => array(
                'label' => 'Group',
                'object_manager' => $em,
                'target_class'   => '\EasyACL\Entity\Group',
                'property'       => 'name'
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
