<?php
namespace ACL\Form;

use Zend\Form\Form;

class PermissionsForm extends Form
{
    public $permissions;
    public $actions;
    public function __construct($permissions, $actions, $currentPermissions=array(), $name = 'form')
    {
        $this->permissions=$permissions;
        $this->actions=$actions;
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        $this->add(array(
           'name'       => 'id',
           'attributes' => array(
                   'type'		=> 'hidden',
               ),
           ));
        foreach ($permissions as  $key=>$permission) {
            foreach ($permission as $pkey=>$subpermission) {
                foreach ($subpermission as $spkey=>$id) {
                    $this->add(array(
                       'name' => $id,
                       'type' => 'Zend\Form\Element\Checkbox',
                       'attributes'	=> array(
                               'data-namespace' => $key,
                               'data-controller' => $pkey,
                               'data-action' => $spkey,
                               'checked'		=> (in_array($id, $currentPermissions)?'checked':''),
                           )
                       ));
                }
            }
        }

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
