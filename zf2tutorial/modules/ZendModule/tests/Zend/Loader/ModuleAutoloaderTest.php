<?php

namespace ZendTest\Loader\ModuleAutoloaderTest;

use PHPUnit_Framework_TestCase as TestCase,
    Zend\Loader\ModuleAutoloader,
    InvalidArgumentException;

class ManagerTest extends TestCase
{
    public function setUp()
    {
        // Store original autoloaders
        $this->loaders = spl_autoload_functions();
        if (!is_array($this->loaders)) {
            // spl_autoload_functions does not return empty array when no
            // autoloaders registered...
            $this->loaders = array();
        }

        // Store original include_path
        $this->includePath = get_include_path();
    }

    public function tearDown()
    {
        // Restore original autoloaders
        $loaders = spl_autoload_functions();
        if (is_array($loaders)) {
            foreach ($loaders as $loader) {
                spl_autoload_unregister($loader);
            }
        }

        foreach ($this->loaders as $loader) {
            spl_autoload_register($loader);
        }

        // Restore original include_path
        set_include_path($this->includePath);
    }

    public function testCanRegisterPathsFromConstructor()
    {
        $paths = array(__DIR__ . '/TestAsset/');
        $loader = new ModuleAutoloader($paths);
        $registeredPaths = $loader->getPaths();
        $this->assertSame($paths, $registeredPaths);
    }

    public function testPathsNormalizedWithTrailingSlash()
    {
        $paths = array(
            __DIR__ . DIRECTORY_SEPARATOR . 'TestAsset',
            __DIR__ . DIRECTORY_SEPARATOR . 'TestAsset///',
            __DIR__ . DIRECTORY_SEPARATOR . 'TestAsset\\\\',
        );
        $loader = new ModuleAutoloader($paths);
        $registeredPaths = $loader->getPaths();
        $this->assertSame(__DIR__ . DIRECTORY_SEPARATOR . 'TestAsset' . DIRECTORY_SEPARATOR, $registeredPaths[0]);
        $this->assertSame(__DIR__ . DIRECTORY_SEPARATOR . 'TestAsset' . DIRECTORY_SEPARATOR, $registeredPaths[1]);
        $this->assertSame(__DIR__ . DIRECTORY_SEPARATOR . 'TestAsset' . DIRECTORY_SEPARATOR, $registeredPaths[2]);
    }

    public function testCanAutoloadModule()
    {
        $loader = new ModuleAutoloader;
        $loader->registerPath(__DIR__ . '/TestAsset/');
        $moduleClass = $loader->autoload('FooModule\Module');
        $this->assertSame('FooModule\Module', $moduleClass);
        $module = new \FooModule\Module;
        $this->assertInstanceOf('FooModule\Module', $module);
    }

    public function testCanAutoloadSubModule()
    {
        $loader = new ModuleAutoloader;
        $loader->registerPath(__DIR__ . '/TestAsset/');
        $loader->register();
        $subModule = new \FooModule\SubModule\Module;
        $this->assertInstanceOf('FooModule\SubModule\Module', $subModule);
        $loader->unregister();
    }

    public function testCanAutoloadPharModules()
    {
        $loader = new ModuleAutoloader;
        $loader->registerPath(__DIR__ . '/TestAsset/');
        $loader->register();
        $this->assertTrue(class_exists('PharModule\Module'));
        $this->assertTrue(class_exists('PharModuleGz\Module'));
        $this->assertTrue(class_exists('PharModuleBz2\Module'));
        $this->assertTrue(class_exists('PharModulePharTar\Module'));
        $this->assertTrue(class_exists('PharModulePharTarGz\Module'));
        $this->assertTrue(class_exists('PharModulePharTarBz2\Module'));
        $this->assertTrue(class_exists('PharModulePharZip\Module'));
        $this->assertTrue(class_exists('PharModuleTar\Module'));
        $this->assertTrue(class_exists('PharModuleTarGz\Module'));
        $this->assertTrue(class_exists('PharModuleTarBz2\Module'));
        $this->assertTrue(class_exists('PharModuleZip\Module'));
        $loader->unregister();
    }

    public function testProvidesFluidInterface()
    {
        $loader = new ModuleAutoloader;
        $this->assertInstanceOf('Zend\Loader\ModuleAutoloader', $loader->setOptions(array('foo')));
        $this->assertInstanceOf('Zend\Loader\ModuleAutoloader', $loader->registerPaths(array('foo')));
        $this->assertInstanceOf('Zend\Loader\ModuleAutoloader', $loader->registerPath('foo'));
    }

    public function testReturnsFalseForNonModuleClass()
    {
        $loader = new ModuleAutoloader;
        $loader->registerPath(__DIR__ . '/TestAsset/');
        $moduleClass = $loader->autoload('FooModule\NotModule');
        $this->assertFalse($moduleClass);
    }

    public function testReturnsFalseForNonExistantModuleClass()
    {
        $loader = new ModuleAutoloader;
        $loader->registerPath(__DIR__ . '/TestAsset/');
        $moduleClass = $loader->autoload('NonExistantModule\Module');
        $this->assertFalse($moduleClass);
    }

    public function testReturnsFalseForNonModulePhar()
    {
        $loader = new ModuleAutoloader;
        $loader->registerPath(__DIR__ . '/TestAsset/');
        $moduleClass = $loader->autoload('PharModuleFake\Module');
        $this->assertFalse($moduleClass);
    }

    public function testInvalidPathThrowsException()
    {
        $loader = new ModuleAutoloader;
        $this->setExpectedException('InvalidArgumentException');
        $loader->registerPath(123);
    }

    public function testInvalidPathsThrowsException()
    {
        $loader = new ModuleAutoloader;
        $this->setExpectedException('InvalidArgumentException');
        $loader->registerPaths(123);
    }
}
