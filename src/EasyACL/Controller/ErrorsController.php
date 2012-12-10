<?php

namespace EasyACL\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ErrorsController extends AbstractActionController
{
    public function norightsAction()
    {
        return new ViewModel();
    }
}
