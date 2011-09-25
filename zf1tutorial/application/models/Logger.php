<?php

class Application_Model_Logger
{
    function log($message) 
    {
        if (Zend_Registry::isRegistered('logger')) {
            if(is_sz($message) || is_array($message)) {
                $message = var_export($message, true);
            }
            Zend_Registry::get('logger')->log($message, $level);
        }
    }
}
