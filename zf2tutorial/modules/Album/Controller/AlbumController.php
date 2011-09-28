<?php

namespace Album\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\Mvc\Router\RouteStack,
    Album\Model\DbTable\Albums;

class AlbumController extends ActionController
{
    /**
     *
     * @var Album\Model\DbTable\Albums
     */
    protected $albums;

    public function indexAction()
    {
        return array(
            'title' => 'My Albums',
            'content' => '',
            'albums' => $this->albums->fetchAll(),
        );
    }

    public function setTable(Albums $table)
    {
        $this->albums = $table;
        return $this;
    }

    public function setRouter(RouteStack $router)
    {
        $this->router = $router;
        return $this;
    }

}
