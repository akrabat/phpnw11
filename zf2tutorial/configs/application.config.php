<?php
return new Zend\Config\Config(array(
    'module_paths' => array(
        realpath(__DIR__ . '/../modules'),
    ),
    'modules' => array(
        'ZendModule', // paradox?!
        'ZendMvc',
        'Album',
        'Application', // load last
    ),
    'module_config' => array( 
        'cache_config'  => false,
        'cache_dir'     => realpath(__DIR__ . '/../data/cache'),
    ),
));
