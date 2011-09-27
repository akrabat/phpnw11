<?php

namespace Album\Controller;

use Zend\Mvc\Controller\ActionController;

class AlbumController extends ActionController
{
    public function indexAction()
    {
        return array(
            'title' => 'My Albums',
            'content' => ''
            );
    }


}
