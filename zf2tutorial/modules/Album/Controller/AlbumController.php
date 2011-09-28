<?php

namespace Album\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\Mvc\Router\RouteStack,
    Album\Model\DbTable\Albums,
    Album\Form\Album as AlbumForm;

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

    public function addAction()
    {
        $form = new AlbumForm();
        $form->submit->setLabel('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $artist = $form->getValue('artist');
                $title = $form->getValue('title');
                $this->albums->addAlbum($artist, $title);

                // Redirect to list of albums
                $url = $this->router->assemble(
                    array('controller' => 'album', 'action' => 'index'),
                    array('name' => 'default')
                );
                $this->response->setStatusCode(302);
                $this->response->headers()->addHeaderLine('Location', $url);
                return $this->response;
            } else {
                $form->populate($formData);
            }
        }

        return array('form' => $form);
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
