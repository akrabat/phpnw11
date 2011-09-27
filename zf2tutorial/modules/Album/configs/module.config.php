<?php
$production = array(
    'di' => array( 'instance' => array(
        'alias' => array(
            'album'        => 'Album\Controller\AlbumController',
//            'album-db'     => 'Zend\Db\Adapter\Pdo\Sqlite',
//            'album-mapper' => 'Album\Model\AlbumMapper',
//            'album-table'  => 'Album\Model\DbTable\Album',
        ),

        'preferences' => array(
            'Zend\Mvc\Router\RouteStack' => 'Zend\Mvc\Router\SimpleRouteStack',
        ),

        'Album\Controller\AlbumController' => array(
            'parameters' => array(
                'mapper' => 'Album\Model\AlbumMapper',
                'router' => 'Zend\Mvc\Router\SimpleRouteStack',
            ),
        ),

        'Album\Model\AlbumMapper' => array(
            'parameters' => array(
                'dbTable' => 'Album\Model\DbTable\Album',
        )),

        'Album\Model\DbTable\Album' => array(
            'parameters' => array(
                'config' => 'Zend\Db\Adapter\Pdo\Sqlite',
        )),

        'Zend\Db\Adapter\Pdo\Sqlite' => array(
            'parameters' => array(
                'config' => array('dbname' => __DIR__ . '/../data/Album.db'),
        )),

        'Zend\View\PhpRenderer' => array(
            'methods' => array(
                'setResolver' => array(
                    'resolver' => 'Zend\View\TemplatePathStack',
                    'options' => array(
                        'script_paths' => array(
                            'Album' => __DIR__ . '/../views',
                        ),
                    ),
            ),
        )),
    )),
);

$staging     = $production;
$testing     = $production;
$development = $production;

$config = compact('production', 'staging', 'testing', 'development');
return $config;
