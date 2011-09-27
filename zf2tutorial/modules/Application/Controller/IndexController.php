<?php

namespace Application\Controller;

use Zend\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    public function indexAction()
    {
        return array(
            'title' => 'Welcome!',
            'content' => 'IT WORKS & all is good! 100 > 99'
            );
    }

    public function triggerErrorAction()
    {
        throw new \Exception('Triggering an error to test error handling');
    }
}
