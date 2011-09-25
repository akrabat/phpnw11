<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initLogger()
    {
        try {
            $this->bootstrap('log');
            $logger = $this->getResource('log');
            if ($logger) {
                Zend_Registry::set('logger', $logger);
            }
        } catch (Zend_Application_Bootstrap_Exception $e) {

        }
    }
    
}

