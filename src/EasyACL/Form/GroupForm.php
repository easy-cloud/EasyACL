<?php
namespace EasyACL\Form;

use Zend\Form\Form;

class GroupForm extends Form
{
    public function __construct($name = 'form')
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
