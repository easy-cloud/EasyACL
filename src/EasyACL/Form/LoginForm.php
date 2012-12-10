<?php
namespace ACL\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = 'form')
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');

           $this->add(array(
           'name'       => 'email',
           'attributes' => array(
                   'type'		=> 'text',
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
                'value' => 'Login',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}
