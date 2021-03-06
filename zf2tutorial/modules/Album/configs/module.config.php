<?php
$production = array(
    'di' => array( 'instance' => array(
        'alias' => array(
            'album'        => 'Album\Controller\AlbumController',
        ),

        'Album\Controller\AlbumController' => array(
            'parameters' => array(
                'table'  => 'Album\Model\DbTable\Albums',
            ),
        ),

        'Album\Model\DbTable\Albums' => array(
            'parameters' => array(
                'config' => 'Zend\Db\Adapter\Pdo\Sqlite',
        )),

        'Zend\Db\Adapter\Pdo\Sqlite' => array(
            'parameters' => array(
                'config' => array('dbname' => __DIR__ . '/../../../data/data.sqlite'),
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
