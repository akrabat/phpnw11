<?php

class Application_Model_Logger
{
    static function log($message, $level=6) 
    {
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        if (!$bootstrap->hasPluginResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');

        if(is_object($message) || is_array($message)) {
            $message = var_export($message, true);
        }
        $log->log($message, $level);
    }
}
